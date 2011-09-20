<?php
class ControllerCoreMessage extends Controller
{
	private $error = array();
	
	public function index()
	{
		$this->load->language('core/message');
		$this->data = array_merge($this->data, $this->language->getData());
		
		//$this->load->language('core/message');
		$this->data = array_merge($this->data, $this->language->getData());
		
		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model("core/message");
		$this->getList();
	}
	
	public function insert()
	{
		//$this->load->language('core/message');
		//$this->data = array_merge($this->data, $this->language->getData());
		
		$this->document->title = $this->language->get('heading_title');
		$this->load->model("core/message");
		
		$messageid = $this->request->get['messageid'];
		
		$this->data['message'] = $this->model_core_message->getItem($messageid);
		
		if($messageid)
			$this->data['title'] = "Re: ".$this->data['message']['title'];
    
    	$this->getForm();
	}
	
	public function sendMessage()
	{
		$data=$this->request->post;
		//Validate
		$error = $this->validateForm($data);
		if(count($error)==0)
		{
			//Luu tin nhan vao folder send
			$this->load->model("core/message");
			$data['userid']=$this->user->getId();
			$data['from']=$this->user->getUserName();
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
	

	public function delete() {
		$this->load->language('core/message');
		$this->data = array_merge($this->data, $this->language->getData());
		
		$this->document->title = $this->language->get('heading_title');
		$this->load->model("core/message");
			
    	if (isset($this->request->post['delete'])) {
			foreach ($this->request->post['delete'] as $messageid) 
			{
				if($this->request->get['folder']!="send")
					$this->model_core_message->delectMessage($messageid);
				else
					$this->model_core_message->delete($messageid);
				
			}
			
			
	
			
    	}
	
    	
  	}
	
	public function view()
	{
		$messageid = $this->request->get['messageid'];
		$this->load->model("core/message");
		$this->load->helper('image');
		$this->data['reply'] = $this->url->http('core/message/insert&messageid='.$messageid);
		$this->data = array_merge($this->data, $this->model_core_message->getItem($messageid));
		$this->model_core_message->updateStatus($messageid,"read");
		if($this->data['attachment'] !="")
		{
			$listfileid = split(",",$this->data['attachment']);
			$this->data['attachmentfile']=array();
			foreach($listfileid as $key => $item)
			{
				$this->data['attachmentfile'][$key] = $this->model_core_file->getFile($item);
				$this->data['attachmentfile'][$key]['imagethumbnail'] = HelperImage::resizePNG($this->data['attachmentfile'][$key]['filepath'], 50, 50);
				if(!$this->string->isImage($this->data['attachmentfile'][$key]['extension']))
					$this->data['attachmentfile'][$key]['imagethumbnail'] = DIR_IMAGE."icon/dinhkem.png";
			}
		}
		
		$this->id='content';
		$this->template='core/message_view.tpl';
		$this->layout="layout/center";
		
		$this->render();
	}
	
	public function findContact()
	{
		$this->load->model("core/usertype");
		$this->load->model("core/user");
		//$where = " AND  usertypeid in (4,5)";
		$this->data['usertype'] = $this->model_core_usertype->getList($where);
		$this->data['user'] = $this->model_core_user->getList($where);
		$this->id='content';
		$this->template='core/finecontact.tpl';
		//$this->layout="layout/center";
		
		$this->render();
	}
	
	private function getList() 
	{
		$this->data['insert'] = $this->url->http('core/message/insert');
		$this->data['view'] = $this->url->http('core/message/view');
		$this->data['inbox'] = $this->url->http('core/message&folder=inbox');
		$this->data['send'] = $this->url->http('core/message&folder=send');
		$this->data['messages'] = array();
		$this->data['folder'] = $this->request->get['folder'];
		if($this->data['folder'] == "")
			$this->data['folder']="inbox";
		
		$this->data[$this->data['folder']."class"] = "selected";
		
		
		switch($this->data['folder'])
		{
			case "send":
				$where = " AND `userid` = '".$this->user->getId()."' ORDER BY  `message`.`senddate` DESC ";
				$this->data['messages'] = $this->model_core_message->getList($where);
				break;
			case $this->data['folder']:
				
				$where = " AND `username` = '".$this->user->getUserName()."' 
							and folder = '".$this->data['folder']."' ORDER BY  `messagesend`.`senddate` DESC ";
				$this->data['messages'] = $this->model_core_message->getMessages($where);
				
				for($i=0; $i < count($this->data['messages']) ; $i++)
				{
					$item=$this->model_core_message->getItem($this->data['messages'][$i]['messageid']);
					$this->data['messages'][$i]['from']=$item['from'];
					$this->data['messages'][$i]['to']=$item['to'];
					$this->data['messages'][$i]['title']=$item['title'];
					$this->data['messages'][$i]['attachment']=$item['attachment'];
					$this->data['messages'][$i]['replyfrom']=$item['replyfrom'];
				}
				break;
			
		}
		//
		$rows = $this->data['messages'];
		//Page
		$page = $this->request->get['page'];		
		$x=$page;		
		$limit = 20;
		$total = count($rows); 
		// work out the pager values 
		$this->data['pager']  = $this->pager->pageLayout($total, $limit, $page); 
		
		$pager  = $this->pager->getPagerData($total, $limit, $page); 
		$offset = $pager->offset; 
		$limit  = $pager->limit; 
		$page   = $pager->page;
		$this->data['messages'] = array();
		for($i=$offset;$i < $offset + $limit && count($rows[$i])>0;$i++)
		{
			$this->data['messages'][] = $rows[$i];
		}
		$this->id='content';
		$this->template="core/message_list.tpl";
		$this->layout="layout/center";
		
		$this->render();
	}
	
	
	private function getForm()
	{
		$this->load->language('core/message');
		$this->data = array_merge($this->data, $this->language->getData());
		
		$this->data['error'] = @$this->error;
		
		if (!isset($this->request->get['messageid'])) {
			$this->data['action'] = $this->url->http('core/message/insert');
		} else {
			$this->data['action'] = $this->url->http('core/message/update&messageid=' . $this->request->get['messageid']);
		}
		
		$this->data['cancel'] = $this->url->https('core/message');
		$this->data['DIR_UPLOADPHOTO'] = HTTP_SERVER."index.php?route=common/uploadpreview";
		$this->data['DIR_UPLOADATTACHMENT'] = HTTP_SERVER."index.php?route=common/uploadattachment";
		
		
		
		
		$this->id='content';
		$this->template='core/message_form.tpl';
		$this->layout="layout/center";
		
		$this->render();
	}
	
	private function validateForm($data)
	{
    	$error = array();
		if($data['to']=="")
		{
			$error['to'] = "Bạn chưa nhập thông tin gửi đến";
		}
		
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