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
		$siteid = $this->member->getSiteId();
		
		$this->data['post'] = $this->model_core_media->getItem($mediaid);
		$this->document->title .= " - ".$this->data['post']['title'];
		if(count($this->data['post']) == 0)
		{
			$this->data['post']['description'] = "Updating...";
		}
		
		$this->data['post']['description'] = html_entity_decode($this->data['post']['description']);
		
		if($this->data['post']['imagepath'] != "")
		{
			$this->data['post']['imagethumbnail'] = HelperImage::resizePNG($this->data['post']['imagepath'], $template['width'], $template['height']);
		}
		
		//Get list
		$queryoptions = array();
		$queryoptions['mediaparent'] = '%';
		$queryoptions['mediatype'] = '%';
		$queryoptions['refersitemap'] = $sitemapid;
		$queryoptions['date'] = $this->data['post']['statusdate'];
		$this->data['othernews'] = $this->model_core_media->getOthersMedia($mediaid, $queryoptions, $count);
		for($i=0;$i<count($this->data['othernews']);$i++)
		{
			$link = HTTP_SERVER."site/".$siteid."/".$sitemapid."/".$this->data['othernews'][$i]['mediaid'];
			$this->data['othernews'][$i]['link'] = $link;
		}
		
		
		$this->id="news";
		$this->template=$template['template'];
		$this->render();
	}
	
	public function getFormProduct($sitemapid="",$count=8, $template = array(),$media=array())
	{
		$this->load->model("core/media");
		$this->load->helper('image');
		
		if($sitemapid == "")
			$sitemapid = $this->document->sitemapid;
		$mediaid = $this->request->get['id'];
		$siteid = $this->member->getSiteId();
		
		$this->data['post'] = $this->model_core_media->getItem($mediaid);
		$this->document->title .= " - ".$this->data['post']['title'];
		if(count($this->data['post']) == 0)
		{
			$this->data['post']['description'] = "Updating...";
		}
		$this->data['post']['summary'] = str_replace(chr(13),"<br>",$this->data['post']['summary']);
		$this->data['post']['description'] = html_entity_decode($this->data['post']['description']);
		
		if($this->data['post']['imagepath'] != "")
		{
			$this->data['post']['imagethumbnail'] = HelperImage::resizePNG($this->data['post']['imagepath'], $template['width'], $template['height']);
		}
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
			$this->data['attachment'][$key] = $this->model_core_file->getFile($item);
			if($this->string->isImage($this->data['attachment'][$key]['extension']))
			{
				$this->data['subimage'][$key]['imagethumbnail'] = HelperImage::resizePNG($this->data['attachment'][$key]['filepath'], 50, 50);	
				$this->data['subimage'][$key]['imagepreview'] = HelperImage::resizePNG($this->data['attachment'][$key]['filepath'],  $template['width'], $template['height']);
			}
			
			if(!$this->string->isImage($this->data['attachment'][$key]['extension']))
				$this->data['attachment'][$key]['imagethumbnail'] = DIR_IMAGE."icon/dinhkem.png";
			
		}
		//Get sub infomation
		
		$this->data['child'] = $this->model_core_media->getListByParent($mediaid,"Order by position");
		foreach($this->data['child'] as $key => $item)
		{
			$this->data['child'][$key]['imagepreview'] = "<img width=100 src='".HelperImage::resizePNG($item['imagepath'], $template['width'], $template['height'])."' >";
		}
		
		//Get list
		$queryoptions = array();
		$queryoptions['mediaparent'] = '%';
		$queryoptions['mediatype'] = '%';
		$queryoptions['refersitemap'] = $sitemapid;
		//$queryoptions['date'] = $this->data['post']['statusdate'];
		$this->data['othernews'] = $this->model_core_media->getOthersMedia($mediaid, $queryoptions, $count);
		for($i=0;$i<count($this->data['othernews']);$i++)
		{
			/*$this->data['othernews'][$i]['statusdate'] = $this->date->formatMySQLDate($this->data['othernews'][$i]['statusdate'], 'longdate', "/");
			
			$this->data['othernews'][$i]['link'] = HTTP_SERVER."site/".$siteid."/".$sitemapid."/".$this->data['othernews'][$i]['mediaid'];*/
			$media = $this->data['othernews'][$i];
			$link = HTTP_SERVER."site/".$siteid."/".$sitemapid."/".$media['mediaid'];
				
			$imagethumbnail = "";
			
			if($media['imagepath'] != "" )
			{
				$imagethumbnail = HelperImage::resizePNG($media['imagepath'],170, 170);
			}
			
			
			$this->data['medias'][] = array(
				'mediaid' => $media['mediaid'],
				'title' => $media['title'],
				'summary' => $media['summary'],
				'price' => $media['price'],
				'imagethumbnail' => $imagethumbnail,
				'fileid' => $media['imageid'],
				'statusdate' => $this->date->formatMySQLDate($media['statusdate'], 'longdate', "/"),
				'link' => $link
			);
		}
		
		
		$this->id="news";
		$this->template=$template['template'];
		$this->render();
	}
}
?>