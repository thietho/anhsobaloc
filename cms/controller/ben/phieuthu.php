<?php
class ControllerBenPhieuthu extends Controller
{
	private $error = array();
   	function __construct() 
	{
	 	$this->load->model("ben/thuchi");
		
   	}
	
	public function index()
	{
		$this->getList();
	}
	
	public function insert()
	{
    	$this->getForm();
	}
	
	public function update()
	{
		$this->data['haspass'] = false;
		$this->data['readonly'] = 'readonly="readonly"';
		$this->data['class'] = 'readonly';	
		$this->getForm();
  	}
	
	
	
	public function delete() 
	{
		$listmaphieu=$this->request->post['delete'];
		
		if(count($listmaphieu))
		{
			foreach($listmaphieu as $maphieu)
			{
				$this->model_ben_thuchi->delete($maphieu);	
			}
			$this->data['output'] = "true";
		}
		$this->id="content";
		$this->template="common/output.tpl";
		$this->render();
  	}
	
	private function getList() 
	{
		$this->data['insert'] = $this->url->http('ben/phieuthu/insert');
		$this->data['delete'] = $this->url->http('ben/phieuthu/delete');		
		
		$this->data['datas'] = array();
		$where = "";
		$data = $this->request->get;
		foreach($data as $key =>$val)
		{
			$data[$key] = urldecode($val);	
		}
		$_GET = $data;
		if(trim($data['sobiennhan']))
		{
			$where .= " AND sobiennhan like '".$data['sobiennhan']."'";
		}
		
		if(trim($data['tungay']))
		{
			$where .= " AND ngaylap >= '".$this->date->formatViewDate($data['tungay'])."'";
		}
		
		if(trim($data['denngay']))
		{
			$where .= " AND ngaylap <= '".$this->date->formatViewDate($data['denngay'])."'";
		}
		
		if(trim($data['tenkhachhang']))
		{
			$where .= " AND tenkhachhang like '%".$data['tenkhachhang']."%'";
		}
		
		if(trim($data['sotientu']))
		{
			$where .= " AND tongtien >= '".$this->string->toNumber($data['sotientu'])."'";
		}
		
		if(trim($data['sotienden']))
		{
			$where .= " AND tongtien <= '".$this->string->toNumber($data['sotienden'])."'";
		}
		
		if(trim($data['tinhtrang']))
		{
			$where .= " AND tinhtrang like '".$data['tinhtrang']."'";
		}
		
		$where .= " Order by ngaylap DESC";
		$rows = $this->model_ben_thuchi->getList($where);
		//Page
		$page = $this->request->get['page'];		
		$x=$page;
		$limit = 20;
		$total = count($rows); 
		// work out the pager values 
		$this->data['pager']  = $this->pager->pageLayout($total, $limit, $page); 
		
		$pager  = $this->pager->getPagerData($total, $limit, $page); 
		$offset = $pager->offset; 
		$limit  = $pager->limit; 
		$page   = $pager->page;
		for($i=$offset;$i < $offset + $limit && count($rows[$i])>0;$i++)
		//for($i=0; $i <= count($this->data['datas'])-1 ; $i++)
		//for($i=0;$i < count($rows[$i]);$i++)
		{
			$this->data['datas'][$i] = $rows[$i];
			$this->data['datas'][$i]['link_edit'] = $this->url->http('ben/phieuthu/update&maphieu='.$this->data['datas'][$i]['maphieu']);
			$this->data['datas'][$i]['text_edit'] = "Edit";
			
			
			
		}
		
		$this->id='content';
		$this->template="ben/phieuthu_list.tpl";
		$this->layout='layout/center';
		
		$this->render();
	}
	
	
	private function getForm()
	{		
		
		if ((isset($this->request->get['maphieu'])) ) 
		{
      		$this->data['item'] = $this->model_ben_thuchi->getItem($this->request->get['maphieu']);
			$where = " AND maphieu = '".$this->request->get['maphieu']."'";
			$this->data['data_chitiet'] = $this->model_ben_thuchi->getBienNhanChiTietList($where);
			
    	}
		else
		{
			$this->data['item']['ngaylap'] = $this->date->getToday();
		}
		
		$this->id='content';
		$this->template='ben/phieuthu_form.tpl';
		$this->layout='layout/center';
		$this->render();
	}
	
