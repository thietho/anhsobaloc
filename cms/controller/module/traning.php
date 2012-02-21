<?php
class ControllerModuleTraning extends Controller
{
	private $error = array();
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
		
	 	$this->load->model("core/user");
		$this->load->model("core/media");
		$this->load->model("core/sitemap");
		$this->load->model("core/file");
		$this->load->model("core/category");
		$this->load->helper('image');
   	}
	public function index()
	{
		
		
		$this->document->title = $this->language->get('heading_title');
		
		
		$this->getList();
	}
	
	public function insert()
	{
		$sitemapid = $this->request->get['sitemapid'];
		if(!$this->user->hasPermission($sitemapid, "add"))
		{
			$this->response->redirect("?route=common/permission");
		}
		
    	$this->getForm();
	}
	
	public function update()
	{
		$sitemapid = $this->request->get['sitemapid'];
		if(!$this->user->hasPermission($sitemapid, "edit"))
		{
			$this->response->redirect("?route=common/permission");
		}
		else
		{
			//$this->load->language('quanlykho/khachhang');
			//$this->data = array_merge($this->data, $this->language->getData());
			
			
			$this->data['haspass'] = false;
			$this->data['readonly'] = 'readonly="readonly"';
			
			$this->getForm();
		}
		
  	}
	
	public function delete() 
	{
		$listid=$this->request->post['delete'];
		//$listmadonvi=$_POST['delete'];
		$this->load->model("core/media");
		if(count($listid))
		{
			foreach($listid as $item)
				$this->model_core_media->delete($item);
				
			$this->data['output'] = "Xóa thành công";
		}
		$this->id="content";
		$this->template="common/output.tpl";
		$this->render();
  	}
	
	private function getList() 
	{
		$route = $sitemapid;
		$sitemapid = $this->request->get['sitemapid'];
		$mediaid = $this->request->get['mediaid'];
		$siteid = $this->user->getSiteId();
		$step = (int)$this->request->get['step'];
		$to = 9;
		$this->data['insert'] = $this->url->http('module/traning/insert&sitemapid='.$sitemapid);
		$this->data['delete'] = $this->url->http('module/traning/delete');		
		
		$this->data['datas'] = array();
		$where = " AND refersitemap like '%".$sitemapid."%'";
		
		/*$datasearchlike['makhachhang'] = $this->request->get['makhachhang'];
		$datasearchlike['hoten'] = $this->request->get['hoten'];
		$datasearchlike['khuvuc'] = $this->request->get['khuvuc'];
		$datasearch['loaikhachhang'] = $this->request->get['loaikhachhang'];
		
		$arr = array();
		foreach($datasearchlike as $key => $item)
		{
			if($item !="")
				$arr[] = " AND " . $key ." like '%".$item."%'";
		}
		
		foreach($datasearch as $key => $item)
		{
			if($item !="")
				$arr[] = " AND " . $key ." = '".$item."'";
		}
		
		$where = implode("",$arr);*/
		
		$rows = $this->model_core_media->getList($where);
		//Page
		$page = $this->request->get['page'];		
		$x=$page;		
		$limit = 20;
		$total = count($rows); 
		// work out the pager values 
		$this->data['pager']  = $this->pager->pageLayout($total, $limit, $page); 
		
		$pager  = $this->pager->getPagerData($total, $limit, $page); 
		$offset = $pager->offset; 
		$limit  = $pager->limit; 
		$page   = $pager->page;
		for($i=$offset;$i < $offset + $limit && count($rows[$i])>0;$i++)
		{
			$this->data['datas'][$i] = $rows[$i];
			
			$this->data['datas'][$i]['imagethumbnail'] = HelperImage::resizePNG($this->data['datas'][$i]['imagepath'], 100, 100);
			$this->data['datas'][$i]['link_edit'] = $this->url->http('module/traning/update&sitemapid='.$sitemapid.'&id='.$this->data['datas'][$i]['mediaid']);
			$this->data['datas'][$i]['text_edit'] = "Sửa";
			$this->data['datas'][$i]['startdate'] = $this->model_core_media->getInformation($this->data['datas'][$i]['mediaid'],"startdate");
			$this->data['datas'][$i]['enddate'] = $this->model_core_media->getInformation($this->data['datas'][$i]['mediaid'],"enddate");
			
		}
		$this->data['refres']=$_SERVER['QUERY_STRING'];
		$this->id='content';
		$this->template="module/traning_list.tpl";
		$this->layout="layout/center";
		if($this->request->get['opendialog']=='true')
		{
			$this->layout="layout/dialog";
			$this->data['dialog'] = true;
			//$this->data['list'] = $this->url->http('quanlykho/nhacungung&opendialog=true');
		}
		$this->render();
	}
	
	private function getForm()
	{
		$this->data['DIR_UPLOADPHOTO'] = HTTP_SERVER."index.php?route=common/uploadpreview";
		$this->data['DIR_UPLOADATTACHMENT'] = HTTP_SERVER."index.php?route=common/uploadattachment";
		$sitemapid = $this->request->get['sitemapid'];
		$this->load->model("core/media");
		$this->load->model("core/sitemap");
		$this->data['sitemap'] = $this->model_core_sitemap->getItem($sitemapid,$this->user->getSiteId());
		if ((isset($this->request->get['id'])) ) 
		{
      		$this->data['item'] = $this->model_core_media->getItem($this->request->get['id']);
			$this->data['item']['startdate'] = $this->model_core_media->getInformation($this->request->get['id'],"startdate");
			$this->data['item']['enddate'] = $this->model_core_media->getInformation($this->request->get['id'],"enddate");
			$this->data['item']['imagethumbnail'] = HelperImage::resizePNG($this->data['item']['imagepath'], 200, 200);
    	}
		else
		{
			$this->data['item']['refersitemap'] = "[".$sitemapid."]";
			if($mediaid == "")
			{
				$this->data['item']['mediaid'] = $this->model_core_media->insert($data);
			}
		}
		
		$this->id='content';
		$this->template='module/traning_form.tpl';
		$this->layout="layout/center";
		
		$this->render();
	}
	
	public function save()
	{
		$data = $this->request->post;
		
		if($this->validateForm($data))
		{
			$this->load->model("core/media");
			$item = $this->model_core_media->getItem($data['mediaid']);
			
			if(count($item)==0)
			{
				$data['mediaid']=$this->model_core_media->insert($data);
			}
			else
			{
				$this->model_core_media->update($data);
			}
			//Save startdate
			$data['startdate'] = $this->date->formatViewDate($data['startdate']);
			$this->model_core_media->saveInformation($data['mediaid'],"startdate",$data['startdate']);
			//Save enddate
			$data['enddate'] = $this->date->formatViewDate($data['enddate']);
			$this->model_core_media->saveInformation($data['mediaid'],"enddate",$data['enddate']);
			
			
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