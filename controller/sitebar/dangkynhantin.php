<?php
class ControllerSitebarDangkynhantin extends Controller
{
	public function index()
	{
		$this->id="content";
		$this->template="sitebar/dangkynhantin.tpl";
		$this->render();
	}
}
?>