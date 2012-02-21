<?php
class ControllerSitebarSubmenu extends Controller
{
	public function index($sitemapid)
	{
		$this->load->model('core/sitemap');
		$this->load->model('core/category');
		$this->data['sitemap'] = $this->model_core_sitemap->getItem($sitemapid,$this->member->getSiteId());
		
		$arr = $this->string->referSiteMapToArray($this->document->setup[$sitemapid."-sitebar"]);
		$this->data['brands'] = array();
		foreach($arr as $key => $val)
		{
			$this->data['brands'][$key] = $this->model_core_category->getItem($val);
			$this->data['brands'][$key]['link'] = $this->document->createLink("brand",$val."-".$sitemapid);
		}
		
		$this->id="content";
		$this->template="sitebar/submenu.tpl";
		$this->render();
	}
}
?>