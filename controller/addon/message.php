<?php
class ControllerAddonMessage extends Controller
{
	private $error = array();
	private $messageid;
	function __construct() 
	{
		if(!$this->member->isLogged())
			$this->response->redirect($this->document->createLink("login"));
		//$this->data['DIR_UPLOADPHOTO'] = HTTP_SERVER."index.php?route=common/uploadpreview";
		$this->data['DIR_UPLOADATTACHMENT'] = HTTP_SERVER."index.php?route=common/uploadattachment";
		$this->load->model('core/message');
		$this->load->helper('image');
		$this->messageid = $this->request->get['id'];
	}
	public function index()
	{
		$this->document->title .= " - Hộp thư";
		$this->document->breadcrumb .= "Hộp thư";
		if($this->messageid=="")
			$this->getList();
		else
		{
			$this->getDetail();
		}
		
	}
	
	private function getList() 
	{
		
		$this->data['messages'] = array();
		$this->data['folder'] = $this->request->get['folder'];
		if($this->data['folder'] == "")
			$this->data['folder']="inbox";
		
		$this->data[$this->data['folder']."class"] = "selected";
		
		
		switch($this->data['folder'])
		{
			case "send":
				$where = " AND `userid` = '".$this->member->getId()."' ORDER BY  `message`.`senddate` DESC ";
				$this->data['messages'] = $this->model_core_message->getList($where);
				break;
			case $this->data['folder']:
				
				$where = " AND `username` = '".$this->member->getUserName()."' 
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
		$this->template="addon/message_list.tpl";
		$this->render();
	}
	
	private function getDetail()
	{
		$this->data['item'] = $this->model_core_message->getItem($this->messageid);
		
		$this->model_core_message->updateStatus($this->messageid,"read");
		if($this->data['item']['attachment'] !="")
		{
			$listfileid = split(",",$this->data['item']['attachment']);
			$this->data['attachment']=array();
			foreach($listfileid as $key => $item)
			{
				$this->data['attachment'][$key] = $this->model_core_file->getFile($item);
				$this->data['attachment'][$key]['imagethumbnail'] = HelperImage::resizePNG($this->data['attachment'][$key]['filepath'], 50, 50);
				if(!$this->string->isImage($this->data['attachment'][$key]['extension']))
					$this->data['attachment'][$key]['imagethumbnail'] = DIR_IMAGE."icon/dinhkem.png";
			}
		}
		$this->id='content';
		$this->template="addon/message_view.tpl";
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
}
?>
