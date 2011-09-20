<?php
class ControllerCorePostcontent extends Controller
{
	function __construct() 
	{
		$this->data['permissionAccess'] = true;
		$this->data['permissionAdd'] = true;
		$this->data['permissionEdit'] = true;
		$this->data['permissionDelete'] = true;
		
		$sitemapid = $this->request->get['sitemapid'];
		
		if(!$this->user->hasPermission($sitemapid, "access"))
		{
			$this->data['permissionAccess'] = false;
		}
		if(!$this->user->hasPermission($sitemapid, "add"))
		{
			$this->data['permissionAdd'] = false;
		}
		if(!$this->user->hasPermission($sitemapid, "edit"))
		{
			$this->data['permissionEdit'] = false;
		}
		if(!$this->user->hasPermission($sitemapid, "delete"))
		{
			$this->data['permissionDelete'] = false;
		}
	 	
   	}
	
	function index()
	{	
		if(!$this->data['permissionAccess'])
			$this->response->redirect("?route=common/permission");
		
		$this->load->model("core/user");
		$this->load->model("core/media");
		$this->load->model("core/sitemap");
		$this->load->model("core/file");
		$this->load->helper('image');
		
		if (!$this->user->isLogged()) {
			$this->redirect($this->url->https('page/index'));
		}
		
		$this->getForm();
		
		$this->id='post';
		$this->template='core/post_form.tpl';	
		$this->render();
	}
	
