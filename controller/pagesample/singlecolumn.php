<?php
	class ControllerPagesampleSinglecolumn extends Controller
	{
		public function index()
		{
			$this->id="content";
			$this->template="pagesample/singlecolumn.tpl";
			$this->layout="layout/home";
			$this->render();
		}
	}
?>