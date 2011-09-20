<?php
	class ControllerSampleDefaultlist extends Controller
	{
		public function index()
		{
			$this->id="sample_defaultlist";
			$this->template="sample/defaultlist.tpl";
			$this->render();
		}
	}
?>