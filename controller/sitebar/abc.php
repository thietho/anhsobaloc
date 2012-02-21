<?php
class ControllerSitebarAbc extends Controller
{
	public function index()
	{
		$this->data['bangchucai'] = array();
		
		for($i=65;$i<=90;$i++)
		{
			$this->data['bangchucai'][strtolower(chr($i))]	= chr($i);
		}
		$this->data['bangchucai']['0'] = "#";
		$this->id="content";
		$this->template="sitebar/abc.tpl";
		$this->render();
	}
}
?>