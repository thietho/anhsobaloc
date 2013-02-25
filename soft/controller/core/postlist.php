<?php
class ControllerCorePostlist extends Controller
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
		$this->load->helper('image');
		
		if (!$this->user->isLogged()) {
			$this->redirect($this->url->https('page/index'));
		}
		
		$this->getList();
		
		$this->id='postlist';
		$this->template='core/post_list.tpl';	
		$this->render();
	}
	
	public function remove()
	{
		$this->load->model("core/media");
		$sitemapid = $this->request->get['sitemapid'];

		if($this->request->post['delete'])
		{
			foreach($this->request->post['delete'] as $mediaid)
			{
				$this->model_core_media->removeSitemap($mediaid, $sitemapid);
			}
		}
		
		$this->id='postlist';
		$this->template='common/output.tpl';	
		$this->render();
	}
	
	private function getList()
	{
		$route = $this->getRoute();
		$sitemapid = $this->request->get['sitemapid'];
		$mediaid = $this->request->get['mediaid'];
		$siteid = $this->user->getSiteId();
		$step = (int)$this->request->get['step'];
		$to = 9;
		
		$this->load->language($route);
		$this->data = array_merge($this->data, $this->language->getData());
		
		$sitemap = $this->model_core_sitemap->getItem($sitemapid, $siteid);
		
		//Thiet ke form
		$this->data['heading_title'] = $sitemap['sitemapname'];
		$this->data['DIR_ADD'] = HTTP_SERVER."?route=".$route."/insert&sitemapid=".$sitemapid;
		$this->data['DIR_DELETE'] = HTTP_SERVER."?route=core/postlist/remove&sitemapid=".$sitemapid;
		
		//Lay Breadcrumb
		//$this->data['breadcrumb'] = $this->model_core_sitemap->getBreadcrumb($sitemapid, $siteid);
		$this->data['breadcrumb'] = $this->model_core_sitemap->getBreadcrumb($sitemapid, $siteid, -1);
		//Get list
		$queryoptions = array();
		$queryoptions['mediaparent'] = '%';
		$queryoptions['mediatype'] = '%';
		$queryoptions['refersitemap'] = $sitemapid;
		
		$medias = $this->model_core_media->getPaginationList($queryoptions, $step, $to);
		
		$this->data['medias'] = array();
		
		$index = -1;
		foreach($medias as $media)
		{
			$index += 1;
			
			$imagepreview = "";
			if($media['imagepath'] != "")
			{
				$imagepreview = "<img width=100 src='".HelperImage::resizePNG($media['imagepath'], 180, 180)."' >";
			}
			
			$link = "<a class='button' href='".HTTP_SERVER."?route=".$route."&sitemapid=".$sitemapid."&mediaid=".$media['mediaid']."'>".$this->data['button_edit']."</a>";
			
			$firstcolumn = '<input type="checkbox" value="'.$media['mediaid'].'" name="delete['.$media['mediaid'].']" class="inputchk">';
			
			$this->data['medias'][] = array(
				'mediaid' => $media['mediaid'],
				'firstcolumn' => $firstcolumn,
				'title' => $media['title'],
				'summary' => $media['summary'],
				'imagepreview' => $imagepreview,
				'statusdate' => $this->date->formatMySQLDate($media['statusdate'], 'longdate'),
				'link' => $link
			);
			
		}
		
		$querystring = "?route=".$route."&sitemapid=".$sitemapid;
		
		$pagelinks = $this->model_core_media->getPaginationLinks($index, $queryoptions, $querystring, $step, $to);
		
		$this->data['nextlink'] = $pagelinks['nextlink'];
		$this->data['prevlink'] = $pagelinks['prevlink'];
		
		
	}
	
	
	
}
?>