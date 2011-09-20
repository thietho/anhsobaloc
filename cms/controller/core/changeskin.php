<?php
class ControllerCoreChangeskin extends Controller
{
	function __construct() 
	{
		$this->data['permissionAccess'] = true;
		$this->data['permissionAdd'] = true;
		$this->data['permissionEdit'] = true;
		$this->data['permissionDelete'] = true;
		
		$sitemapid = $this->request->get['sitemapid'];
		
		if(!$this->user->hasPermission($this->getRoute(), "access"))
		{
			$this->data['permissionAccess'] = false;	
		}
		if(!$this->user->hasPermission($this->getRoute(), "add"))
		{
			$this->data['permissionAdd'] = false;
		}
		if(!$this->user->hasPermission($this->getRoute(), "edit"))
		{
			$this->data['permissionEdit'] = false;
		}
		if(!$this->user->hasPermission($this->getRoute(), "delete"))
		{
			$this->data['permissionDelete'] = false;
		}
		
		
		$this->data['heading_title'] = "Change skin";
		$this->data['route'] = $this->getRoute();
		$this->load->model("core/skin");
		$this->load->helper('image');
	 
   	}
	public function index()
	{
		if(!$this->data['permissionAccess'])
			$this->response->redirect("?route=common/permission");
		$this->data['curentskin'] = $this->document->setting->skin;
		$this->getList();
		$this->id='content';
		$this->template="core/changeskin.tpl";
		$this->layout="layout/center";
		$this->render();
	}
	
	private function getList() 
	{
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
	}
	
	public function save()
	{
		$selectskin = $this->request->post['selectskin'];
		$this->document->setValue('skin',$selectskin);
		
		$this->data['output']="Change skin sussec";
		$this->id='skin';
		$this->template='common/output.tpl';	
		$this->render();
	}
}
?>