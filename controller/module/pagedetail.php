<?php
class ControllerModulePagedetail extends Controller
{	
	public function getForm($sitemapid="",$count=8, $template = array(),$media=array())
	{
		$this->load->model("core/media");
		$this->load->helper('image');
		
		if($sitemapid == "")
			$sitemapid = $this->document->sitemapid;
		$mediaid = $this->request->get['id'];
		$id = $this->request->get['id'];
		$mediaid = $id;
		$siteid = $this->member->getSiteId();
		
		$this->data['post'] = $this->model_core_media->getByAlias($mediaid);
		$this->document->title .= " - ".$this->data['post']['title'];
		if(count($this->data['post']) == 0)
		{
			$this->data['post']['description'] = "Updating...";
		}
		$this->data['post']['summary'] = html_entity_decode($this->data['post']['summary']);
		$this->data['post']['description'] = html_entity_decode($this->data['post']['description']);
		
		if($this->data['post']['imagepath'] != "")
		{
			$this->data['post']['imagethumbnail'] = HelperImage::resizePNG($this->data['post']['imagepath'], $template['width'], $template['height']);
		}
		$this->data['post']['startdate'] = $this->model_core_media->getInformation($mediaid,"startdate");
		$this->data['post']['enddate'] = $this->model_core_media->getInformation($mediaid,"enddate");
		//Get list
		$queryoptions = array();
		$queryoptions['mediaparent'] = '%';
		$queryoptions['mediatype'] = '%';
		$queryoptions['refersitemap'] = $sitemapid;
		$queryoptions['date'] = $this->data['post']['statusdate'];
		$this->data['othernews'] = $this->model_core_media->getOthersMedia($this->data['post']['mediaid'], $queryoptions, $count);
		for($i=0;$i<count($this->data['othernews']);$i++)
		{
			
			$link = $this->document->createLink($sitemapid,$this->data['othernews'][$i]['mediaid']."-".$this->data['othernews'][$i]['alias']);
			$this->data['othernews'][$i]['link'] = $link;
		}
		
		
		$this->id="news";
		$this->template=$template['template'];
		$this->render();
	}
	
