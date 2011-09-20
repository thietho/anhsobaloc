<?php
class ControllerModuleContact extends Controller
{
	public function index()
	{
		$this->load->model("core/media");
		
		$sitemapid = $this->document->sitemapid;
		
		$this->data['post'] = $this->model_core_media->getItem($this->member->getSiteId().$sitemapid);
		
		if(count($this->data['post']) == 0)
		{
			$this->data['post']['description'] = "Updating...";
		}
		
		$this->data['post']['description'] = html_entity_decode($this->data['post']['description']);
		
		$arr = array("sododuongdi");
						
		$this->data['sododuongdi'] = $this->loadModule('module/location','loadLocation',$arr);
		
		$this->id="contact";
		$this->template="module/contact.tpl";
		$this->render();
	}
	
	public function sendMessage()
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
			$email1 = $this->model_core_media->getInformation($this->member->getSiteId().$data['sitemapid'], "email1");
			$email2 = $this->model_core_media->getInformation($this->member->getSiteId().$data['sitemapid'], "email2");
			$email3 = $this->model_core_media->getInformation($this->member->getSiteId().$data['sitemapid'], "email3");
			$this->load->model("core/message");
			$message['to']="admin,$email1,$email2,$email3";
			$message['from']='"'.$data['fullname'].'" '.$data['email'];
			$message['title']="Thông tin liên hệ";
			$message['description']="Họ tên: ".$data['fullname']."<br>";
			$message['description'].="Email: ".$data['email']."<br>";
			$message['description'].="Địa chỉ: ".$data['address']."<br>";
			$message['description'].="Điện thoại: ".$data['phone']."<br>";
			$message['description'].="Nội dung: ".$data['description']."<br>";
			$message['folder']="inbox";
			$this->model_core_message->insert($message);
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
			$err["fullname"] = "Bạn chưa nhập họ và tên";
		if($data['email'] == "")
			$err["email"] = "Email không đươc rỗng";
		else
			if ($this->validation->_checkEmail($data['email']) == false )
				$err["email"] = "Email không đúng định dạng";
		if($data['address'] == "")
			$err["address"] = "Bạn chưa nhập địa chỉ";
		if($data['phone'] == "")
			$err["phone"] = "Bạn chưa nhập số điên thoại";
		if($data['description'] == "")
			$err["description"] = "Bạn chưa nhập lời nhắn";
		return $err;
	}
}
?>