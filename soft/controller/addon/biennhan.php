<?php
class ControllerAddonBiennhan extends Controller
{
	private $error = array();
   	function __construct() 
	{
		$this->load->model("addon/dichvu");
	 	$this->load->model("addon/biennhan");
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
		$listbiennhanid=$this->request->post['delete'];
		
		if(count($listbiennhanid))
		{
			foreach($listbiennhanid as $biennhanid)
			{
				$this->model_addon_biennhan->delete($biennhanid);	
			}
			$this->data['output'] = "true";
		}
		$this->id="content";
		$this->template="common/output.tpl";
		$this->render();
  	}
	
	private function getList() 
	{
		$this->data['insert'] = $this->url->http('addon/biennhan/insert');
		$this->data['delete'] = $this->url->http('addon/biennhan/delete');		
		
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
		$rows = $this->model_addon_biennhan->getList($where);
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
			$this->data['datas'][$i]['link_edit'] = $this->url->http('addon/biennhan/update&biennhanid='.$this->data['datas'][$i]['biennhanid']);
			$this->data['datas'][$i]['text_edit'] = "Edit";
			$this->data['datas'][$i]['datra'] = $this->model_addon_biennhan->getDatra($this->data['datas'][$i]['biennhanid']);
			
			
		}
		
		$this->id='content';
		$this->template="addon/biennhan_list.tpl";
		$this->layout=$this->user->getLayout();
		
