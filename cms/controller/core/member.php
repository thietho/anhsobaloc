<?php
class ControllerCoreMember extends Controller
{
	private $error = array();
	function __construct() 
	{
	 	$this->load->model("core/user");
		$this->load->model("addon/biennhan");
		$this->load->model("ben/thuchi");
		
   	}
	public function index()
	{
		if(!$this->user->hasPermission($this->getRoute(), "access"))
		{
			$this->response->redirect("?route=common/permission");
		}
		$this->data['permissionAdd'] = true;
		$this->data['permissionEdit'] = true;
		$this->data['permissionDelete'] = true;
		if(!$this->user->hasPermission($this->getRoute(), "add"))
		{
			$this->data['permissionAdd'] = false;
		}
		if(!$this->user->hasPermission($this->getRoute(), "edit"))
		{
			$this->data['permissionEdit'] = false;
		}
		if(!$this->user->hasPermission($this->getRoute(), "delete"))
		{
			$this->data['permissionDelete'] = false;
		}
		//$this->load->language('core/user');
		//$this->data = array_merge($this->data, $this->language->getData());
		
		$this->document->title = $this->language->get('heading_title');
		
		
		$this->getList();
	}
	
	public function insert()
	{
		if(!$this->user->hasPermission($this->getRoute(), "add"))
		{
			$this->response->redirect("?route=common/permission");
		}
		//$this->load->language('core/user');
		//$this->data = array_merge($this->data, $this->language->getData());
		
		$this->document->title = $this->language->get('heading_title');
		
		$this->data['haspass'] = true;
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validateForm())) 
		{
			$this->request->post['birthday'] = $this->date->formatViewDate($this->request->post['birthday']);
			$this->model_core_user->insertuser($this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->redirect($this->url->http('core/user'));
		}
    
    	$this->getForm();
	}
	
	public function update()
	{
		if(!$this->user->hasPermission($this->getRoute(), "edit"))
		{
			$this->response->redirect("?route=common/permission");
		}
		else
		{
			//$this->load->language('core/user');
			//$this->data = array_merge($this->data, $this->language->getData());
			
			$this->document->title = $this->language->get('heading_title');
			
			$this->data['haspass'] = false;
			
			
		
			$this->getForm();
		}
		
  	}
	
	public function active()
	{
		$id = $this->request->get['id'];
		
		
		$data['id'] = $id;
		$user=$this->model_core_user->getId($id);
		if($user['status'] == "lock")
			$data['status'] = "active";
		else
			$data['status'] = "lock";
		$this->model_core_user->updateCol($id,'status',$data['status']);
		if($data['status'] == "active")
			$this->data['output']="Kích hoạt thành công";
		if($data['status'] == "lock")
			$this->data['output']="User đã bị khóa";
		$this->id="content";
		$this->template="common/output.tpl";
		$this->render();
	}
	
	public function delete() 
	{
		$listuserid=$this->request->post['delete'];
		//$listuserid=$_POST['delete'];
		
		if(count($listuserid))
		{
			foreach($listuserid as $id)
			{
				$this->model_core_user->deletemember($id);
			}
			$this->data['output'] = "Xóa thành công";
		}
		$this->id="content";
		$this->template="common/output.tpl";
		$this->render();
  	}
	
	private function getList() 
	{
		$this->data['insert'] = $this->url->http('core/member/insert');
		$this->data['delete'] = $this->url->http('core/user/delete');		
		
		
		$this->id='content';
		$this->template="core/member_list.tpl";
		$this->layout=$this->user->getLayout();
		if($_GET['dialog'] == "true")
			$this->layout="";
		
		
		$this->render();
	}
	
	public function loadTableMember()
	{
		
		$this->data['users'] = array();
		$where = "AND usertypeid = 'member'";
		$data = $this->request->get;
		foreach($data as $key =>$val)
		{
			$data[$key] = urldecode($val);	
		}
		$_GET = $data;
		if(trim($data['username']))
		{
			$where .= " AND username like '%".$data['username']."%'";
		}
		if(trim($data['fullname']))
		{
			$where .= " AND fullname like '%".$data['fullname']."%'";
		}
		if(trim($data['phone']))
		{
			$where .= " AND phone like '%".$data['phone']."%'";
		}
		if(trim($data['address']))
		{
			$where .= " AND address like '%".$data['address']."%'";
		}
		if(trim($data['email']))
		{
			$where .= " AND email like '%".$data['email']."%'";
		}
		if(trim($data['status']))
		{
			$where .= " AND status like '".$data['status']."'";
		}
		
		$rows = $this->model_core_user->getList($where);
		//Page
		$page = $this->request->get['page'];		
		$x=$page;		
		$limit = 20;
		$total = count($rows); 
		// work out the pager values 
		$this->data['pager']  = $this->pager->pageLayoutAjax($total, $limit, $page,"memberlist"); 
		
		$pager  = $this->pager->getPagerData($total, $limit, $page); 
		$offset = $pager->offset; 
		$limit  = $pager->limit; 
		$page   = $pager->page;
		for($i=$offset;$i < $offset + $limit && count($rows[$i])>0;$i++)
		//for($i=0; $i <= count($this->data['users'])-1 ; $i++)
		{
			$this->data['users'][$i] = $rows[$i];
			$this->data['users'][$i]['link_edit'] = $this->url->http('core/member/update&id='.$this->data['users'][$i]['id']);
			$this->data['users'][$i]['text_edit'] = "Edit";
			$this->data['users'][$i]['link_active'] = $this->url->http('core/member/active&id='.$this->data['users'][$i]['id']);
			if($this->data['users'][$i]['status']=='lock')
				$this->data['users'][$i]['text_active'] = "Kích hoạt";
			else
				$this->data['users'][$i]['text_active'] = "Khóa";
			$this->data['users'][$i]['congno'] = $this->getCongNo($this->data['users'][$i]['id']);
		}
		$this->data['refres']=$_SERVER['QUERY_STRING'];
		$this->id='content';
		$this->template="core/member_table.tpl";
		$this->render();
	}
	
	public function getCongNo($id='')
	{
		if($id=="")
			$id=$this->request->get['khachhangid'];
			
		$this->data['user'] = $this->model_core_user->getId($id);
		//Lay tat ca phieu thu
		$where = " AND makhachhang = '".$id."' AND loaithuchi = 'thu'";
		$this->data['data_phieuthu'] = $this->model_ben_thuchi->getList($where);
		$tongthu = 0;
		
		foreach($this->data['data_phieuthu'] as $item)
		{
			$tongthu += $item['quidoi'];	
		}
		//Lay tat ca bien nhan
		$where = " AND khachhangid = '".$id."'";
		$this->data['data_biennhan'] = $this->model_addon_biennhan->getList($where);
		$tongbiennhan = 0;
		foreach($this->data['data_biennhan'] as $item)
		{
			$tongbiennhan += $item['tongtien'];	
		}
		$congno = $tongbiennhan - $tongthu;
		
		if($this->request->get['khachhangid'])
		{
			$this->data['tongphieuthu'] = $tongthu;
			$this->data['tongbiennhan'] = $tongbiennhan;
			$this->data['congno'] = $congno;
			$this->id='content';
			$this->template="core/member_congno.tpl";
			if($_GET['dialog']=='print')
			{
				$this->layout='layout/print';
			}
			$this->render();
		}
		else
		{
			return $congno;
		}
	}
	
	private function getForm()
	{
		$this->data['error'] = @$this->error;
		$this->load->model("core/usertype");
		$this->load->model("core/country");
		$this->load->helper('image');
		
		$this->data['DIR_UPLOADPHOTO'] = HTTP_SERVER."index.php?route=common/uploadpreview";
		$this->data['cancel'] = $this->url->https('core/member');
		$id = $this->request->get['id'];
		
		$this->data['user'] = $this->model_core_user->getId($id);
		$this->data['user']['imagethumbnail']=HelperImage::resizePNG($this->data['user']['imagepath'], 200, 200);
    	
		
		$this->id='content';
		$this->template='core/member_form.tpl';
		$this->layout=$this->user->getLayout();
		
		$this->render();
	}
	
	public function save()
	{
		$data = $this->request->post;
		
		if($this->validateForm($data))
		{
			
			$data['birthday'] = $this->date->formatViewDate($data['birthday']);
			if($data['id']=="")
			{
				$this->model_core_user->insertUser($data);	
			}
			else
			{	
				$this->model_core_user->updateUser($data);	
			}
			
			$this->data['output'] = "true";
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
	
	private function validateForm()
	{
    	
		if(trim($this->request->post['username']))
		{
			
			if($this->validation->_isId(trim($this->request->post['username'])) == false)
				$this->error['username'] ="username không hợp lệ";
			else
			{
				if($this->request->post['id'])
				{
					$id = $this->request->post['id'];
					$where = " AND id <> '".$id."' AND username = '".trim($this->request->post['username'])."'";
					$data_user = $this->model_core_user->getList($where);
					count($data_user);
					if(count($data_user)>0)
						$this->error['username'] = "username đã được sử dụng";			
				}
			}
		}
		if($this->request->post['password']!="")
		{
			if (strlen($this->request->post['password']) == 0) 
			{
				$this->error['password'] = "Password not null";
			}
			
			if ($this->request->post['confrimpassword'] != $this->request->post['password']) 
			{
				$this->error['confrimpassword'] = "Confrimpassword invalidate";
			}		
		}
		
		if ($this->validation->_checkEmail($this->request->post['email']) == false ) 
		{
      		$this->error['email'] = "Email invalidate";
    	}

		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
	}
}
?>