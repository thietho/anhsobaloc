<?php
class ControllerAddonRegister extends Controller
{
	private $error = array();
	public function index()
	{
		$this->document->breadcrumb .= $this->data['text_register'];
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
      		$this->error['username'] = $this->data['war_usernamenotnull'];
    	}
		else
		{
			$item = $this->model_core_user->getItem($data['username']);
			if(count($item)>0)
				$this->error['username'] = $this->data['war_usernamenotavailable'];
			
		}
		if(trim($data['password']) =="")
		{
      		$this->error['password'] = $this->data['war_passwordnotnull'];
    	}
		
		if(trim($data['confirmpassword']) =="")
		{
      		$this->error['confirmpassword'] = $this->data['war_confirmpasswordnotnull'];
    	}
		
		if(trim($data['password']) !="" && trim($data['confirmpassword']) !="" ) 
		{
			if($data['password'] != $data['confirmpassword'])
			{
				$this->error['confirmpassword'] = $this->data['war_confirmpasswordnotcorrect'];
			}
		}
		
		if(trim($data['fullname']) =="")
		{
      		$this->error['fullname'] = $this->data['war_fullnamenotnull'];
    	}
		
		if ($data['email'] == "") 
		{
      		$this->error['email'] = "Bạn chưa nhập email";
    	}
		else
		{
			if(!$this->validation->_checkEmail($data['email']))
			{
				$this->error['email'] = $this->data['war_emailnotformate'];
			}
			else
			{
				$where = "AND email = '".$data['email']."'";
				$users = $this->model_core_user->getList($where);
				if(count($users))
				{
					$this->error['email'] = $this->data['war_emailhasused'];
				}
			}
		}

		if(trim($data['chkaccept']) =="")
		{
      		$this->error['chkaccept'] = $this->data['war_younotagree'];
    	}
		
		if (count($this->error)==0) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
	}
	
	public function savenhantin()
	{
		$data = $this->request->post;
		if($this->validateFormNhanTin($data))
		{
			$this->load->model("ben/nhantin");
			
			$this->model_ben_nhantin->insert($data);
			
			//Gui thong bao vo mail
			$mail['from'] = "support@ancaratperfume.com";
			$mail['FromName'] = "Ancaratperfume";
			$mail['to'] = $data['email'];
			$mail['name'] = $data['hoten'];
			$mail['subject'] =  "Thong bao nhan tin";
			$mail['body'] = "Ban da dang ky nhan tin tu ancaratperfume.com thanh cong";
			$this->mailsmtp->sendMail($mail);
			
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
	
	private function validateFormNhanTin($data)
	{
		if(trim($data['hoten']) =="")
		{
      		$this->error['hoten'] = "Bạn chưa nhập họ tên";
    	}
		
		if ($data['email'] == "") 
		{
      		$this->error['email'] = "Bạn chưa nhập email";
    	}
		else
		{
			if(!$this->validation->_checkEmail($data['email']))
			{
				$this->error['email'] = "Email không đúng dịnh dạng";
			}
			else
			{
				$this->load->model("ben/nhantin");
				$where = " AND email = '".$data['email']."'";
				$nhantin = $this->model_ben_nhantin->getList($where);
				if(count($nhantin))
				{
					$this->error['email'] = "Email đã được đăng ký";
				}
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