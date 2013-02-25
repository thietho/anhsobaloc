<?php
class ControllerCommonForgotpassword extends Controller
{
	function index()
	{
		$this->id='content';
		$this->template='common/forgotpassword.tpl';
		$this->layout='layout/login';
		$this->render();
	}
	
	public function resetPassword()
	{
		$data = $this->request->post;
		$err =$this->validate($data);
		if(count($err)==0)
		{
			$this->data['output'] = 'true';
			$this->load->model('core/user');
			$user = $this->model_core_user->getItemByEmail($data['email']);
			
			//Reset password
			$newpass = $this->string->generateRandStr(10);
			
			$user['password'] = md5($newpass);
			$this->model_core_user->changePassword($user);
			$this->load->helper('mail');
			//Send mail
			$to=$data['email'];
			// subject
			$subject = "Khôi phục mật khẩu";
			// message
			$message = "Tài khoản đăng nhập: ".$data['username']."
						Mật khẩu mới: ".$newpass;
			
			
			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			
			// Additional headers
			$headers .= 'From: admin@ben-solution.com';
								
			// Mail it
			//$template = $this->language->get('message_template_recoverypassword');
			$template = "Chào {nguoinhan},<br>

							Đây là thông tin đăng nhập của bạn tại Cổng thông tin du lịch ảnh:<br>
							Tài khoản: {username}<br>
							Mật khẩu: {matkhau}<br>
							
							Cám ơn,<br>
							Ban Quản Trị";
			$param = array(
							'{nguoinhan}' => $user['fullname'],
							'{username}' => $user['username'],
							'{matkhau}' => $newpass
							
							);
			$message = $this->string->inludeParameterToTemplate($param,$template);
			HelperMail::sendmail($to, $subject, $message, "", "smtp");
			
		}
		else
		{
			$this->data['output'] = '';
			foreach($err as $item)
			{
				$this->data['output'] .= $item."<br>";
			}
		}
		$this->id='content';
		$this->template='common/output.tpl';
		
		$this->render();
	}
	
	private function validate($data) 
	{
		$err = array();
		if($data['email']=="")
			$err['email'] = "Bạn chưa nhập mật khẩu";
		else
		{
			$this->load->model('core/user');
				$user = $this->model_core_user->getItemByEmail($data['email']);
			if(count($user)==0)
				$err['email'] = "Không tồn tại email này";
		}
		return $err;
	}	
	
	
	
	
}


?>