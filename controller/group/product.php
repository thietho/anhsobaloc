<?php
class ControllerGroupProduct extends Controller
{
	private $error = array();
	public function index()
	{
		$this->getList($this->document->sitemapid);
		$this->id="content";
		$this->template="common/output.tpl";
		$this->render();
	}
	
	private function getList($sitemapid)
	{
		$this->load->model("core/media");
		$this->load->model("core/sitemap");
		
		$siteid = $this->member->getSiteId();
		$sitemaps = array();
		$this->model_core_sitemap->getTreeSitemap($sitemapid, $sitemaps, $siteid);
		$arrsitemapid = $this->string->matrixToArray($sitemaps,"sitemapid");
		$queryoptions = array();
		$queryoptions['mediaparent'] = '%';
		$queryoptions['mediatype'] = '%';
		$options['refersitemap'] = $arrsitemapid;
		
		
		$order = $_GET['order'];
		$orderby = "";
		switch($order)
		{
			case "az":
				$orderby = " ORDER BY `title` ASC";
				break;
			case "gt":
				$orderby = " ORDER BY `price` ASC";
				break;
			case "gg":
				$orderby = " ORDER BY `price` DESC";
				break;
			default:
				$orderby = " ORDER BY `updateddate` DESC";
		}
		$medias = $this->model_core_media->getPaginationList($options, 0,0,$orderby);
		
		if(count($listparent))
		{
			$data = array();
			foreach($medias as $key =>$item)
			{
				if(!in_array($item['mediaid'],$listparent))
				{
					unset($medias[$key]);	
				}
				else
				{
					$data[] = $item;	
				}
			}
			$medias = $data;
		}
		
		$template = array(
							  'template' => "module/product_list.tpl",
							  'width' => 150,
							  'height' =>150,
							  'paging' => true,
							  'sorting' =>true
							  );
		$arr = array("",16,$header,$template,$medias);
		$this->data['output'] = $this->loadModule('module/productlist','index',$arr);
			
			
	}
}
?>