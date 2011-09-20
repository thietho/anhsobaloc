<?php
class ControllerAddonSearch extends Controller
{
	private $error = array();
	public function index()
	{
		$keyword = $this->request->get['keyword'];
		$this->document->breadcrumb .= "Kết quả tìm kiếm với từ khóa: '$keyword'";
		$this->getList($keyword);
		$this->id="content";
		$this->template="addon/search.tpl";
		$this->render();
	}
	
	private function getList($keyword)
	{
		$this->load->model("core/media");
		$this->load->model("core/sitemap");
		$this->load->helper('image');
		
		$siteid = $this->member->getSiteId();
		$arrsitemap = $this->model_core_sitemap->getListByModule('module/news', $siteid);
		$listsitemapid =array();
		foreach($arrsitemap as $item)
			$listsitemapid[] = $item['sitemapid'];
		
		$arrsitemap = $this->model_core_sitemap->getListByModule('module/product', $siteid);
		foreach($arrsitemap as $item)
			$listsitemapid[] = $item['sitemapid'];
		//$this->document->title .= " - ".$this->data['sitemap']['sitemapname'];
		$step = (int)$this->request->get['step'];
		$to = $count;
		//
		//Get list
		$queryoptions = array();
		$queryoptions['keyword'] = $keyword;
		$queryoptions['mediaparent'] = '%';
		$queryoptions['mediatype'] = '%';
		$queryoptions['refersitemap'] = $listsitemapid;
		
		if($mediaid == "")
		{
			$medias = $this->model_core_media->getPaginationList($queryoptions);
			
			$this->data['medias'] = array();
			
		
			$index = -1;
			foreach($medias as $media)
			{
				$index += 1;
				if($sitemapid == "")
				{
					$arr = $this->string->referSiteMapToArray($media['refersitemap']);
					$sitemapid = $arr[0];
				}
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
			
			
		}
	}
}
?>