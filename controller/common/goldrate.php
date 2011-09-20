<?php
class ControllerCommonGoldrate extends Controller
{
	public function index()
	{
		
		$tygiaurl ="http://www.sacombank-sbj.com/service/tygiatrongnuoc.ashx"; 
		@$content = file_get_contents($tygiaurl);
		$this->data['output'] = $content;
		$this->id="content";
		$this->template="common/goldrate.tpl";
		$this->render();
	}
}
?>