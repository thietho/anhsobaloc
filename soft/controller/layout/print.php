<?php
class ControllerLayoutPrint extends Controller
{
	public function index()
	{
		$this->template="layout/print.tpl";
			
		$this->render();
	}
}
?>