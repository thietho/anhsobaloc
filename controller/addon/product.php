<?php
class ControllerAddonProduct extends Controller
{
	private $error = array();
	public function index()
	{
		
		//$this->document->breadcrumb .= "Tìm kiếm sản phẩm";
		$this->getList();
		$this->id="content";
		$this->template="common/output.tpl";
		$this->render();
	}
	
	private function getList()
	{
		$this->load->model("core/media");
		$this->load->model("core/sitemap");
		$this->load->helper('image');
		$donvi = 1000;
		$para = $this->string->referSiteMapToArray($_GET['search']);
		
		if(count($para))
		{
			foreach($para as $val)
			{
				$ar = split("=",$val);
				$datasearch[$ar[0]] = $ar[1];	
			}
			$_GET = array_merge($_GET,$datasearch);

			
			
			$arr = array();
			
			foreach($datasearch as $key => $item)
			{
				if($item !="" && $key != "gia" && $key != "keyword" && $key != "loaisp")
					$arr[] = " AND groupkeys like '%[".$item."]%'";
					
				if($key == "loaisp")
					$arr[] = " AND refersitemap like '%[".$item."]%'";
				
			}
			
			
			
			$where = implode("",$arr);
			if($datasearch["keyword"]!="")
			{
				
				$where .= " AND ( title like '%".$datasearch["keyword"]."%' OR summary like '%".$datasearch["keyword"]."%' OR description like '%".$datasearch["keyword"]."%')";
			}
		}
		
		if($_GET['nhanhieu'] != "")
			$this->document->breadcrumb .= $this->document->getCategory($_GET['nhanhieu']);
			
		if($_GET['nhomhuong'] != "")
			$this->document->breadcrumb .= $this->document->getCategory($_GET['nhomhuong']);
		if($_GET['gia'] != "")
		{
			$gia = split("-",$_GET['gia']);
			 $baogia = "Sản phẩm giá từ ".$this->string->numberFormate($gia[0]*$donvi)." đ đến ".$this->string->numberFormate($gia[1]*$donvi)." đ";
			if($gia[0]==0)
				$baogia = "Sản phẩm giá dưới ".$this->string->numberFormate($gia[1]*$donvi)." đ";
			if($gia[1]==0)
				$baogia = "Sản phẩm giá từ ".$this->string->numberFormate($gia[0]*$donvi)." đ trở lên";
			
			$this->document->breadcrumb .= $baogia;
		}
		if($_GET['keyword'] != "")
		{
			$ch = "";
			if(count($_GET)>1)
				$ch = " » ";
			$this->document->breadcrumb .= $ch."Tìm kiếm sản phẩm với từ khóa: " . $_GET['keyword'];
		}
		$siteid = $this->member->getSiteId();
		
		$arrsitemap = $this->model_core_sitemap->getListByModule('module/product', $siteid);
		foreach($arrsitemap as $item)
			$listsitemapid[] = $item['sitemapid'];
		$arr = array();
		foreach($listsitemapid as $item)
		{
			$arr[] = " refersitemap like '%[".$item."]%'";
		}
		$hasprice = false;
		if($datasearch['gia'] != "")
		{
			$hasprice = true;
			$arrgia = split("-",$datasearch['gia']);
			$giatu = (int)$arrgia[0];
			$giaden = (int)$arrgia[1];
			if($giatu)
				$whereprice = " AND price >= '".$giatu*$donvi ."'";
			if($giaden)
				$whereprice.= " AND price <= '".$giaden*$donvi ."'";
			$whereprice;
			$mediaprice = $this->model_core_media->getList($whereprice);
			
			$listparent = $this->string->matrixToArray($mediaprice,"mediaparent");
		}
		
		$where .= "AND (". implode($arr," OR ").")";
		
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
		else
		{
			if($hasprice)
				$medias = array();	
		}
		
		$template = array(
							  'template' => "module/product_list.tpl",
							  'width' => 108,
							  'height' =>108,
							  'widthpreview' => 450,
						 	  'heightpreview' =>450
							  );
		$arr = array("",16,"Kết quả tìm kiếm",$template,$medias);
		$this->data['output'] = $this->loadModule('module/productlist','index',$arr);
			
			
	}
}
?>