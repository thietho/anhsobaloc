<?php
class ControllerSitebarNuochoatheogia extends Controller
{
	public function index()
	{
		$this->load->model('core/category');
		$this->data['gia'] = array();
		$this->model_core_category->getTree("gia",$this->data['gia']);
		unset($this->data['gia'][0]);
		$this->id="content";
		$this->template="sitebar/nuochoatheogia.tpl";
		$this->render();
	}
}
?>