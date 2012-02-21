<?php
class ControllerAddonBrand extends Controller
{
	private $error = array();
	public function index()
	{
		
		$this->getList();
		
	}
	
	public function getList($where="",$categoryid="",$sitemapid ="")
	{
		$this->load->model("core/media");
		$this->load->model("core/sitemap");
		if($categoryid=="")
		{
			$arr = split("-",$this->request->get['id']);
			$categoryid = $arr[0];
			$sitemapid = $arr[1];
		}
		$header = $this->document->getCategory($categoryid);
		$sitemap = $this->model_core_sitemap->getItem($sitemapid,$this->member->getSiteId());
		if($sitemapid == "")	
		{
			$this->document->breadcrumb .= '<a href="' .$this->document->createLink("brand",$categoryid).'">'.$header."</a>";
		}
		else
		{
			$this->document->breadcrumb .= '<a href="' .$this->document->createLink($sitemap['sitemapid']).'">'.$sitemap['sitemapname']."</a> » ". '<a href="' .$this->document->createLink("brand",$categoryid."-".$sitemapid).'">'.$header.'</a>';
		}
		$where .= " AND groupkeys like '%[".$categoryid."]%'";
		if($sitemapid)
			$where .= " AND refersitemap like '%[".$sitemapid."]%'";
		
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
		}
		
		$medias = $this->model_core_media->getList($where.$orderby);
		
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
							  'width' => 108,
							  'height' =>108,
							  'widthpreview' => 450,
						 	  'heightpreview' =>450
							  );
		$arr = array("",16,$header,$template,$medias);
		$this->data['output'] = $this->loadModule('module/productlist','index',$arr);
			
		$this->id="content";
		$this->template="common/output.tpl";
		$this->render();	
	}
}
?>