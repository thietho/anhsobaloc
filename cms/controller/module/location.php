<?php
class ControllerModuleLocation extends Controller
{
	private $error = array();
	
	public function index()
	{
		$sitemapid = $this->request->get['sitemapid'];
		if(!$this->user->hasPermission($sitemapid, "access"))
		{
			$this->response->redirect("?route=common/permission");
		}
		$this->data['permissionAdd'] = true;
		$this->data['permissionEdit'] = true;
		$this->data['permissionDelete'] = true;
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
		//$this->load->language('quanlykho/khachhang');
		//$this->data = array_merge($this->data, $this->language->getData());
		$this->getForm();
		$this->id='content';
		$this->template="module/location_form.tpl";
		$this->layout="layout/center";
		$this->render();
	}
	
	private function getForm()
	{
		$sitemapid = $this->request->get['sitemapid'];
		$this->load->model("core/media");
		$this->load->model("core/sitemap");
		$this->data['sitemap'] = $this->model_core_sitemap->getItem($sitemapid,$this->user->getSiteId());
		$mediaid = $this->user->getSiteId().$sitemapid;
		$mediatype = "location";
		
		$this->model_core_media->initialization($mediaid,$mediatype);
		$this->data['item'] = $this->model_core_media->getItem($mediaid);
		
		$this->data['location']['zoom'] = $this->model_core_media->getInformation($mediaid, 'zoom');
		if($this->data['location']['zoom']=="")
			$this->data['location']['zoom'] = 5;
		$this->data['location']['x'] = $this->model_core_media->getInformation($mediaid, 'x');
			if($this->data['location']['x']=="")
		$this->data['location']['x']=14.058324;
		$this->data['location']['y'] = $this->model_core_media->getInformation($mediaid, 'y');
		if($this->data['location']['y']=="")
			$this->data['location']['y']=108.277199;
	}
	
	public function save()
	{
		$data = $this->request->post;
		
		if($this->validateForm($data))
		{
			$this->load->model("core/media");
			$item = $this->model_core_media->getItem($data['mediaid']);
			
			$this->model_core_media->update($data);
			
			//Save location
			$this->model_core_media->saveInformation($data['mediaid'],"x",$data['x']);
			$this->model_core_media->saveInformation($data['mediaid'],"y",$data['y']);
			$this->model_core_media->saveInformation($data['mediaid'],"zoom",$data['zoom']);
			
			
			$this->data['output'] = "true";
		}
		else
		{
			foreach($this->error as $item)
			{
				$this->data['output'] .= $item."<br>";
			}
		}
		$this->id='content';
		$this->template='common/output.tpl';
		$this->render();
	}
	
	private function validateForm($data)
	{
    	
		if($data['title'] == "")
		{
      		$this->error['title'] = "Bạn chưa nhập tiêu dề";
    	}
		
		
		
		if (count($this->error)==0) 
		{
	  		return TRUE;
		} else {
	  		return FALSE;
		}
	}
}

?>