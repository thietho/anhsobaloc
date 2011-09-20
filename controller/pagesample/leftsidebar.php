<?php
	class ControllerPagesampleLeftsidebar extends Controller
	{
		public function index()
		{
			$this->id="content";
			$this->template="pagesample/leftsidebar.tpl";
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