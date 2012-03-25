<?php
class ControllerAddonBiennhan extends Controller
{
	private $error = array();
   	function __construct() 
	{
	 	$this->load->model("addon/biennhan");
		
   	}
	
	public function index()
	{
		$this->getList();
	}
	
	public function insert()
	{
    	$this->getForm();
	}
	
	public function update()
	{
		$this->data['haspass'] = false;
		$this->data['readonly'] = 'readonly="readonly"';
		$this->data['class'] = 'readonly';	
		$this->getForm();
  	}
	
	
	
	public function delete() 
	{
		$listbiennhanid=$this->request->post['delete'];
		
		if(count($listbiennhanid))
		{
			foreach($listbiennhanid as $biennhanid)
			{
				$this->model_addon_biennhan->delete($biennhanid);	
			}
			$this->data['output'] = "true";
		}
		$this->id="content";
		$this->template="common/output.tpl";
		$this->render();
  	}
	
	private function getList() 
	{
		$this->data['insert'] = $this->url->http('addon/biennhan/insert');
		$this->data['delete'] = $this->url->http('addon/biennhan/delete');		
		
		
		
		$this->data['datas'] = array();
		$where = "";
		
		$where .= " Order by ngaylap DESC";
		$rows = $this->model_addon_biennhan->getList($where);
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
		for($i=$offset;$i < $offset + $limit && count($rows[$i])>0;$i++)
		//for($i=0; $i <= count($this->data['datas'])-1 ; $i++)
		//for($i=0;$i < count($rows[$i]);$i++)
		{
			$this->data['datas'][$i] = $rows[$i];
			$this->data['datas'][$i]['link_edit'] = $this->url->http('addon/biennhan/update&biennhanid='.$this->data['datas'][$i]['biennhanid']);
			$this->data['datas'][$i]['text_edit'] = "Edit";
			
			
			
		}
		
		$this->id='content';
		$this->template="addon/biennhan_list.tpl";
		$this->layout='layout/center';
		
		$this->render();
	}
	
	
	private function getForm()
	{		
		
		if ((isset($this->request->get['biennhanid'])) ) 
		{
      		$this->data['item'] = $this->model_addon_biennhan->getItem($this->request->get['biennhanid']);
			
    	}
		
		
		$this->id='content';
		$this->template='addon/biennhan_form.tpl';
		$this->layout='layout/center';
		$this->render();
	}
	
	
	
	public function save()
	{
		$data = $this->request->post;
		
		if($this->validateForm($data))
		{
			
			if($data['biennhanid']=="")
			{
				$data['biennhanid'] = $this->model_addon_biennhan->insert($data);	
			}
			else
			{
				$this->model_addon_biennhan->update($data);	
			}
			
			
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
		
		if (trim($data['tendichvu']) == "") 
		{
      		$this->error['tendichvu'] = "Bạn chưa nhập tên dịch vụ";
    	}
		
		if (count($this->error)==0) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
	}
	
}
?>