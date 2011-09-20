<?php
class ControllerAddonCheckoutcomplete extends Controller
{
	private $error = array();
	public function index()
	{
		$this->document->breadcrumb .= "Hoàn tất thanh toán";
		$this->getList();
		$this->id="content";
		$this->template="addon/checkoutcomplete.tpl";
		$this->render();
	}
	
	public function getList()
	{
		$orderid = $this->request->get['id'];
		$this->load->model("addon/order");
		$this->load->model("core/media");
		$this->load->helper('image');
		$this->data['medias'] =array();
		$data = $this->model_addon_order->getItem($orderid);
		$this->data['order'] = $data['order'];
		foreach($data['detail'] as $item)
		{
			$mediaid = $item['mediaid'];
			$media = $this->model_core_media->getItem($mediaid);
			$media['imagethumbnail'] = HelperImage::resizePNG($media['imagepath'], 100, 100);
			$media['price'] = $item['price'];
			$media['quantity'] = $item['quantity'];
			$media['discount'] = $item['discount'];
			$media['subtotal'] = $item['subtotal'];
			
			$this->data['medias'][] = $media;
		}
	}
	
}
?>