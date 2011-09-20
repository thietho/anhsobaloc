<?php
	class ControllerSampleBlanklist extends Controller
	{
		public function index()
		{
			$this->id="sample_blanklist";
			$this->template="sample/blanklist.tpl";
			$this->render();
		}
	}
?>