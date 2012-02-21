<?php
class ControllerSitebarQuestion extends Controller
{
	public function index()
	{
		$this->load->model("core/media");
		$this->load->model("core/sitemap");
		$this->load->helper('image');
		
		$sitemapid = "thamdoykien";
		$siteid = $this->member->getSiteId();
		$this->data['sitemap'] = $this->model_core_sitemap->getItem($sitemapid, $siteid);
		
		$step = 0;
		$to = 1;
		
		//Get list
		$queryoptions = array();
		$queryoptions['mediaparent'] = '%';
		$queryoptions['mediatype'] = '%';
		$queryoptions['refersitemap'] = $sitemapid;
		$medias = $this->model_core_media->getPaginationList($queryoptions, $step, $to);
		$index = -1;
		foreach($medias as $media)
		{
			$index += 1;
			
			$link = $this->document->createLink($sitemapid,$media['mediaid']);
			
			$imagethumbnail = "";
			if($media['imagepath'] != ""  )
			{
				$imagethumbnail = HelperImage::resizePNG($media['imagepath'], 228,228);
			}
			//Get sub infomation
		
			$child = $this->model_core_media->getListByParent($media['mediaid'],"Order by position");
			foreach($child as $key => $item)
			{
				$child[$key]['imagepreview'] = "<img width=100 src='".HelperImage::resizePNG($item['imagepath'], 180, 180)."' >";
				
			}
			
			$this->data['medias'][] = array(
				'mediaid' => $media['mediaid'],
				'title' => $media['title'],
				'summary' => $media['summary'],
				'imagethumbnail' => $imagethumbnail,
				'statusdate' => $this->date->formatMySQLDate($media['statusdate'], 'longdate', "/"),
				'answers' => $child,
				'link' => $link
			);
			
		}
		$this->id="content";
		$this->template="sitebar/question.tpl";
		$this->render();
	}
	
	public function answer()
	{
		$data = $this->request->post;
		
		$this->load->model("core/media");
		$answer = $data['answer'];
		$mark = (int)$this->model_core_media->getInformation($answer,'mark');
		$mark++;
		$this->model_core_media->saveInformation($answer,'mark', $mark);
		$this->data['output'] = "true";
		$this->id='content';
		$this->template='common/output.tpl';
		$this->render();	
	}
	
	public function viewresult()
	{
		$this->load->model("core/media");
		$this->load->model("core/sitemap");
		$this->load->helper('image');
		$mediaid = $this->request->get['questionid'];
		
		$this->data['media'] = $this->model_core_media->getItem($mediaid);
		$child = $this->model_core_media->getListByParent($this->data['media']['mediaid'],"Order by position");
		$sum = 0;
		foreach($child as $key => $item)
		{
			$child[$key]['imagepreview'] = "<img width=100 src='".HelperImage::resizePNG($item['imagepath'], 180, 180)."' >";
			$child[$key]['mark'] = (int)$this->model_core_media->getInformation($item['mediaid'],'mark');
			$sum += $child[$key]['mark'];
		}
		
		$this->data['media']['answers'] = $child;
		$this->data['media']['total'] = $sum;
		
		$this->id="content";
		$this->template="sitebar/question_result.tpl";
		$this->render();
	}
}
?>