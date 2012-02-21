<?php
class ControllerAddonChangepass extends Controller
{
	private $error = array();
	public function index()
	{
		$this->document->breadcrumb .= "Đổi mật khẩu";
		$this->id="content";
		$this->template="addon/changepass.tpl";
		$this->render();
	}
	
	public function change()
	{
		$data = $this->request->post;
		if($this->validateForm($data))
		{
			$this->load->model("core/user");
			$user['userid'] = $this->member->getId();
			$user['password'] = md5($data['newpassword']);
			
			$this->model_core_user->changePassword($user);
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
	
	private function validateForm($data)
	{
		
		$this->load->model("core/user");
		$member = $this->model_core_user->getItem($this->member->getId());
    	if(trim($data['oldpassword']) == "")
		{
      		$this->error['oldpassword'] = $this->data['war_passwordnotnull'];
    	}
		else
		{
			if(md5($data['oldpassword']) != $member['password'])
			{
				$this->error['oldpassword'] = "Bạn nhập mật khẩu không đúng";
			}
		}
		
		if(trim($data['newpassword']) =="")
		{
      		$this->error['newpassword'] = "Bạn chưa nhập nhật khẩu mới";
    	}
		else
		{
			if($data['newpassword']!=$data['confirmpassword'])
			{
				$this->error['newpassword'] = "Xác nhận mật khẩu không đúng";
			}
		}
		
		if (count($this->error)==0) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
	}
}
?>