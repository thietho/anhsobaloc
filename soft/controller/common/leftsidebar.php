<?php
	class ControllerCommonLeftsidebar extends Controller
	{
		function index()
		{	
			$this->id='sidebar';
			$this->template='common/leftsidebar.tpl';
			$this->data['sitemapmenu'] = $this->loadModule('common/sitemapmenu');
			$this->render();
		}
		
	}
?>