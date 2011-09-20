<?php
class ControllerAddonCompose extends Controller
{
	private $error = array();
	function __construct() 
	{
		//$this->data['DIR_UPLOADPHOTO'] = HTTP_SERVER."index.php?route=common/uploadpreview";
		$this->data['DIR_UPLOADATTACHMENT'] = HTTP_SERVER."index.php?route=common/uploadattachment";
		$this->load->model('core/message');
	}
	public function index()
	{
				
		$this->id="content";
		$this->template="addon/message_form.tpl";
		$this->render();
	}
	
	public function sendMessage()
	{
		$data=$this->request->post;
		//Validate
		$error = $this->validateForm($data);
		if(count($error)==0)
		{
			//Luu tin nhan vao folder send
			$data['to'] = "admin";
			$this->load->model("core/message");
			$data['userid']=$this->member->getId();
			$data['from']=$this->member->getUserName();
			$listAttachment=$this->request->post['attimageid'];
			if(count($listAttachment))
				$data['attachment']=implode(",",$listAttachment);
			else
				$data['attachment']="";
			$data['status']="";
			$data['folder']="send";
			$data['senddate']=$this->date->getToday();
			$data['replyfrom']= $messageid;
			
			$messageid=$this->model_core_message->insert($data);
			$this->data['output'] = "true";
		}
		else
		{
			$this->data['output'] = "";
			foreach($error as $item)
			{
				$this->data['output'] .= $item."<br>";
			}
		}
		$this->id="content";
		$this->template="common/output.tpl";
		$this->render();
	}
	
	private function validateForm($data)
	{
    	$error = array();
		
		if($data['title'] =="")
		{
			$error['title'] = "Bạn chưa nhập tiêu đề";
		}
		
		if($data['description']=="")
		{
			$error['description'] = "Bạn chưa nhập nội dung";
		}
		return $error;
	}
}
?>
