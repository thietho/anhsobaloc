<?php
class ControllerAddonCart extends Controller
{
	private $error = array();
	public function index()
	{
		$this->document->breadcrumb .= $this->data['text_cart'];
		
		$this->id="content";
		$this->template="addon/cart.tpl";
		$this->render();
	}
	
	public function getList()
	{
		$this->data['medias'] =array();
		if(isset($_SESSION['cart']))
		{
			$this->data['medias'] = $_SESSION['cart'];
		}
		
		$this->id="content";
		$this->template="addon/cart_list.tpl";
		$this->render();
	}
	
	public function add()
	{
		$this->load->model("core/media");
		$this->load->helper('image');
		$data = $this->request->get;
		if(!isset($_SESSION['cart']))
		{
			$_SESSION['cart'] = array();	
		}
		$mediaid = $data['mediaid'];
		$media = $this->model_core_media->getItem($mediaid);
		$price = $media['price'];
		$parent = $this->model_core_media->getItem($media['mediaparent']);
		if(count($parent))
		{
			$media['imagethumbnail'] = HelperImage::resizePNG($parent['imagepath'], 100, 100);
			$title = $parent['title'];
			if($media['title'] !="")
				$title .= "-". $media['title'];
		}
		else
		{
			$media['imagethumbnail'] = HelperImage::resizePNG($media['imagepath'], 100, 100);
			$title = $media['title'];
			$price = $media['price'];
		}
		$qty =(int)$_SESSION['cart'][$mediaid]['qty'];
		
		$_SESSION['cart'][$mediaid] = array(
											'mediaid' => $mediaid,
											'title' => $title,
											'price' => $price,
											'imagethumbnail' => $media['imagethumbnail'],
											'qty' => $qty+1
											);
		$this->data['output'] = "true";
		$this->id='content';
		$this->template='common/output.tpl';
		$this->render();
	}
	
	public function update()
	{
		$this->load->model("core/media");
		$this->load->helper('image');
		$data = $this->request->get;
		if(!isset($_SESSION['cart']))
		{
			$_SESSION['cart'] = array();	
		}
		$mediaid = $data['mediaid'];
		$media = $this->model_core_media->getItem($mediaid);
		$media['imagethumbnail'] = HelperImage::resizePNG($media['imagepath'], 100, 100);
		$qty =  $this->string->toNumber($data['qty']);
		$_SESSION['cart'][$mediaid]['qty'] = $qty;
		
		$this->data['output'] = "true";
		$this->id='content';
		$this->template='common/output.tpl';
		$this->render();
	}
	
	public function remove()
	{
		$data = $this->request->get;	
		$mediaid = $data['mediaid'];
		unset($_SESSION['cart'][$mediaid]);
		
		$this->data['output'] = "true";
		$this->id='content';
		$this->template='common/output.tpl';
		$this->render();
	}
}
?>