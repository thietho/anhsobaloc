<?php
class ControllerSitebarSitebar extends Controller
{
	public function index()
	{
		$arr = array('catalogue');
		$this->data['catalogue'] = $this->loadModule('module/block','getSitemaps',$arr);
		$this->id="content";
		$this->template="sitebar/sitebar.tpl";
		$this->render();
	}
	
	
}
?>