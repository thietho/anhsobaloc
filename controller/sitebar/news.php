<?php
class ControllerSitebarNews extends Controller
{
	public function index($sitemapid="", $count = 10,$headername ="", $template = array(),$medias=array())
	{
		$this->load->model("core/media");
		$this->load->model("core/sitemap");
		$this->load->helper('image');
		
		
		$siteid = $this->member->getSiteId();
		$this->data['sitemap'] = $this->model_core_sitemap->getItem($sitemapid, $siteid);
		if($headername!="")
			$this->data['sitemap']['sitemapname'] = $headername;
		
		$step = 0;
		$to = $count;
		
		//Get list
		$queryoptions = array();
		$queryoptions['mediaparent'] = '%';
		$queryoptions['mediatype'] = '%';
		$queryoptions['refersitemap'] = $sitemapid;
		$medias = $this->model_core_media->getPaginationList($queryoptions, $step, $to);
		$index = -1;
		foreach($medias as $media)
		{
			$index += 1;
			
			$link = $this->document->createLink($sitemapid,$media['alias']);
			
			$imagethumbnail = "";
			if($media['imagepath'] != ""  )
			{
				$imagethumbnail = HelperImage::resizePNG($media['imagepath'],$template['width'], $template['height']);
			}

			
			$this->data['medias'][] = array(
				'mediaid' => $media['mediaid'],
				'title' => $media['title'],
				'summary' => $media['summary'],
				'imagethumbnail' => $imagethumbnail,
				'statusdate' => $this->date->formatMySQLDate($media['statusdate'], 'longdate', "/"),
				'link' => $link
			);
			
		}
		
		$this->id="content";
		$this->template=$template['template'];
		$this->render();
	}
}
?>