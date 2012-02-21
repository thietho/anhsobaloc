<?php
class ControllerCoreCategory extends Controller
{
	private $error = array();
   	function __construct() 
	{
		if(!$this->user->hasPermission($this->getRoute(), "access"))
		{
			$this->response->redirect("?route=common/permission");
		}
		$this->data['permissionAdd'] = true;
		$this->data['permissionEdit'] = true;
		$this->data['permissionDelete'] = true;
		if(!$this->user->hasPermission($this->getRoute(), "add"))
		{
			$this->data['permissionAdd'] = false;
		}
		if(!$this->user->hasPermission($this->getRoute(), "edit"))
		{
			$this->data['permissionEdit'] = false;
		}
		if(!$this->user->hasPermission($this->getRoute(), "delete"))
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
		
		//$this->load->language('core/category');
		//$this->data = array_merge($this->data, $this->language->getData());
		
		$this->document->title = $this->language->get('heading_title');
		
		
		$this->getList();
	}
	
	public function insert()
	{
		if(!$this->user->hasPermission($this->getRoute(), "add"))
		{
			$this->response->redirect("?route=common/permission");
		}
		
    	$this->getForm();
	}
	
	public function update()
	{
		if(!$this->user->hasPermission($this->getRoute(), "edit"))
		{
			$this->response->redirect("?route=common/permission");
		}
		else
		{
			//$this->load->language('core/category');
			//$this->data = array_merge($this->data, $this->language->getData());
			
			
			
			$this->data['haspass'] = false;
			$this->data['readonly'] = 'readonly="readonly"';
		
		
			$this->getForm();
		}
		
  	}
	
	public function edit()
	{
		if(!$this->user->hasPermission($this->getRoute(), "edit"))
		{
			$this->response->redirect("?route=common/permission");
		}
		else
		{
			if (($this->request->post)) 
			{
			
				$this->loadModule('core/postcontent',"savepost");
				$this->redirect("index.php?route=core/category");
			}
			//$this->load->language('core/category');
			//$this->data = array_merge($this->data, $this->language->getData());
			$categoryid = $this->request->get['categoryid'];
			$category = $this->model_core_category->getItem($this->request->get['categoryid']);
			
			$this->data['DIR_UPLOADPHOTO'] = HTTP_SERVER."index.php?route=common/uploadpreview";
			$this->data['DIR_UPLOADATTACHMENT'] = HTTP_SERVER."index.php?route=common/uploadattachment";
			$this->data['post']['mediaid'] = $this->user->getSiteId()."cat".$categoryid;
			$this->data['post']['mediatype'] = "information";
			
			$this->data['post']=$this->model_core_media->initialization($this->data['post']['mediaid'],$this->data['post']['mediatype']);
			$this->data['post'] = $this->model_core_media->getItem($this->data['post']['mediaid']);
			
			if($this->data['post']['title'] == '' && $route='module/information')
			{
				$this->data['post']['mediaid'] = $this->user->getSiteId()."cat".$categoryid;
				$this->data['post']['title'] = $category['categoryname'];
			}
			if($this->data['post']['imagepath'] != "")
			{
				$this->data['post']['imagethumbnail'] = HelperImage::resizePNG($this->data['post']['imagepath'], 200, 200);
			}
			$this->id='content';
			$this->template='core/category_content.tpl';
			$this->layout="layout/center";
			$this->render();
		}
		
  	}
	
	public function delete() 
	{
		$listcategoryid=$this->request->post['delete'];
		//$listcategoryid=$_POST['delete'];
		$this->load->model("core/category");
		if(count($listcategoryid))
		{
			$this->model_core_category->deletedatas($listcategoryid);
			$this->data['output'] = "Xóa thành công";
		}
		$this->id="content";
		$this->template="common/output.tpl";
		$this->render();
  	}
	
	public function updateposition()
	{
		$listposition=$this->request->post['position'];
		//$listcategoryid=$_POST['delete'];
		$this->load->model("core/category");
		if(count($listposition))
		{
			foreach($listposition as $key => $item)
			{
				$data['categoryid'] = $key;
				$data['position'] = $item;
				$this->model_core_category->updateposition($data);		
			}
			
			$this->data['output'] = "Cập nhật thành công";
		}
		$this->id="content";
		$this->template="common/output.tpl";
		$this->render();
		
	}
	
	private function getList() 
	{
		$this->data['insert'] = $this->url->http('core/category/insert');
		$this->data['delete'] = $this->url->http('core/category/delete');		
		
		$this->data['datas'] = array();
		$rows = $this->model_core_category->getDanhMucPhanLoai();
		unset($rows[0]);
		$this->data['datas'] = array();
		
		$eid="ex0-node";
		$eclass="child-of-ex0-node";
		foreach($rows as $item)
		{
			
			$deep = $item['level'];
			$link_edit = $this->url->http('core/category/update&categoryid='.$item['categoryid']);
			$text_edit = "Edit";
			
			$link_addchild = $this->url->http('core/category/update&parent='.$item['categoryid']);
			$text_addchild = "Add child";
			
			$link_editcontent = $this->url->http('core/category/edit&categoryid='.$item['categoryid']);
			$text_editcontent = "Edit content";
			
			$tab="";
			if(count($item['countchild'])==0)
				$tab="<span class='tab'></span>";
		
			$class="";
			if($item['parentpath']!="")
				$class=$eclass.$item['parentpath'];
				
			$this->data["datas"][]=array(
										'categoryid'=>$item['categoryid'],
										'prefix'=>$this->string->getPrefix("--",$deep),
										'deep'=>$deep + 1,
										'eid' =>$eid . $item['path'] ,
										'class' =>$class,
										'categoryname'=>$item['categoryname'],
										'parent'=>$item['parent'],
										'position'=>$item['position'],
										'tab'=>$tab,
										'link_edit'=>$link_edit,
										'text_edit' =>$text_edit,
										'link_editcontent'=>$link_editcontent,
										'text_editcontent' =>$text_editcontent,
										'link_addchild' => $link_addchild,
										'text_addchild' => $text_addchild
								    );
			
			
		}
		
		$this->data['refres']=$_SERVER['QUERY_STRING'];
		$this->id='content';
		$this->template="core/category_list.tpl";
		$this->layout="layout/center";
		
		$this->render();
	}
	
	
	private function getForm()
	{
		$this->data['error'] = @$this->error;
		$this->load->model("core/category");
		
		$this->data['datas'] = array();
		$this->data['datas'] = $this->model_core_category->getDanhMucPhanLoai();
		
		if ((isset($this->request->get['categoryid'])) ) 
		{
      		$this->data['item'] = $this->model_core_category->getItem($this->request->get['categoryid']);
    	}
		
		$this->id='content';
		$this->template='core/category_form.tpl';
		$this->layout="layout/center";
		
		$this->render();
	}
	
	public function save()
	{
		$data = $this->request->post;
		if($this->validateForm($data))
		{
			$this->load->model("core/category");
			$this->model_core_category->save($data);
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
		if($data['id'] == "")
		{
			$this->load->model("core/category");
			$item = $this->model_core_category->getItem($data['categoryid']);
			if(count($item)>0)
				$this->error['categoryid'] = "Category is used";
		}
		if ((strlen($data['categoryid']) == 0)) 
		{
      		$this->error['categoryid'] = "Category Id is not null";
    	}
		if ((strlen($data['categoryname']) == 0)) 
		{
      		$this->error['categoryname'] = "Category name is not null";
    	}

		if (count($this->error)==0) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
	}
	//Cac ham xu ly tren form
	
}
?>