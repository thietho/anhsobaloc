<?php
class ControllerCommonWarring extends Controller
{
	private $error = array();
	public function index()
	{
		$this->document->breadcrumb .= $this->data['text_cart'];
		
		$this->id="content";
		$this->template="addon/cart.tpl";
		$this->render();
	}
	
	function getItem($mediaid)
	{
		$this->load->model("core/media");
		$this->load->helper('image');
		$media = $this->model_core_media->getItem($mediaid);
		$price = $media['price'];
		$parent = $this->model_core_media->getItem($media['mediaparent']);
		if(count($parent))
		{
			$media['imagethumbnail'] = HelperImage::resizePNG($parent['imagepath'], 100, 100);
			$title = $parent['title'];
			if($media['title'] !="")
				$title .= "-". $media['title'];
			$media['title'] = $title;
		}
		else
		{
			$media['imagethumbnail'] = HelperImage::resizePNG($media['imagepath'], 100, 100);
			
		}
		return $media;
	}
	
	public function cart()
	{
		
		$data = $this->request->get;
		if(!isset($_SESSION['cart']))
		{
			$_SESSION['cart'] = array();	
		}
		$mediaid = $data['mediaid'];
		
		$this->data['media'] = $this->getItem($mediaid);

		$this->id='content';
		$this->template='warring/cart.tpl';
		$this->render();
	}
}
?>