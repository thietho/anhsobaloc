<?php
class ControllerSitebarExchange extends Controller
{
	public function index()
	{
		$this->data['tygia'] = $this->loadModule("common/tygia");
		$this->data['giavang'] = $this->loadModule("common/goldrate");
		$this->id="content";
		$this->template="sitebar/exchange.tpl";
		$this->render();
	}
}
?>