	public function getFormProduct($sitemapid="",$count=8, $template = array(),$media=array())
	{
		$this->load->model("core/media");
		$this->load->model("core/category");
		$this->load->model("core/sitemap");
		$this->load->helper('image');
		
		
		$this->data['statuspro'] = array();
		$this->model_core_category->getTree("status",$this->data['statuspro']);
		unset($this->data['statuspro'][0]);
		
		$this->data['nhanhieu'] = array();
		$this->model_core_category->getTree("nhanhieu",$this->data['nhanhieu']);
		unset($this->data['nhanhieu'][0]);
		
		$this->data['nhomhuong'] = array();
		$this->model_core_category->getTree("nhomhuong",$this->data['nhomhuong']);
		unset($this->data['nhomhuong'][0]);
		
		if($sitemapid == "")
			$sitemapid = $this->document->sitemapid;
		$id = $this->request->get['id'];
		
		$mediaid = $id;
		$siteid = $this->member->getSiteId();
		
		$this->data['post'] = $this->model_core_media->getByAlias($mediaid);
		$mediaid = $this->data['post']['mediaid'];
		$this->document->title .= " - ".$this->data['post']['title'];
		if(count($this->data['post']) == 0)
		{
			$this->data['post']['description'] = "Updating...";
		}
		$this->data['post']['summary'] = html_entity_decode($this->data['post']['summary']);
		$this->data['post']['description'] = html_entity_decode($this->data['post']['description']);
		
		$loaisp= $this->string->referSiteMapToArray($this->data['post']['refersitemap']);
		
		foreach($loaisp as $item)
		{
			$this->data['loaisp'][] = $this->model_core_sitemap->getItem($item,$this->member->getSiteId());
		}
		
		//if($this->data['post']['imagepath'] != "")
		{
			$this->data['post']['imagethumbnail'] = HelperImage::resizePNG($this->data['post']['imagepath'], $template['width'], $template['height']);
			$this->data['post']['imagepreview'] = HelperImage::resizePNG($this->data['post']['imagepath'],  800, 800);
		}
		$this->data['properties'] = $this->string->referSiteMapToArray($this->data['post']['groupkeys']);
		
		//Get sub attachment
		$listfile = $this->model_core_media->getInformation($mediaid, "attachment");
		$listfileid=array();
		if($listfile)
			$listfileid=split(",",$listfile);
			
		array_unshift($listfileid,$this->data['post']['imageid']);
		
		$this->data['subimage']=array();
		$this->data['attachment']=array();
		
		foreach($listfileid as $key => $item)
		{
			$file = $this->model_core_file->getFile($item);
			if($this->string->isImage($file['extension']))
			{
				$this->data['subimage'][$key] = $file;
				$this->data['subimage'][$key]['imagethumbnail'] = HelperImage::resizePNG($file['filepath'], $template['width'], $template['height']);
				$this->data['subimage'][$key]['icon'] = HelperImage::resizePNG($file['filepath'], 60, 60);	
				$this->data['subimage'][$key]['imagepreview'] = HelperImage::resizePNG($file['filepath'],  800, 800);
			}
			
			if(!$this->string->isImage($file['extension']))
			{
				$this->data['attachment'][$key] = $file;
				$this->data['attachment'][$key]['imagethumbnail'] = DIR_IMAGE."icon/dinhkem.png";
			}
			
		}
		//Get sub infomation
		
		$this->data['child'] = $this->model_core_media->getListByParent($mediaid," AND mediatype = 'subinfor' Order by position");
		foreach($this->data['child'] as $key => $item)
		{
			$this->data['child'][$key]['imagepreview'] = "<img width=100 src='".HelperImage::resizePNG($item['imagepath'], $template['width'], $template['height'])."' >";
		}
		
		$this->data['priceproduct'] = $this->model_core_media->getListByParent($mediaid," AND mediatype = 'price' Order by position");
		foreach($this->data['priceproduct'] as $key => $item)
		{
			$para = $this->string->referSiteMapToArray($item['summary']);
			foreach($para as $val)
			{
				$ar = split("=",$val);
				$this->data['priceproduct'][$key][$ar[0]] = $ar[1];	
			}
			$khuyenmai = $this->model_core_media->getItem($this->data['priceproduct'][$key]['makhuyenmai']);
			$this->data['priceproduct'][$key]['tenkhuyenmai'] = $khuyenmai['title'];
		}
		
		$queryoptions = array();
		$queryoptions['mediaparent'] = '%';
		$queryoptions['mediatype'] = '%';
		$queryoptions['refersitemap'] = $sitemapid;
		$this->data['othernews'] = $this->model_core_media->getOthersMedia($this->data['post']['mediaid'], $queryoptions, $count);
		
		
		/*$temp = array(
						  'template' => "module/product_list.tpl",
						  'width' => 170,
						  'height' =>170
						  );
		$arr = array($this->document->sitemapid,9,"",$temp,$this->data['othernews']);*/
		//$this->data['other'] = $this->loadModule('module/productlist','index',$arr);
		//Load san phang cung hieu
		$nhanhieuid = "";
		foreach($this->data['nhanhieu'] as $nhanhieu)
		{
			if(in_array($nhanhieu['categoryid'],$this->data['properties']))
				$nhanhieuid = $nhanhieu['categoryid'];
		}
		$where = " AND mediaid not like '".$mediaid."'";
		$arr = array($where,$nhanhieuid);
		$this->data['saphamcungnhanhieu'] = $this->loadModule('addon/brand','getList',$arr);
		//Load comemnt
		$temp = array(
						  'template' => "module/comment_list.tpl"
						  );
		$where = " AND mediaid = '".$mediaid."'";
		$arr = array($where,$temp);
		$this->data['comment'] = $this->loadModule('module/comment','getList',$arr);
		
		$this->id="news";
		$this->template=$template['template'];
		$this->render();
	}
}
?>