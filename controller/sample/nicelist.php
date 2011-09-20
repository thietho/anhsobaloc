<?php
	class ControllerSampleNicelist extends Controller
	{
		public function index()
		{
			$this->id="sample_nicelist";
			$this->template="sample/nicelist.tpl";
			$this->render();
		}
	}
?>