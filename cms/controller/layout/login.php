<?php
	class ControllerLayoutLogin extends Controller
	{
		public function index()
		{
			$this->template="layout/login.tpl";
			$this->children=array(
				'common/header',
				'common/footer'
			);
			$this->render();
		}
	}
?>