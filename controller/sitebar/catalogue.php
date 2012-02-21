<?php
class ControllerSitebarCatalogue extends Controller
{
	public function index($sitemapid = "",$status = "Active" )
	{
		$siteid = $this->member->getSiteId();
		$this->data['sitemap'] = $this->model_core_sitemap->getItem($sitemapid, $siteid);
		$this->data['menu'] = $this->getMenu($sitemapid,$status);
		$this->data['path'] = $this->model_core_sitemap->getPath($this->document->sitemapid, $siteid);
		//print_r($this->data['path']);
		//unset($this->data['path'][0]);
		//unset($this->data['path'][1]);
		
		$this->id="content";
		$this->template="sitebar/catalogue.tpl";
		$this->render();
	}
	
	public function getMenu($parentid,$status)
	{
		$siteid = $this->user->getSiteId();
		$str = "";
		
		$sitemaps = $this->model_core_sitemap->getListByParent($parentid, $siteid, $status);
		
		foreach($sitemaps as $item)
		{
			$childs = $this->model_core_sitemap->getListByParent($item['sitemapid'], $siteid, $status);
			
			$link = "<a class='left'>".$item['sitemapname']."</a>";
			
			if(substr($item['moduleid'],0,6) == "group/")
			{
				$item['moduleid'] = "module/information";
			}
			
			
			if($item['moduleid'] != "group" && $item['moduleid'] != "homepage")
			{
				//$link='<a class="left" href="?route='.$item['moduleid']."&sitemapid=".$item['sitemapid'].'" title="[Detail]">'.$item['sitemapname'].'</a>';
				$link = "<a  href='".$this->document->createLink($item['sitemapid'])."'>".$item['sitemapname']."</a>";
			}
			
			$str .= "<li>";
			$str .= "<div class='collape'>";
			$str .= $link;
			
			if(count($childs) > 0)
			{
				$str .= "<span class='collape right'>[+]</span>";
				$str .= '<div class="clearer">&nbsp;</div>';
				$str .= "</div>";
				
				$str .= "<ul id='".$item['sitemapid']."'>";
				$str .= $this->getMenu($item['sitemapid'],$status);
				$str .= "</ul>";
			}
			else
			{
				$str .= '<div class="clearer">^&nbsp;</div>';
				$str .= "</div>";
				
			}
			$str .= "</li>";
		}
		
		return $str;
		
	}
}
?>