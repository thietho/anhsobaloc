<?php
class ControllerModulePagelist extends Controller
{
	public function getList($sitemapid="", $count = 10,$headername ="", $template = array(),$medias=array())
	{
		$this->load->model("core/media");
		$this->load->model("core/sitemap");
		$this->load->helper('image');
		if($sitemapid == "")
			$sitemapid = $this->document->sitemapid;
		$siteid = $this->member->getSiteId();
		$this->data['sitemap'] = $this->model_core_sitemap->getItem($sitemapid, $siteid);
		$this->document->title .= " - ".$this->data['sitemap']['sitemapname'];
		$step = (int)$this->request->get['step'];
		$to = $count;
		
		//Get list
		$queryoptions = array();
		$queryoptions['mediaparent'] = '%';
		$queryoptions['mediatype'] = '%';
		$queryoptions['refersitemap'] = $sitemapid;
		
		if($mediaid == "")
		{
			$medias = $this->model_core_media->getPaginationList($queryoptions, $step, $to);
			
			if(count($medias) == 1)
			{
				
			}
			
			$this->data['medias'] = array();
			
		
			$index = -1;
			foreach($medias as $media)
			{
				$index += 1;
				
				$link = HTTP_SERVER."site/".$siteid."/".$sitemapid."/".$media['mediaid'];
				
				$imagethumbnail = "";
				if($media['imagepath'] != "" && $template['width'] >0 )
				{
					$imagethumbnail = HelperImage::resizePNG($media['imagepath'], $template['width'], $template['height']);
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
			
			$querystring = "?route=page/detail&sitemapid=".$sitemapid;
			
			$pagelinks = $this->model_core_media->getPaginationLinks($index, $queryoptions, $querystring, $step, $to);
			
			$this->data['nextlink'] = $pagelinks['nextlink'];
			$this->data['prevlink'] = $pagelinks['prevlink'];
			
			//Other news
			$this->data['othernews'] = $this->model_core_media->getPaginationList($queryoptions, $step+1, $to);
			for($i=0;$i<count($this->data['othernews']);$i++)
			{
				$this->data['othernews'][$i]['statusdate'] = $this->date->formatMySQLDate($this->data['othernews'][$i]['statusdate'], 'longdate', "/");
				$link = HTTP_SERVER."site/".$siteid."/".$sitemapid."/".$this->data['othernews'][$i]['mediaid'];
				$this->data['othernews'][$i]['link'] = $link;
			}
			
		}
		
		$this->id="news";
		$this->template=$template['template'];
		$this->render();
	
	}
	
	
}
?>