	public function view()
	{
		$this->data['item'] = $this->model_ben_thuchi->getItem($this->request->get['maphieu']);
		$where = " AND maphieu = '".$this->request->get['maphieu']."'";
		$this->data['data_chitiet'] = $this->model_ben_thuchi->getBienNhanChiTietList($where);
		$this->id='content';
		$this->template='ben/phieuthu_view.tpl';
		if($_GET['dialog']=='print')
		{
			$this->layout='layout/print';
		}
		$this->render();
	}
	
	public function updateTinhTrang()
	{
		$data = $this->request->post;
		$this->model_ben_thuchi->updateCol($data['maphieu'],'tinhtrang',$data['tinhtrang']);
		$this->data['output'] = "true";
		$this->id='content';
		$this->template='common/output.tpl';
		$this->render();
	}
	
	public function save()
	{
		$data = $this->request->post;
		
		if($this->validateForm($data))
		{
			
			if($data['maphieu']=="")
			{
				if($data['khachhangid'] == "")
				{
					$this->load->model('core/user');
					$user['fullname'] = $data['tenkhachhang'];
					$user['phone'] = $data['sodienthoai'];
					$user['email'] = $data['email'];
					$user['address'] = $data['diachi'];
					$data['khachhangid'] = $this->model_core_user->insertUser($user);
					
					$this->model_core_user->updateCol($data['khachhangid'],'status','active');
					$this->model_core_user->updateCol($data['khachhangid'],'usertypeid','member');
				}
				$data['maphieu'] = $this->model_ben_thuchi->insert($data);	
			}
			else
			{
				$this->model_ben_thuchi->update($data);	
			}
			//Xoa chi tiet bien nhan
			if($data['delchitietid']!="")
			{
				$arr_idct = split(',',$data['delchitietid']);
				foreach($arr_idct as $id)
				{
					$this->model_ben_thuchi->deleteBienNhanChiTiet($id);	
				}
			}
			
			//Luu chi tiet bien nhan
			$arr_id = $data['id'];
			$arr_dichvuid = $data['dichvuid'];
			$arr_sotien = $data['sotien'];
			$arr_ghichu = $data['ghichuct'];
			$sum = 0;
			foreach($arr_dichvuid as $key => $dichvuid)
			{
				$ct['id'] = $arr_id[$key];
				$ct['maphieu'] = $data['maphieu'];
				$ct['dichvuid'] = $dichvuid;
				$ct['tendichvu'] = $this->document->getDichVu($dichvuid);
				$ct['sotien'] = $arr_sotien[$key];
				$ct['ghichu'] = $arr_ghichu[$key];
				$ct['ngaylap'] = $data['ngaylap'];
				$this->model_ben_thuchi->saveBienNhanChiTiet($ct);
				$sum +=$this->string->toNumber($ct['sotien']);
			}
			$tongtien = $sum - $this->string->toNumber($data['giamgia']);
			$this->model_ben_thuchi->updateCol($data['maphieu'],'tongcong',$sum);
			$this->model_ben_thuchi->updateCol($data['maphieu'],'tongtien',$tongtien);
			
			$this->data['output'] = "true-".$data['maphieu'];
		}
		else
		{
			foreach($this->error as $item)
			{
				$this->data['output'] .= $item."<br>";
			}
		}
		
		$this->id='content';
		$this->template='common/output.tpl';
		$this->render();
	}
	
	private function validateForm($data)
	{
		
		if (trim($data['tenkhachhang']) == "") 
		{
      		$this->error['tenkhachhang'] = "Bạn chưa nhập tên khách hàng";
    	}
		
		if (trim($data['sodienthoai']) == "") 
		{
      		$this->error['sodienthoai'] = "Bạn chưa nhập tên khách hàng";
    	}
		
		if (trim($data['email']) != "") 
		{
      		if ($this->validation->_checkEmail($data['email']) == false )
				$this->error["email"] = "Email không đúng định dạng";
    	}
		
		if (count($this->error)==0) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
	}
	
}
?>