<?php
class ControllerAddonBrandinfor extends Controller
{
	private $error = array();
	public function index()
	{	
		$this->load->model("core/media");
		$this->load->model("core/category");
		$this->load->helper('image');
		$id = $this->request->get['id'];
		$mediaid = $this->member->getSiteId()."cat".$id;
		$this->data['media'] = $this->model_core_media->getItem($mediaid);
		
		$this->document->title .= " - ".$this->data['media']['title'];
		
		$this->data['media']['imagethumbnail'] = HelperImage::resizePNG($this->data['media']['imagepath'], 300,0);
		$this->data['media']['summary'] = html_entity_decode($this->data['media']['summary']);
		$this->data['media']['description'] = html_entity_decode($this->data['media']['description']);
		$this->data['media']['link'] = $this->document->createLink(str_replace($this->member->getSiteId(),"",$mediaid));
		
		$where = "";
		$arr = array($where,$nhanhieuid);
		$this->data['saphamcungnhanhieu'] = $this->loadModule('addon/brand','getList',$arr);
		
		$this->id="content";
		$this->template="addon/brandinfor.tpl";
		$this->render();	
	}
}
?>