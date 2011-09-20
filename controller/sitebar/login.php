<?php
class ControllerSitebarLogin extends Controller
{
	public function index()
	{
		$this->id="content";
		$this->template="sitebar/login.tpl";
		
		$this->render();
	}
	
	public function login()
	{
		$this->id="content";
		if(!$this->member->isLogged())
			$this->template="sitebar/flogin.tpl";
		else
		{
			
			$this->getMemberInfor();
			$this->template="sitebar/memberinfor.tpl";
		}
		$this->render();
	}
	
	
	private function getMemberInfor()
	{
		$this->load->model("core/user");
		$this->data['member'] = $this->model_core_user->getItem($this->member->getId());
	}
	
	public function logout()
	{
		$this->member->logout();
		setcookie('username', "",time()-3600);
		setcookie('password', "",time()-3600);
		$this->data['output'] = "true";
		$this->id='content';
		$this->template='common/output.tpl';
		$this->render();
	}
}
?>