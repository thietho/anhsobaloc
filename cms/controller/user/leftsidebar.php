<?php
class ControllerUserLeftsidebar extends Controller
{
	function index()
	{	
		$this->id='sidebar';
		$this->template='user/leftsidebar.tpl';
		$this->render();
	}
	
}
?>