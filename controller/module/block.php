<?php
class ControllerModuleBlock extends Controller
{
	public function getList($sitemapid="", $count = 5,$headername = "", $template = array(),$medias=array())
	{
		$this->load->model("core/media");
		$this->load->model("core/sitemap");
		$this->load->helper('image');
		if($sitemapid == "")
			$sitemapid = $this->document->sitemapid;
		$siteid = $this->member->getSiteId();
		$this->data['sitemap'] = $this->model_core_sitemap->getItem($sitemapid, $siteid);
		//$this->document->title .= " - ".$this->data['sitemap']['sitemapname'];
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
				$this->data['othernews'][$i]['link'] = HTTP_SERVER."?route=page/detail&sitemapid=".$sitemapid."&mediaid=".$this->data['othernews'][$i]['mediaid'];
			}
			
		}
		
		$this->id="news";
		$this->template=$template['template'];
		$this->render();
	
	}
	
	public function getSitemaps($sitemapid="",$count = 0,$headername = "", $template = array())
	{
		$this->load->model('core/sitemap');	
		$siteid = $this->member->getSiteId();
		$this->data['sitemap'] = $this->model_core_sitemap->getItem($sitemapid, $siteid);
		$this->data['list']=$this->getMenu($sitemapid);
		$this->id="sitemap";
		$this->template="sitebar/catalogue.tpl";
		$this->render();
	}
	
	public function getMenu($parentid)
	{
		
		
		$siteid = $this->member->getSiteId();
		
		$rootid = $this->model_core_sitemap->getRoot($this->document->sitemapid, $siteid);

		if($this->document->sitemapid == "")
			$rootid = 'homepage';
		$str = "";
		
		
		$sitemaps = $this->model_core_sitemap->getListByParent($parentid, $siteid);
		
		foreach($sitemaps as $item)
		{
			$childs = $this->model_core_sitemap->getListByParent($item['sitemapid'], $siteid);
			
			$currenttab = "";
			if($item['sitemapid'] == $rootid) 
				$currenttab = "class='current-tab'";
			
			$link = "<a ".$currenttab.">".$item['sitemapname']."</a>";
			
			if($item['moduleid'] != "group")
			{
				$link = "<a ".$currenttab." href='".HTTP_SERVER."site/".$siteid."/".$item['sitemapid']."'>".$item['sitemapname']."</a>";
			}
			if($item['moduleid'] == "homepage"){
				$link = "<a ".$currenttab." href='index.php'>".$item['sitemapname']."</a>";
			}
			
			$str .= "<li>";
			$str .= $link;
			
			if(count($childs) > 0)
			{
				$str .= "<ul>";
				$str .= $this->getMenu($item['sitemapid']);
				$str .= "</ul>";
			}

			$str .= "</li>";
		}
		
		return $str;
		
	}
	
	public function getMenuChild($parentid,$headername = "", $template = array())
	{
		
		$siteid = $this->member->getSiteId();
		$sitemaps = $this->model_core_sitemap->getListByParent($parentid, $siteid);
		$medias = array();
		foreach($sitemaps as $key =>$item)
		{
			$medias[$key] = $this->model_core_media->getItem($this->member->getSiteId().$item['sitemapid']);
			$medias[$key]['headertitle'] = $item['sitemapname'];
			$link = HTTP_SERVER."site/".$siteid."/".$item['sitemapid'];
				
			$imagethumbnail = "";
			if($medias[$key]['imagepath'] != "" && $template['width'] >0 )
			{
				$imagethumbnail = HelperImage::fixsize($medias[$key]['imagepath'], $template['width'], $template['height']);
			}
			$medias[$key]['imagethumbnail'] =$imagethumbnail;
			$medias[$key]['link'] =$link;
		}
		$this->data['medias'] = $medias;
		$this->id="news";
		$this->template=$template['template'];
		$this->render();
		
	}
	
	public function showMenuContent($arrmenuid,$headername = "", $template = array())
	{
		
		$siteid = $this->member->getSiteId();
		$where = "AND sitemapid in ('".implode("','",$arrmenuid)."')";
		$sitemaps = $this->model_core_sitemap->getList($siteid,$where);
		
		$medias = array();
		foreach($sitemaps as $key =>$item)
		{
			$medias[$key] = $this->model_core_media->getItem($this->member->getSiteId().$item['sitemapid']);
			$medias[$key]['headertitle'] = $item['sitemapname'];
			$link = HTTP_SERVER."site/".$siteid."/".$item['sitemapid'];
				
			$imagethumbnail = "";
			if($medias[$key]['imagepath'] != "" && $template['width'] >0 )
			{
				$imagethumbnail = HelperImage::fixsize($medias[$key]['imagepath'], $template['width'], $template['height']);
			}
			$medias[$key]['imagethumbnail'] =$imagethumbnail;
			$medias[$key]['link'] =$link;
		}
		$this->data['medias'] = $medias;
		$this->id="news";
		$this->template=$template['template'];
		$this->render();
		
	}
}
?>