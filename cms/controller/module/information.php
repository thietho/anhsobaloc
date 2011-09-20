<?php
class ControllerModuleInformation extends Controller
{
	function index()
	{	
		$this->id='content';
		$this->data['output'] = $this->loadModule('core/postcontent');
		$this->template='common/output.tpl';
		$this->layout='layout/center';
		$this->render();
	}
	
}
?>