<?php
class ControllerModuleGallery extends Controller
{
	function index()
	{	
		$this->id='content';
		
		
		if($this->request->get['mediaid'] != "" || $this->request->get['formtype']=='add')
		{
			$this->data['output'] = $this->loadModule('core/postcontent');
		}
		else
		{
			$this->data['output'] = $this->loadModule('core/postlist');
		}
		
		$this->template='common/output.tpl';
		$this->layout='layout/center';
		$this->render();
	}
	
	public function insert()
	{
		$this->data['output'] = $this->loadModule('core/postcontent');
		$this->id='content';
		$this->template='common/output.tpl';
		$this->layout='layout/center';
		$this->render();
	}
	
	public function update()
	{
		$this->data['output'] = $this->loadModule('core/postcontent');
		$this->id='content';
		$this->template='common/output.tpl';
		$this->layout='layout/center';
		$this->render();
	}
}
?>