		$this->render();
	}
	
	
	private function getForm()
	{		
		
		if ((isset($this->request->get['biennhanid'])) ) 
		{
      		$this->data['item'] = $this->model_addon_biennhan->getItem($this->request->get['biennhanid']);
			$where = " AND biennhanid = '".$this->request->get['biennhanid']."'";
			$this->data['data_chitiet'] = $this->model_addon_biennhan->getBienNhanChiTietList($where);
			
    	}
		else
		{
			$where .= " Order by dichvuid";
			$this->data['data_chitiet'] = $this->model_addon_dichvu->getList($where);
			$this->data['item']['ngaylap'] = $this->date->getToday();
		}
		
		$this->id='content';
		$this->template='addon/biennhan_form.tpl';
		$this->layout=$this->user->getLayout();
		$this->render();
	}
	
	public function view()
	{
		$biennhanid = $this->request->get['biennhanid'];
		$this->data['item'] = $this->model_addon_biennhan->getItem($biennhanid);
		$where = " AND biennhanid = '".$this->request->get['biennhanid']."'";
		$this->data['data_chitiet'] = $this->model_addon_biennhan->getBienNhanChiTietList($where);
		//Da tra
		$this->data['datra'] = $this->model_addon_biennhan->getDatra($biennhanid);
		
		$this->id='content';
		$this->template='addon/biennhan_view.tpl';
		if($_GET['dialog']=='print')
		{
			$this->layout='layout/print';
		}
		$this->render();
	}
	
	public function updateTinhTrang()
	{
		$data = $this->request->post;
		$this->model_addon_biennhan->updateCol($data['biennhanid'],'tinhtrang',$data['tinhtrang']);
		$this->data['output'] = "true";
		$this->id='content';
		$this->template='common/output.tpl';
		$this->render();
	}
	
	public function thanhtoan()
	{
		$data = $this->request->post;
		
		if($this->validateFormThanhToan($data))
		{
						
			$biennhan = $this->model_addon_biennhan->getItem($data['biennhanid']);
			
			//Xuat phieu thu tien tam ung
			$phieuthu['prefix'] = "PT";
			$phieuthu['loaithuchi'] = "thu";
			$phieuthu['taikhoanthuchi'] = "thutienbienlai";
			$phieuthu['chungtulienquan'] = $biennhan['sobiennhan'];
			$phieuthu['makhachhang'] = $biennhan['khachhangid'];
			$phieuthu['tenkhachhang'] = $biennhan['tenkhachhang'];
			$phieuthu['diachi'] = $biennhan['diachi'];
			$phieuthu['email'] = $biennhan['sobiennhan'];
			$phieuthu['dienthoai'] = $biennhan['sodienthoai'];
			$phieuthu['email'] = $biennhan['email'];
			$phieuthu['sotien'] = $this->string->toNumber($data['thanhtoan']);
			$phieuthu['donvi'] = 'VND';
			$phieuthu['quidoi'] = $this->document->toVND($this->string->toNumber($phieuthu['sotien']),$phieuthu['donvi']);
			$phieuthu['lydo'] = "Thu tiền biên nhận ".$biennhan['sobiennhan'];
			$phieuthu['nguongoc'] = $biennhan['biennhanid'];
			$phieuthu['maphieu'] = $this->model_ben_thuchi->insert($phieuthu);	
				
			
			$this->data['output'] = "true";
		}
		else
		{
			foreach($this->error as $item)
			{
				$this->data['output'] .= $item."\n";
			}
		}
		
		$this->id='content';
		$this->template='common/output.tpl';
		$this->render();
	}
	
	private function validateFormThanhToan($data)
	{
		$biennhan = $this->model_addon_biennhan->getItem($data['biennhanid']);
		if (trim($data['thanhtoan']) == 0) 
		{
      		$this->error['thanhtoan'] = "Bạn chưa nhập số tiền thanh toán";
    	}
		
		
		if (count($this->error)==0) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
	}
	
	public function save()
	{
		$data = $this->request->post;
		
		if($this->validateForm($data))
		{
			
			if($data['biennhanid']=="")
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
				$data['biennhanid'] = $this->model_addon_biennhan->insert($data);
			}
			else
			{
				$this->model_addon_biennhan->update($data);	
			}
			if($data['tamung']>0 )
			{
				$biennhan = $this->model_addon_biennhan->getItem($data['biennhanid']);
				if($biennhan['maphieuthutamung']=="")
				{
					//Xuat phieu thu tien tam ung
					$phieuthu['prefix'] = "PT";
					$phieuthu['loaithuchi'] = "thu";
					$phieuthu['taikhoanthuchi'] = "thutamungbienlai";
					$phieuthu['chungtulienquan'] = $biennhan['sobiennhan'];
					$phieuthu['makhachhang'] = $biennhan['khachhangid'];
					$phieuthu['tenkhachhang'] = $biennhan['tenkhachhang'];
					$phieuthu['diachi'] = $biennhan['diachi'];
					$phieuthu['email'] = $biennhan['sobiennhan'];
					$phieuthu['dienthoai'] = $biennhan['sodienthoai'];
					$phieuthu['email'] = $biennhan['email'];
					$phieuthu['sotien'] = $this->string->toNumber($biennhan['tamung']);
					$phieuthu['donvi'] = 'VND';
					$phieuthu['quidoi'] = $this->document->toVND($this->string->toNumber($phieuthu['sotien']),$phieuthu['donvi']);
					$phieuthu['lydo'] = "Thu tiền tạm ứng";
					$phieuthu['nguongoc'] = $biennhan['biennhanid'];
					$phieuthu['maphieu'] = $this->model_ben_thuchi->insert($phieuthu);	
					
					$this->model_addon_biennhan->updateCol($biennhan['biennhanid'],"maphieuthutamung",$phieuthu['maphieu']);
				}
			}
			//Xoa chi tiet bien nhan
			if($data['delchitietid']!="")
			{
				$arr_idct = split(',',$data['delchitietid']);
				foreach($arr_idct as $id)
				{
					$this->model_addon_biennhan->deleteBienNhanChiTiet($id);	
				}
			}
			
			//Luu chi tiet bien nhan
			$arr_id = $data['id'];
			$arr_dichvuid = $data['dichvuid'];
			$arr_soluong = $data['soluong'];
			$arr_dongia = $data['dongia'];
			$arr_sotien = $data['sotien'];
			$arr_ghichu = $data['ghichuct'];
			$sum = 0;
			foreach($arr_dichvuid as $key => $dichvuid)
			{
				$ct['id'] = $arr_id[$key];
				$ct['biennhanid'] = $data['biennhanid'];
				$ct['dichvuid'] = $dichvuid;
				$ct['tendichvu'] = $this->document->getDichVu($dichvuid);
				$ct['soluong'] = $arr_soluong[$key];
				$ct['dongia'] = $arr_dongia[$key];
				$ct['sotien'] = $arr_sotien[$key];
				$ct['ghichu'] = $arr_ghichu[$key];
				$ct['ngaylap'] = $data['ngaylap'];
				$this->model_addon_biennhan->saveBienNhanChiTiet($ct);
				$sum +=$this->string->toNumber($ct['sotien']);
			}
			$tongtien = $sum - $this->string->toNumber($data['giamgia']);
			$this->model_addon_biennhan->updateCol($data['biennhanid'],'tongcong',$sum);
			$this->model_addon_biennhan->updateCol($data['biennhanid'],'tongtien',$tongtien);
			
			$this->data['output'] = "true-".$data['biennhanid'];
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