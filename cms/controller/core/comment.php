<?php
class ControllerCoreComment extends Controller
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
	 	$this->load->model("core/comment");	
		$this->load->model("core/media");
		$this->data['ispopup'] = $this->request->get['popup'];
   	}
	
	public function index()
	{
		$this->document->title = $this->language->get('heading_title');	
		$this->getList();
	}
	
	public function getList()
	{
		
		$where = "";
		$status = $this->request->get['status'];
		$mediaid = $this->request->get['mediaid'];
		if($status)
			$where = " AND status = '".$status."'";
		if($mediaid)
			$where = " AND mediaid = '".$mediaid."'";			
				
		$where.=" ORDER BY `commentdate` DESC";
		
		$this->data['datas'] = array();	
		$this->data['datas'] = $this->model_core_comment->getList($where);
	
		$this->id='content';
		$this->template='core/comment_list.tpl';
		if($this->data['ispopup'] == "")
			$this->layout="layout/center";
		$this->render();
	}
	
	public function kiemduyet()
	{
		$data = $this->request->post;
		$this->model_core_comment->updateCol($data['id'],'status',$data['status']);
		
		$this->data['output'] = "true";
		$this->id='content';
		$this->template="common/output.tpl";
		$this->render();
	}
	
	public function delete() 
	{
		$listid=$this->request->post['delete'];
		
		$this->load->model("core/comment");
		if(count($listid))
		{
			foreach($listid as $id)
			{
				$this->model_core_comment->delete($id);
			}
			$this->data['output'] = "Xóa thành công";
		}
		$this->id="content";
		$this->template="common/output.tpl";
		$this->render();
  	}
}
?>