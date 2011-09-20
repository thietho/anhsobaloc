<?php
	class ControllerPagesampleStyledemo extends Controller
	{
		public function index()
		{
			$this->id="content";
			$this->template="pagesample/styledemo.tpl";
			$this->layout="layout/home";
			$this->children = array(
				'sample_defaultlist' => 'sample/defaultlist',
				'sample_blanklist' => 'sample/blanklist',
				'sample_nicelist' => 'sample/nicelist'
			);
			$this->render();
		}
	}
?>