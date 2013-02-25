<?php
	class ControllerPageHome extends Controller
	{
		public function index()
		{
			$this->id="content";
			$this->template="page/home.tpl";
			$this->layout=$this->user->getLayout();
			$this->response->redirect('?route=addon/biennhan');
			$this->render();
		}
	}
?>