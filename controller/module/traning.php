<?php
class ControllerModuleTraning extends Controller
{
	
	public function register()
	{
		$data=$this->request->post;
		$error = $this->validate($data);
		if(count($error))
		{
			foreach($error as $item)
				$this->data['output'].=$item."<br>";
		}
		else
		{
			$this->load->model("core/media");
			$media = $this->model_core_media->getItem($data['mediaid']);
			$email = $this->model_core_media->getInformation("setting", 'EmailTraning');
			/*$email1 = $this->model_core_media->getInformation($this->member->getSiteId().$data['sitemapid'], "email1");
			$email2 = $this->model_core_media->getInformation($this->member->getSiteId().$data['sitemapid'], "email2");
			$email3 = $this->model_core_media->getInformation($this->member->getSiteId().$data['sitemapid'], "email3");*/
			$email1 = $email;
			$arrmail = array();
			if($email1)
				$arrmail[] = $email1;
			if($email2)
				$arrmail[] = $email2;
			if($email3)
				$arrmail[] = $email3;
			$this->load->model("core/message");
			$message['to']="admin," .implode(",",$arrmail) ;
			$message['from']='"'.$data['fullname'].'" '.$data['email'];
			$message['title']="Thông tin liên hệ đăng ký khóa học ".$media['title'];
			$message['description']="Khóa học: <h3>".$media['title']."</h3><br>";
			$message['description'].="Họ tên: ".$data['fullname']."<br>";
			$message['description'].="Email: ".$data['email']."<br>";
			$message['description'].="Địa chỉ: ".$data['address']."<br>";
			$message['description'].="Điện thoại: ".$data['phone']."<br>";
			$message['description'].="Nội dung: ".$data['description']."<br>";
			$message['folder']="inbox";
			$this->model_core_message->insert($message);
			
			$mail['from'] = $data['email'];
			$mail['FromName'] = $data['fullname'];
			$mail['to'] = implode(",",$arrmail);
			$mail['name'] = "";
			$mail['subject'] =  $message['title'];
			$mail['body'] = $message['description'];
			$this->mailsmtp->sendMail($mail);
			
			$this->data['output'] = "true";
		}
		$this->id="content";
		$this->template="common/output.tpl";
		$this->render();
	}
	
	private function validate($data)
	{
		$err = array();
		
		if($data['fullname'] == "")
			$err["fullname"] = $this->data['war_fullnamenotnull'];
		if($data['email'] == "")
			$err["email"] = $this->data['war_emailnotnull'];
		else
			if ($this->validation->_checkEmail($data['email']) == false )
				$err["email"] = $this->data['war_emailnotformate'];
		if($data['address'] == "")
			$err["address"] = $this->data['war_addressnotnull'];
		if($data['phone'] == "")
			$err["phone"] = $this->data['war_phonenotnull'];
		if($data['description'] == "")
			$err["description"] = $this->data['war_descriptionnotnull'];
		return $err;
	}
}
?>