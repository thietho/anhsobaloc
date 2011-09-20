<?php
class ControllerCoreSite extends Controller
{
	private $error = array();
	
	public function index()
	{
		$this->load->language('core/site');
		$this->data = array_merge($this->data, $this->language->getData());
		
		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model("core/site");
		$this->getList();
	}
	
	public function insert()
	{
		$this->load->language('core/site');
		$this->data = array_merge($this->data, $this->language->getData());
		
		$this->document->title = $this->language->get('heading_title');
		$this->load->model("core/site");
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validateForm())) {
			$this->model_core_site->insertSite($this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->redirect($this->url->http('core/site'));
		}
    
    	$this->getForm();
	}
	
	public function update() {
		$this->load->language('core/site');
		$this->data = array_merge($this->data, $this->language->getData());
		
		$this->document->title = $this->language->get('heading_title');
		$this->load->model("core/site");
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validateForm())) {
			$this->request->post['siteid'] = $this->request->get['siteid'];
			$this->model_core_site->updateSite($this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->redirect($this->url->http('core/site'));
		}
    
    	$this->getForm();
  	}
	
	public function delete() {
		//$this->load->language('core/site');
		//$this->data = array_merge($this->data, $this->language->getData());
		
		//$this->document->title = $this->language->get('heading_title');
		$this->load->model("core/site");
			
    	if (isset($this->request->post['delete'])) 
		{
			foreach ($this->request->post['delete'] as $siteid) {
				$this->model_core_site->deleteSite($siteid);
			}
			$this->data['output'] = "Xóa thành công";
    	}
	
    	//$this->getList();
		$this->id="content";
		$this->template="common/output.tpl";
		$this->render();
  	}
	
	public function copySite()
	{
		$siteid = $this->request->get['siteid'];
		$this->load->model("core/sitemap");
		$this->load->model("core/media");
		/*$medias = $this->model_core_media->getList();
		
		foreach($medias as $val)
		{
			$str = str_replace("default",$siteid, $val['mediaid']);
			$val['mediaid'] = $str;
			$this->model_core_media->save($val);
		}*/
		$sitemaps = array();
		$sitemaps=$this->model_core_sitemap->getList("default");
		
		foreach($sitemaps as $item)
		{
			
			//Copy sitemap
			
			$item['siteid'] = $siteid;
			$arr = $this->model_core_sitemap->getItem($item['sitemapid'],$item['siteid']);
			
			
			if(count($arr)==0)
				$this->model_core_sitemap->insertSiteMap($item);
			//Copy media lien quen den sitemap
			/*foreach($medias as $val)
			{
				$val['refersitemap'] = "[".$item['sitemapid']."]";
				$this->model_core_media->insert($val);
			}*/
		}
		$this->data['output'] = "true";
		$this->id="content";
		$this->template="common/output.tpl";
		$this->render();
	}
	
	private function getList() 
	{
		$this->data['insert'] = $this->url->http('core/site/insert');
		$this->data['delete'] = $this->url->http('core/site/delete');		
		$this->data['refres']=$_SERVER['QUERY_STRING'];
		$this->data['sites'] = array();
		$this->data['sites'] = $this->model_core_site->getList();
		
		for($i=0; $i <= count($this->data['sites'])-1 ; $i++)
		{
			$this->data['sites'][$i]['link_edit'] = $this->url->http('core/site/update&siteid='.$this->data['sites'][$i]['siteid']);
			$this->data['sites'][$i]['text_edit'] = "Edit";
		}
		
		$this->id='content';
		$this->template="core/site_list.tpl";
		$this->layout="layout/center";
		
		$this->render();
	}
	
	
	private function getForm()
	{
		$this->data['error'] = @$this->error;
		
		if (!isset($this->request->get['siteid'])) {
			$this->data['action'] = $this->url->http('core/site/insert');
		} else {
			$this->data['action'] = $this->url->http('core/site/update&siteid=' . $this->request->get['siteid']);
		}
		
		$this->data['cancel'] = $this->url->https('core/site');
		
		$this->data['status'] = $this->model_core_site->getStatusList();
		
		if ((isset($this->request->get['siteid'])) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$this->data['site'] = $this->model_core_site->getItem($this->request->get['siteid']);
    	}
		else
		{
			$this->data['site'] = $this->request->post;
		}
		
		$this->id='content';
		$this->template='core/site_form.tpl';
		$this->layout="layout/center";
		
		$this->render();
	}
	
	private function validateForm()
	{
    	if ((strlen($this->request->post['siteid']) == 0) || (strlen($this->request->post['siteid']) > 30)) {
      		$this->error['siteid'] = $this->language->get('error_siteid');
    	}
		
		if (strlen($this->request->post['sitename']) == 0) {
      		$this->error['sitename'] = $this->language->get('error_sitename');
    	}

		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
	}
}
?>