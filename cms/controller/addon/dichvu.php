<?php
class ControllerAddonDichvu extends Controller
{
	private $error = array();
   	function __construct() 
	{
	 	$this->load->model("addon/dichvu");
		$this->load->model("common/control");
   	}
	
	public function index()
	{
		$this->getList();
	}
	
	public function insert()
	{
    	$this->getForm();
	}
	
	public function update()
	{
		$this->data['haspass'] = false;
		$this->data['readonly'] = 'readonly="readonly"';
		$this->data['class'] = 'readonly';	
		$this->getForm();
  	}
	
	
	
	public function delete() 
	{
		$listdichvuid=$this->request->post['delete'];
		
		if(count($listdichvuid))
		{
			foreach($listdichvuid as $dichvuid)
			{
				$this->model_addon_dichvu->delete($dichvuid);	
			}
			$this->data['output'] = "true";
		}
		$this->id="content";
		$this->template="common/output.tpl";
		$this->render();
  	}
	
	private function getList() 
	{
		$this->data['insert'] = $this->url->http('addon/dichvu/insert');
		$this->data['delete'] = $this->url->http('addon/dichvu/delete');		
		
		
		
		$this->data['datas'] = array();
		$where = "";
		
		$where .= " Order by tendichvu";
		$rows = $this->model_addon_dichvu->getList($where);
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
		//for($i=0; $i <= count($this->data['datas'])-1 ; $i++)
		//for($i=0;$i < count($rows[$i]);$i++)
		{
			$this->data['datas'][$i] = $rows[$i];
			$this->data['datas'][$i]['link_edit'] = $this->url->http('addon/dichvu/update&dichvuid='.$this->data['datas'][$i]['dichvuid']);
			$this->data['datas'][$i]['text_edit'] = "Edit";
			
			
			
		}
		
		$this->id='content';
		$this->template="addon/dichvu_list.tpl";
		$this->layout=$this->user->getLayout();
		
		$this->render();
	}
	
	
	private function getForm()
	{		
		
		if ((isset($this->request->get['dichvuid'])) ) 
		{
      		$this->data['item'] = $this->model_addon_dichvu->getItem($this->request->get['dichvuid']);
			
    	}
		
		
		$this->id='content';
		$this->template='addon/dichvu_form.tpl';
		$this->layout=$this->user->getLayout();
		$this->render();
	}
	
	
	
	public function save()
	{
		$data = $this->request->post;
		
		if($this->validateForm($data))
		{
			
			if($data['dichvuid']=="")
			{
				$data['dichvuid'] = $this->model_addon_dichvu->insert($data);	
			}
			else
			{
				$this->model_addon_dichvu->update($data);	
			}
			
			
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
		
		if (trim($data['tendichvu']) == "") 
		{
      		$this->error['tendichvu'] = "Bạn chưa nhập tên dịch vụ";
    	}
		
		if (count($this->error)==0) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
	}
	
	public function getCbDichVu()
	{
		$where = " Order by tendichvu";
		$data_dichvu = $this->model_addon_dichvu->getList($where);
		$this->data['output'] ="<option value=''></option>";
		$this->data['output'] .= $this->model_common_control->getDataCombobox($data_dichvu, "tendichvu", "dichvuid");
		$this->id='content';
		$this->template='common/output.tpl';
		$this->render();
	}
	
	public function getDichVu()
	{
		$dichvuid = $this->request->get['dichvuid'];
		$dichvu = $this->model_addon_dichvu->getItem($dichvuid);
		$this->data['output'] = json_encode($dichvu);
		$this->id='content';
		$this->template='common/output.tpl';
		$this->render();
	}
}
?>