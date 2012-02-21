<?php
class ControllerCommonBrand extends Controller
{
	public function index()
	{
		$this->getListbrand();
		$this->id="content";
		$this->template="common/brand.tpl";
		$this->render();
	}
	
	private function getListbrand()
	{
		$this->load->model("core/media");
		$this->load->model("core/category");
		$this->load->helper('image');
		$this->data['nhanhieu'] = array();
		$this->model_core_category->getTree("nhanhieu",$this->data['nhanhieu']);
		unset($this->data['nhanhieu'][0]);
		foreach($this->data['nhanhieu'] as $key => $item)
		{
			$media = $this->model_core_media->getItem($this->member->getSiteId().'cat'.$item['categoryid']);
			if($media['imagepath'] != "")
				$this->data['nhanhieu'][$key]['imagethumbnail'] = HelperImage::resizePNG($media['imagepath'], 0,50);
			
		}
	}
}
?>