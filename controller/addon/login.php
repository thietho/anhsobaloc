<?php
class ControllerAddonLogin extends Controller
{
	private $error = array();
	public function index()
	{
		$this->document->sitebar['login'] = "hide";
		$this->document->breadcrumb .= "Đăng nhập tài khoảng";
		
		$this->id="content";
		$this->template="addon/login.tpl";
		$this->render();
	}
	
	public function login()
	{
		$data = $this->request->post;
		if($this->validateForm($data))
		{
			$username = $data['username'];
			$password = $data['password'];
			if($this->member->login($username, $password))
			{
				if($data['remember'] == 1)
				{
					setcookie('username', $data['username'],time()+3600);
					setcookie('password', $data['password'],time()+3600);
				}
				$this->data['output'] = "true";
			}
			else
				$this->data['output'] = "Mật khẩu không đúng";
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
		
		
    	if(trim($data['username']) == "")
		{
      		$this->error['username'] = "Bạn chưa nhập tên đăng nhập";
    	}
		else
		{
			$this->load->model('core/user');
			$activecode = $this->model_core_user->getInformation(trim($data['username']),"activecode");
			if($activecode != "")
				$this->error['username'] = "Tài khoảng của bạn chưa được kích hoạt! <a href='".HTTP_SERVER."site/".$this->member->getSiteId()."/active'>Kích hoạt tài khoảng click vào đây</a>";
		}
		if(trim($data['password']) =="")
		{
      		$this->error['password'] = "Bạn chưa nhập mật khẩu";
    	}
		
		if (count($this->error)==0) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
	}
}
?>