<?php
class ControllerCoreMember extends Controller
{
	private $error = array();
	
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
		
		$this->load->model("core/user");
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
		$this->load->model("core/user");
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
			$this->load->model("core/user");
			$this->data['haspass'] = false;
			$this->data['usernamereadonly'] = 'readonly="readonly"';
			if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validateForm())) 
			{
				$this->request->post['userid'] = $this->request->get['userid'];
				$this->request->post['birthday'] = $this->date->formatViewDate($this->request->post['birthday']);
				$this->model_core_user->updateuser($this->request->post);
				$this->session->data['success'] = $this->language->get('text_success');
				$this->redirect($this->url->http('core/user'));
			}
		
			$this->getForm();
		}
		
  	}
	
	public function active()
	{
		$userid = $this->request->get['userid'];
		$this->load->model("core/user");
		
		$data['userid'] = $userid;
		$user=$this->model_core_user->getItem($userid);
		if($user['status'] == "lock")
			$data['status'] = "active";
		else
			$data['status'] = "lock";
		$this->model_core_user->updatestatus($data);
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
		$this->load->model("core/user");
		if(count($listuserid))
		{
			$this->model_core_user->deleteusers($listuserid);
			$this->data['output'] = "Xóa thành công";
		}
		$this->id="content";
		$this->template="common/output.tpl";
		$this->render();
  	}
	
	private function getList() 
	{
		$this->data['insert'] = $this->url->http('core/user/insert');
		$this->data['delete'] = $this->url->http('core/user/delete');		
		
		$this->data['users'] = array();
		$where = "AND usertypeid = 'member'";
		$rows = $this->model_core_user->getList($where);
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
		//for($i=0; $i <= count($this->data['users'])-1 ; $i++)
		{
			$this->data['users'][$i] = $rows[$i];
			$this->data['users'][$i]['link_edit'] = $this->url->http('core/member/update&userid='.$this->data['users'][$i]['userid']);
			$this->data['users'][$i]['text_edit'] = "View";
			$this->data['users'][$i]['link_active'] = $this->url->http('core/member/active&userid='.$this->data['users'][$i]['userid']);
			if($this->data['users'][$i]['status']=='lock')
				$this->data['users'][$i]['text_active'] = "Active";
			else
				$this->data['users'][$i]['text_active'] = "Lock";
		}
		$this->data['refres']=$_SERVER['QUERY_STRING'];
		$this->id='content';
		$this->template="core/member_list.tpl";
		$this->layout="layout/center";
		
		$this->render();
	}
	
	
	private function getForm()
	{
		$this->data['error'] = @$this->error;
		$this->load->model("core/usertype");
		$this->load->model("core/country");
		$this->load->helper('image');
		//$xml = simplexml_load_file(DIR_COMPONENT.'xml/countries.xml');
		//$this->data['countries'] = $this->string->xmltoArray($xml);
		$this->data['countries'] = $this->model_core_country->getCountrys();
		$this->data['selectcountry'] = "VN";
		$this->data['usertype'] = $this->model_core_usertype->getAllUsertype();
		if (!isset($this->request->get['userid'])) {
			$this->data['action'] = $this->url->http('core/user/insert');
		} else {
			$this->data['action'] = $this->url->http('core/user/update&userid=' . $this->request->get['userid']);
		}
		$this->data['DIR_UPLOADPHOTO'] = HTTP_SERVER."index.php?route=common/uploadpreview";
		$this->data['cancel'] = $this->url->https('core/member');
		
		if ((isset($this->request->get['userid'])) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$this->data['user'] = $this->model_core_user->getItem($this->request->get['userid']);
			$this->data['user']['imagethumbnail']=HelperImage::resizePNG($this->data['user']['imagepath'], 200, 200);
    	}
		else
		{
			$this->data['user'] = $this->request->post;
			$this->data['selectcountry'] = $this->data['user']['country'];
			
		}
		
		$this->id='content';
		$this->template='core/member_form.tpl';
		$this->layout="layout/center";
		
		$this->render();
	}
	
	private function validateForm()
	{
    	if ((strlen($this->request->post['username']) == 0) || (strlen($this->request->post['username']) > 30)) 
		{
      		$this->error['username'] = "username not null";
    	}
		else
		{
			
			if($this->validation->_isId(trim($this->request->post['username'])) == false)
				$this->error['username'] ="username không hợp lệ";
			else
			{
				$user = $this->model_core_user->getItemByUserName($this->request->post['username']);
				if(count($user)>0 && $this->request->post['userid'] == '')
					$this->error['username'] = "username đã được sử dụng";			
			}
		}
		if($this->request->get['userid']=="")
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