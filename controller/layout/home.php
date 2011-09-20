<?php
class ControllerLayoutHome extends Controller
{
	public function index()
	{
		$this->data['title'] = $this->document->title;
		$this->data['meta_description'] = $this->document->meta_description;
		$this->data['meta_keyword'] = $this->document->meta_keyword;
		$this->template="layout/home.tpl";
		$this->children=array(
			'common/header',
			'common/footer'
		);
		$this->render();
	}
}
?>