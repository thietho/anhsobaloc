<?php
class ControllerCoreBackup extends Controller
{
	public function index()
	{
		$this->load->model('core/backup');
		$this->model_core_backup->backupData();
		$this->data['output'] = "";
		$this->id="content";
		$this->template="common/output.tpl";
		$this->layout="layout/center";
		$this->render();
	}
}
?>