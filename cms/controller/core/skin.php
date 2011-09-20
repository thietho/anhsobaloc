<?php
class ControllerCoreSkin extends Controller
{
	function __construct() 
	{
       $this->data['heading_title'] = "Skin management";
	   $this->data['route'] = $this->getRoute();
	   $this->load->model("core/skin");
	   $this->load->helper('image');
	 
   	}
	public function index()
	{
		$skinid = $this->request->get['skinid'];
		if($skinid=="")
			$this->getList();
		else
			$this->getForm();
	}
	
	private function getList() 
	{
		$this->data['insert'] = $this->url->http('core/skin/insert');
		$this->data['delete'] = $this->url->http('core/skin/delete');		
		
		
		$rows = $this->model_core_skin->getList();
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
		$this->data['skins'] = array();
		for($i=$offset;$i < $offset + $limit && count($rows[$i])>0;$i++)
		{
			$this->data['skins'][$i] = $rows[$i];
			$imagepreview = "";
			if($rows[$i]['imagepath'] != "")
			{
				$imagepreview = "<img width=100 src='".HelperImage::resizePNG($rows[$i]['imagepath'], 180, 180)."' >";
			}
			$this->data['skins'][$i]['imagepreview'] =$imagepreview;
		}
		
		
		$this->id='content';
		$this->template="core/skin_list.tpl";
		$this->layout="layout/center";
		$this->render();
	}
	
	
	
	public function insert()
	{
		$this->getForm();
	}
	
	public function delete() 
	{		
    	if (isset($this->request->post['delete'])) 
		{
			foreach($this->request->post['delete'] as $item) {
				$this->model_core_skin->delete($item);
			}
			$this->data['output'] = "Delete success";
    	}
	
    	//$this->getList();
		$this->id="content";
		$this->template="common/output.tpl";
		$this->render();
  	}
	
	private function getForm()
	{
		$skinid = $this->request->get['skinid'];
		 $this->data['DIR_UPLOADPHOTO'] = HTTP_SERVER."index.php?route=common/uploadpreview";
		if($skinid)
		{
			$this->data['item']=$this->model_core_skin->getItem($skinid);	
			$this->data['item']['imagethumbnail']=HelperImage::resizePNG($this->data['item']['imagepath'], 180, 180);
		}
		
		$this->id='content';
		$this->template="core/skin_form.tpl";
		$this->layout="layout/center";
		$this->render();
	}
	
	public function save()
	{
		$data = $this->request->post;
		$err = $this->validate($data);
		if(count($err)==0)
		{
			
			
				$skinid = $this->model_core_skin->save($data);
			
			$this->data['output'] ="true";
		}
		else
		{
			foreach($err as $item)
				$this->data['output'] .= $item."<br>";
		}
			
		$this->id='skin';
		$this->template='common/output.tpl';	
		$this->render();
		
	}
	
	function validate($data)
	{
		$err = array();
		if($data['skinid']=="")
			$err['skinid'] ="Skin id not null!";
		if($data['skinname']=="")
			$err['skinname'] ="Skin name not null!";
		
		return $err;
	}
}
?>