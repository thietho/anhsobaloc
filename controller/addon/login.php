<?php
class ControllerAddonLogin extends Controller
{
	private $error = array();
	public function index()
	{
		$this->document->sitebar['login'] = "hide";
		$this->document->breadcrumb .= $this->data['text_login'];
		
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
				$this->data['output'] = $this->data['war_passwordnotcorrect'];
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
      		$this->error['username'] = $this->data['war_usernamenotnull'];
    	}
		else
		{
			$this->load->model('core/user');
			$activecode = $this->model_core_user->getInformation(trim($data['username']),"activecode");
			if($activecode != "")
				$this->error['username'] = $this->data['war_accountnotactive1']." <a href='".$this->document->createLink('active')."'>".$this->data['war_accountnotactive2']."</a>";
		}
		if(trim($data['password']) =="")
		{
      		$this->error['password'] = $this->data['war_passwordnotnull'];
    	}
		
		if (count($this->error)==0) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
	}
}
?>