	private function getForm()
	{
		$mediaid = $this->request->get['mediaid'];
		if($mediaid)
		{
			if(!$this->data['permissionEdit'])
				$this->response->redirect("?route=common/permission");
		}
		else
		{
			if(!$this->data['permissionAdd'])
				$this->response->redirect("?route=common/permission");
		}
		$route = $this->getRoute();
		$sitemapid = $this->request->get['sitemapid'];
		
		$siteid = $this->user->getSiteId();

		$this->load->language($route);
		
		$this->data = array_merge($this->data, $this->language->getData());
		
		$sitemap = $this->model_core_sitemap->getItem($sitemapid, $siteid);		
		$this->data['post'] =array();
		//Save
		if (($this->request->post) && ($this->validate())) {
			
			$this->savepost();
			$this->redirect("index.php?route=".$route."&sitemapid=".$sitemapid);
		}
		else
		{
			$this->data['post']['mediatype'] = "content";
			if($route == "module/information")
			{
				
				//$this->data['post'] = $this->model_core_media->getInformationMedia($sitemapid, "content");
				$this->data['post']['mediaid'] = $this->user->getSiteId().$sitemapid;
				$this->data['post']['mediatype'] = "information";
				
				$this->data['post']=$this->model_core_media->initialization($this->data['post']['mediaid'],$this->data['post']['mediatype']);
				$this->data['post'] = $this->model_core_media->getItem($this->data['post']['mediaid']);
				
				if($this->data['post']['title'] == '' && $route='module/information')
				{
					$this->data['post']['mediaid'] = $this->user->getSiteId().$sitemapid;
					$this->data['post']['title'] = $sitemap['sitemapname'];
				}
			}
			elseif($route == "module/contact")
			{
				//$this->data['post'] = $this->model_core_media->getInformationMedia($sitemapid, "content");
				$this->data['post']['mediaid'] = $this->user->getSiteId().$sitemapid;
				$this->data['post']['mediatype'] = "contact";
				$this->data['post'] = $this->model_core_media->initialization($this->data['post']['mediaid'],$this->data['post']['mediatype']);
				$this->data['post'] = $this->model_core_media->getItem($this->data['post']['mediaid']);
				if($this->data['post']['title'] == '' && $route='module/contact')
				{
					$this->data['post']['mediaid'] = $this->user->getSiteId().$sitemapid;
					$this->data['post']['title'] = $sitemap['sitemapname'];
				}
				
				$this->data['post']['email1'] = $this->model_core_media->getInformation($this->data['post']['mediaid'], "email1");
				$this->data['post']['email2'] = $this->model_core_media->getInformation($this->data['post']['mediaid'], "email2");
				$this->data['post']['email3'] = $this->model_core_media->getInformation($this->data['post']['mediaid'], "email3");
			}
			else
			{
				$this->data['post'] = $this->model_core_media->getItem($mediaid);
				if($mediaid == "")
				{
					$this->data['post']['mediaid'] = $this->model_core_media->insert($data);
				}
			}
		}
		
		
		//Thiet ke form	
		$this->data['displaynews'] = "";
		//$this->data['heading_title'] = "Post News Page";
		$this->data['DIR_UPLOADPHOTO'] = HTTP_SERVER."index.php?route=common/uploadpreview";
		$this->data['DIR_UPLOADATTACHMENT'] = HTTP_SERVER."index.php?route=common/uploadattachment";
		$this->data['hasTitle'] = true;
		$this->data['hasSummary'] = true;
		$this->data['hasSource'] = true;
		$this->data['hasFile'] = true;
		$this->data['hasEmail'] = false;
		$this->data['hasTabMap'] = true;
		//Define product
		$this->data['hasPrice'] = false;
		$this->data['hasSubInfor'] = true;
		//Video
		$this->data['hasVideo'] = false;
		$this->data['DIR_CANCEL'] = HTTP_SERVER."index.php?route=".$route."&sitemapid=".$sitemapid;
		
		if($route == "module/download")
		{
			$this->data['hasSource'] = false;
		}
		
		if($route == "module/product")
		{
			$this->data['hasPrice'] = true;
			$this->data['hasSubInfor'] = true;
			$this->data['hasSource'] = false;
		}
		if($route == "module/video")
		{
			$this->data['hasVideo'] = true;
		}
		if($route == "module/banner")
		{
			$this->data['hasSource'] = false;
		}
		
		/*if($mediaid == "")
		{
			$this->data['hasSubInfor'] = false;
		}*/
		if($route == "module/information")
		{
			
			//$this->data['displaynews'] = "display:none";
			$this->data['heading_title'] = $sitemap['sitemapname'];
			$this->data['hasTabMap'] = false;
			$this->data['hasTitle'] = true;
			$this->data['hasSummary'] = true;
			$this->data['hasFile'] = true;
			$this->data['hasSource'] = false;
			$this->data['hasSubInfor'] = true;
			//$this->data['post']['title'] = $sitemap['sitemapname'];
			$this->data['DIR_CANCEL'] = HTTP_SERVER."index.php";
		}
		elseif($route == "module/contact")
		{
			$this->data['heading_title'] = $sitemap['sitemapname'];
			$this->data['hasTabMap'] = false;
			$this->data['hasTitle'] = true;
			$this->data['hasSummary'] = false;
			$this->data['hasFile'] = false;
			$this->data['hasSource'] = false;
			//$this->data['post']['title'] = $sitemap['sitemapname'];
			$this->data['DIR_CANCEL'] = HTTP_SERVER."index.php";
			$this->data['hasEmail'] = true;
		}
		
		
	
		
		
		//Lay Breadcrumb
		$this->data['breadcrumb'] = $this->model_core_sitemap->getBreadcrumb($sitemapid, $siteid, -1);
		
		
		//get Form
		if($this->data['post']['imagepath'] != "")
		{
			$this->data['imagethumbnail'] = HelperImage::resizePNG($this->data['post']['imagepath'], 200, 200);
		}
		
		$this->data['mediaid'] = $this->data['post']['mediaid'];
		$this->data['mediatype'] = $this->data['post']['mediatype'];
		$this->data['title'] = $this->data['post']['title'];
		$this->data['summary'] = $this->data['post']['summary'];
		$this->data['price'] = $this->data['post']['price'];
		$this->data['description'] = $this->data['post']['description'];
		$this->data['author'] = $this->data['post']['author'];
		$this->data['source'] = $this->data['post']['source'];
		$this->data['refersitemap'] = $this->data['post']['refersitemap'];
		$this->data['imageid'] = $this->data['post']['imageid'];
		$this->data['imagepath'] = $this->data['post']['imagepath'];
		$this->data['fileid'] = $this->data['post']['fileid'];
		$this->data['filepath'] = $this->data['post']['filepath'];
		$this->data['groupkeys'] = $this->data['post']['groupkeys'];
		$this->data['viewcount'] = $this->data['post']['viewcount'];
		$this->data['position'] = $this->data['post']['position'];
		$this->data['status'] = $this->data['post']['status'];
		$this->data['statusdate'] = $this->data['post']['statusdate'];
		$this->data['statusby'] = $this->data['post']['statusby'];
		$this->data['updateddate'] = $this->data['post']['updateddate'];
		$listfile = $this->model_core_media->getInformation($this->data['mediaid'], "attachment");
		$listfileid=array();
		if($listfile)
			$listfileid=split(",",$listfile);
		$this->data['attachment']=array();
		foreach($listfileid as $key => $item)
		{
			$this->data['attachment'][$key] = $this->model_core_file->getFile($item);
			$this->data['attachment'][$key]['imagethumbnail'] = HelperImage::resizePNG($this->data['attachment'][$key]['filepath'], 50, 50);
			if(!$this->string->isImage($this->data['attachment'][$key]['extension']))
				$this->data['attachment'][$key]['imagethumbnail'] = DIR_IMAGE."icon/dinhkem.png";
		}
		$this->data['status'] = $this->data['post']['status'];
		if($this->data['status'] == "")
		{
			$this->data['status'] = "Active";
		}
		
		if($this->data['post']['refersitemap'] == "")
		{
			$this->data['post']['refersitemap'] .= "[".$sitemapid."]";
		}
		
		$this->data['listReferSiteMap'] = $this->getListSiteMapCheckBox($this->data['post']);
		
		if($route=="module/contact")
		{
			$this->data['email1'] = $this->data['post']['email1'];
			$this->data['email2'] = $this->data['post']['email2'];
			$this->data['email3'] = $this->data['post']['email3'];
		}
	}
	
