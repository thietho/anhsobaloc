<?php
class ControllerModuleCategory extends Controller
{
	public function getList($categoryid,$template)
	{
		$this->load->model('core/category');
		$this->data['datas'] = array();
		$this->model_core_category->getTree($categoryid,$this->data['datas']);
		unset($this->data['datas'][0]);
		$this->id="category";
		$this->template=$template['template'];
		$this->render();
	
	}
}
?>