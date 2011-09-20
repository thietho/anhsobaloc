<?php
class ControllerAddonRegister extends Controller
{
	private $error = array();
	public function index()
	{
		$this->document->breadcrumb .= "Đăng ký thành viên";
		$this->id="content";
		$this->template="addon/register.tpl";
		$this->render();
	}
	
	public function save()
	{
		$data = $this->request->post;
		if($this->validateForm($data))
		{
			$this->load->model("core/user");
			$data['birthday'] = $this->date->formatViewDate($data['birthday']);
			$data['usertypeid'] = "member";
			$this->model_core_user->insertUser($data);
			
			//Gui ma kich hoat vo email cua member
			$activecode = $this->string->generateRandStr(10);
			
			$mail['from'] = "support@bensolution.com";
			$mail['FromName'] = "Ben Solutions";
			$mail['to'] = $data['email'];
			$mail['name'] = $data['fullname'];
			$mail['subject'] =  "Kich hoat tai khoang";
			$mail['body'] = "Ma kich hoat: ".$activecode;
			
			$this->model_core_user->saveInformation($data['username'], "activecode", $activecode);
			$this->mailsmtp->sendMail($mail);
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
    	if(trim($data['username']) == "")
		{
      		$this->error['username'] = "Bạn chưa nhập tên đăng nhập";
    	}
		else
		{
			$item = $this->model_core_user->getItem($data['username']);
			if(count($item)>0)
				$this->error['username'] = "Tên đăng nhập đã đươc sử dụng";
			
		}
		if(trim($data['password']) =="")
		{
      		$this->error['password'] = "Bạn chưa nhập mật khẩu";
    	}
		
		if(trim($data['confirmpassword']) =="")
		{
      		$this->error['confirmpassword'] = "Bạn chưa nhập xác nhận mật khẩu";
    	}
		
		if(trim($data['password']) !="" && trim($data['confirmpassword']) !="" ) 
		{
			if($data['password'] != $data['confirmpassword'])
			{
				$this->error['confirmpassword'] = "Xát nhận mật khẩu không đúng";
			}
		}
		
		if(trim($data['fullname']) =="")
		{
      		$this->error['fullname'] = "Bạn chưa nhập họ tên";
    	}
		
		if ($data['email'] == "") 
		{
      		$this->error['email'] = "Bạn chưa nhập email";
    	}
		else
		{
			if(!$this->validation->_checkEmail($data['email']))
			{
				$this->error['email'] = "Email không đúng định dạng";
			}
			else
			{
				$where = "AND email = '".$data['email']."'";
				$users = $this->model_core_user->getList($where);
				if(count($users))
				{
					$this->error['email'] = "Email đã được sử dụng";
				}
			}
		}

		if(trim($data['chkaccept']) =="")
		{
      		$this->error['chkaccept'] = "Bạn chưa đồng ý với chúng tôi";
    	}
		
		if (count($this->error)==0) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
	}
}
?>