<?php
class ControllerSitebarSearch extends Controller
{
	public function index()
	{
		$this->id="content";		
		$this->template="sitebar/search.tpl";
		
		$this->render();
	}
	
	
}
?>