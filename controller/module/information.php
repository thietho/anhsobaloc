<?php
class ControllerModuleInformation extends Controller
{
	/*function __construct() 
	{
		$this->iscache = true;
	 	$this->name ="Information".$this->document->sitemapid;
   	}*/
	public function index($sitemapid="")
	{
		$this->load->model("core/media");
		
		if($sitemapid=="")
			$sitemapid = $this->document->sitemapid;
		
		
		$this->data['post'] = $this->model_core_media->getItem($this->member->getSiteId().$sitemapid);
		$this->document->title .= " - ".$this->data['post']['title'];
		if(count($this->data['post']) == 0)
		{
			$this->data['post']['description'] = "Updating...";
		}
		
		$this->data['post']['description'] = html_entity_decode($this->data['post']['description']);
		$this->data['child'] = $this->model_core_media->getListByParent($this->member->getSiteId().$sitemapid," AND mediatype = 'subinfor' Order by position");
		
		$this->id="information";
		$this->template="module/information.tpl";
		$this->render();
	}
}
?>