	private function validate()
	{
		return true;
	}
	
	public function savepost()
	{
		$this->load->model("core/media");
		$this->load->model("core/sitemap");
		$route = $this->getRoute();
		$this->data['post'] = $this->request->post;
		$sitemapid = $this->request->get['sitemapid'];
		$mediaid = $this->request->get['mediaid'];
		$siteid = $this->user->getSiteId();
			
		$sitemapid = $this->request->get['sitemapid'];
		
		
		$data['mediaid'] = $this->data['post']['mediaid'];
		$data['mediatype'] = $this->data['post']['mediatype'];
		
		$data['userid'] = $this->user->getId();
		
		$data['title'] = $this->data['post']['title'];
		$data['summary'] = $this->data['post']['summary'];
		$data['price'] = str_replace(",","",$this->data['post']['price']);
		$data['mediaparent'] = $this->data['post']['mediaparent'];
		$data['description'] = $this->data['post']['description'];
		$data['author'] = $this->data['post']['author'];
		$data['source'] = $this->data['post']['source'];
		
		$data['status'] = $this->data['post']['status'];	
		$data['imageid'] = $this->data['post']['imageid'];
		$data['imagepath'] = $this->data['post']['imagepath'];
		$data['fileid'] = $this->data['post']['fileid'];
		$data['filepath'] = $this->data['post']['filepath'];
		$data['refersitemap'] = $this->data['post']['refersitemap'];
		//$data['refersitemap'] = $this->model_core_media->getReferSitemapString($sitemapid,$data['refersitemap']);
		
		$list = $this->model_core_sitemap->getListByModule("module/news",$this->user->getSiteId());
		
		
		/*foreach($list as $item)
		{
			$data['refersitemap'] =  $this->model_core_media->getReferSitemapString($item['sitemapid'], $data['refersitemap'], "delete");
		}*/
		
		$data['refersitemap'] = "";
		if($this->request->post['listrefersitemap'])
		{
			foreach ($this->request->post['listrefersitemap'] as $refersiteid) {
				$data['refersitemap'] .= "[".$refersiteid."]";
			}
		}
		
		//$data['refersitemap'] = $this->model_core_media->getReferSitemapString($sitemapid, $data['refersitemap']);
		if($data['mediaid'] == "")
		{
			$data['mediaid'] = $this->model_core_media->insert($data);
			if($data['mediaparent'])
				$this->model_core_media->updateStatus($data['mediaid'],"active");
		}
		else
		{
			if($this->model_core_media->update($data) == false)
			{
				exit("There are some problems, please contact administrator!");
			}
		}
		
		$listAttachment=$this->data['post']['attimageid'];
		$this->model_core_media->saveAttachment($data['mediaid'],$listAttachment);
		$listdelfile=$this->data['post']['delfile'];
		if(count($listdelfile))
			foreach($listdelfile as $item)
				$this->model_core_file->deleteFile($item);
		$this->model_core_media->clearTempFile();
		if($route=="module/contact")
		{
			$this->model_core_media->saveInformation($data['mediaid'], "email1", $this->data['post']['email1']);
			$this->model_core_media->saveInformation($data['mediaid'], "email2", $this->data['post']['email2']);
			$this->model_core_media->saveInformation($data['mediaid'], "email3", $this->data['post']['email3']);
		}
		
		$this->data['output'] = "true";
		$this->template="common/output.tpl";
		$this->render();
		//if($route == "module/news")
		//{
		
		//}
		//else
		//{
			//$this->redirect("index.php");
		//}
		
	}
	
