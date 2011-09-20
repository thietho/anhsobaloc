<?php
class ControllerCommonChangepassword extends Controller
{
	function index()
	{
		
		
		$this->id='content';
		$this->template='common/changepassword.tpl';
		$this->layout='layout/center';	
		$this->render();
	}
	
	function validatePassword()
	{
		$oldpass = $this->db->escape(md5($this->request->post['oldpassword']));
		$newpass= $this->db->escape(md5($this->request->post['newpassword']));
		$confirmpass= $this->db->escape(md5($this->request->post['confirmpassword']));
		// Kiem tra ko duoc rong
		if($this->request->post['oldpassword']=="" or $this->request->post['newpassword']=="" or $this->request->post['confirmpassword']=="")
		{
			
			$this->data['Error']['errornull']="You must enter data";
		}
		else
		{
			// So sanh gia tri nhap tren Textbox "Current Password" with DataBase
			$this->load->model('core/user');
			$userid=$this->user->getId();
			if(!$this->model_core_user->validatePassword($userid,$oldpass))
				$this->data['Error']['checkpass']="You entered the wrong password";
				
			// So sanh newpassword va confirmpassword bat buoc trung
			if( $newpass != $confirmpass)
				$this->data['Error']['confirmpassword']="Confirm password is incorrect";
		}
	}
	// ham update newpassword xuong DataBase
	function update()
	{
		$this->load->model('core/user');
		$data['userid']=$this->user->getId();
		$data['password']=$this->db->escape(md5($this->request->post['newpassword']));
		$data['updateddate']=$this->date->getToday();
		$data['updatedby']=1;
		$this->validatePassword();
		if(count($this->data['Error'])==0)
		{
			$this->model_core_user->changePassword($data);	
			$this->data['output'] ="true";
		}
		else
		{
			foreach($this->data['Error'] as $item)
			{
				$this->data['output'] = $item."<br>";
			}
		}
		$this->id='content';
		$this->template='common/output.tpl';
		$this->render();
	}
	
}


?>