<?php
	class ControllerPageHome extends Controller
	{
		public function index()
		{
			$this->id="content";
			$this->template="page/home.tpl";
			$this->layout="layout/center";
			$this->response->redirect('?route=core/message');
			$this->render();
		}
	}
?>