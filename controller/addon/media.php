<?php
class ControllerAddonMedia extends Controller
{
	private $error = array();
	public function index()
	{
		$mediaid = $this->request->get['id'];
		$this->load->model('core/media');
		$this->load->helper('image');
		$this->data['media'] = $this->model_core_media->getItem($mediaid);
		$this->data['media']['imagethumbnail'] = HelperImage::resizePNG($this->data['media']['imagepath'], 150, 150);
		$this->data['media']['description'] = html_entity_decode($this->data['media']['description']);
		$this->id="content";
		$this->template="addon/media.tpl";
		$this->render();
	}
	
}
?>