	public function updatePos()
	{
		$this->load->model("core/media");
		$data = $this->request->post;
		$this->model_core_media->updatePos($data);
		$this->data['output'] = "true";
		$this->template="common/output.tpl";
		$this->render();
	}
	
	private function getListSiteMapCheckBox($media)
	{
		$strReferSitemap = $media['refersitemap'];
		$route = $this->getRoute();
		$list = $this->model_core_sitemap->getListByModule($route,$this->user->getSiteId());
		$html = "";
		foreach($list as $item)
		{
			$html .= '<tr>';
			$html .= '<td>';
			
			$sitemapid = "[".$item['sitemapid']."]";
			
			$pos = strrpos($strReferSitemap, $sitemapid);
			if ($pos === false) {
				$checked = "";
			}else{
				$checked = "checked=checked";
			}
			$html .= '<label><input name="listrefersitemap['.$item['sitemapid'].']" type="checkbox" value="'.$item['sitemapid'].'" '.$checked.'/> '.$item['sitemapname'].'</label>';
			$path = $this->model_core_sitemap->getBreadcrumb($item['sitemapid'], $this->user->getSiteId());
			$path = strip_tags($path);
			$html .= '</td><td>'.$path.'</td> </tr>';
		}
		
		return $html;
	}
	
	public function loadSubInfor()
	{
		$this->load->model("core/media");
		$this->load->helper('image');
		$mediaid = $this->request->get['mediaid'];
		$this->data['child']=$this->model_core_media->getListByParent($mediaid,"Order by position");
		
		//$this->data['subImage'] = $this->string->array_Filter($this->data['child'],"mediatype","image");
		
		foreach($this->data['child'] as $key => $item)
		{
			$this->data['child'][$key]['imagepreview'] = "<img width=100 src='".HelperImage::resizePNG($item['imagepath'], 180, 180)."' >";
		} 
		$this->id='post';
		$this->template='core/subinfor_list.tpl';	
		$this->render();
	}
	
	public function getSubInfor()
	{
		$this->load->model("core/media");
		$this->load->helper('image');
		$mediaid = $this->request->get['mediaid'];
		$subImage=$this->model_core_media->getItem($mediaid);
		$subImage['description'] = html_entity_decode($subImage['description']);
		$subImage['imagepreview'] = HelperImage::resizePNG($subImage['imagepath'], 180, 180);
		$this->data['output'] = json_encode(array('subinfor' => $subImage));
		$this->id='post';
		$this->template="common/output.tpl";
		$this->render();
	}
	
	public function removeSubImage()
	{
		$this->load->model("core/media");
		$this->load->helper('image');
		$mediaid = $this->request->get['mediaid'];
		$this->model_core_media->delete($mediaid);
		$this->id='post';
		$this->template="common/output.tpl";
		$this->render();
	}
}
?>