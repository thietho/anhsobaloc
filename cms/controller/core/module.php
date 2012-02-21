<?php
class ControllerCoreModule extends Controller
{
	public $cache = array();
	
	public function index()
	{
		switch($this->request->get['formtype'])
		{
			case "":
				if ( strcasecmp( @ $_SERVER['REQUEST_METHOD'], 'POST' ) == 0 )
				{
					if($this->request->post['formtype']!="" )
					{
						$arr=$this->request->post['delete'];
						$position=$this->request->post['position'];
						
						$this->load->model("core/module");
						
						foreach($position as $key=>$val)
						{
							 
							if($arr[$key]=="1")
							{
								$id=$key;
								if($this->request->post['formtype']=="Delete")
									$this->delete($id);
									
							}
							$val = (int)$val;
							if($this->request->post['formtype']=="Update")
								if($val>=0)
									$this->model_core_module->updateModulePosition($key,$val);
						}
		
					}
					$this->response->redirect('?route=core/module');
					
				}
				$this->getList(1);			
				break;
			case "add":
				$this->data['title']="Add Module";
				if(isset($this->request->post['modulename']))
				{
					$err=$this->validateForm();
					if(count($err)==0)
					{
						$this->insert();
						$this->response->redirect('?route=core/module');
					}
				}
				
				$this->getForm("",1);
				
				break;
			case "edit":
				$this->data['title']=$this->data['text_editmodule'];
				if(isset($this->request->post['moduleid']))
				{
					$this->update();
					$this->response->redirect('?route=core/module');
				}
				else
				{
					$this->getForm($this->request->get['id'],1);
				}
				break;
			case "delete":
				$this->load->model("core/module");
				$id=$this->request->get['id'];
				$this->delete($id);
				$this->response->redirect('?route=core/module');
				break;
		}
	}
	
	
	public function getList($LanguageID)
	{
		$this->load->model("core/module");
		$this->load->model("common/control");
		
		$this->user->setControl('add','btnAdd');
		$this->user->setControl('delete',array('btnDelete','controlDelete'));
		$this->user->setControl('edit',array('btnUpdate','controlEdit'));
		
		$list=$this->model_core_module->getModules();
		$arrstatus=$this->model_core_module->listStatus();
		//$this->data["modules"]=$list;
		
		$this->data['btnAdd'] = $this->model_common_control->getButton("btnAdd","btnAdd","Add new","?route=core/module&formtype=add");
		$this->data['btnDelete'] = $this->model_common_control->getSubmit("btnDelete","formtype","Delete","?route=core/module&formtype=delete");
		$this->data['btnUpdate'] = $this->model_common_control->getSubmit("btnUpdate","formtype","Update","?route=core/module&formtype=update");
		
		$this->data["modules"]=array();
		foreach($list as $resutl )
		{
			$controlEdit = $this->model_common_control->getControlEdit("controlEdit","controlEdit","[<?php echo $button_edit?>]","?route=core/module&formtype=edit&id=".$resutl['moduleid']);
			$controlDelete = $this->model_common_control->getControlDelete("controlDelete","controlDelete","[Delete]","?route=core/module&formtype=delete&id=".$resutl['moduleid']);
			
			$this->data["modules"][]=array(
										'moduleid'=>$resutl['moduleid'],
										'modulename'=>$resutl['modulename'],
										'moduleparent'=>$resutl['moduleparent'],
										'position'=>$resutl['position'],
										'status'=>$arrstatus[$resutl['status']],
										'controlEdit'=>$controlEdit,
										'controlDelete'=>$controlDelete
										);
		}
		$this->data['fromtitle']="Danh sách các module";
		$this->id='content';
		$this->template='core/module_list.tpl';
		$this->layout="layout/center";
		$this->render();
	}
	
	public function getForm($moduleid)
	{
		$this->load->model("core/module");
		if($moduleid)
		{
			$this->data['module']=$this->model_core_module->getModule($moduleid);
			$this->cache = $this->data['module'];
		}
		
		$arrPermission = $this->json->decode($this->data['module']["permission"]);
		if(!is_array($arrPermission)) $arrPermission = array();
		$this->data['module']['permission'] = implode(",",$arrPermission);
		
		$this->data['status']=$this->model_core_module->listStatus();
		$this->id='content';
		$this->template='core/module_form.tpl';
		$this->layout="layout/center";
		$this->render();
	}
	
	public function insert()
	{
		$this->load->model('core/module');
		$data['moduleid'] = $this->request->post['moduleid'];
		$data['modulename'] = $this->request->post['modulename'];
		$data['moduleparent'] = $this->request->post['moduleparent'];
		$data['position'] =  $this->model_core_module->nextPosition("");
		$data['status'] = $this->request->post['status'];
		$data['modulepath'] = $this->request->post['modulepath'];
		
		$strPermission = html_entity_decode($this->request->post['permission']);
		$strPermission = str_replace(" ","",$strPermission);
		
		while($strPermission[strlen($strPermission)-1] == ",")
		{
			$strPermission = substr_replace( $strPermission, "", -1 );
		}
		
		$arrPermission = explode(",",$strPermission);		
		
		$clean = array_unique($arrPermission);
		$arrPermission = $clean;
		
		natcasesort($arrPermission);	
		
		if(is_array($arrPermission)){
			$strPermission = $this->json->encode($arrPermission);
		}
		
		$data['permission'] = $strPermission;
		
		
		$this->model_core_module->insertModule($data);
	}
	
	public function update()
	{
		$data['moduleid'] = $this->request->post['moduleid'];
		$data['modulename'] = $this->request->post['modulename'];
		$data['moduleparent'] = $this->request->post['moduleparent'];
		$data['position'] = $this->request->post['position'];
		$data['status'] = $this->request->post['status'];
		$data['modulepath'] = $this->request->post['modulepath'];

		
		$strPermission = html_entity_decode($this->request->post['permission']);
		$strPermission = str_replace(" ","",$strPermission);
		
		while($strPermission[strlen($strPermission)-1] == ",")
		{
			$strPermission = substr_replace( $strPermission, "", -1 );
		}
		
		$arrPermission = explode(",",$strPermission);		
		
		$clean = array_unique($arrPermission);
		$arrPermission = $clean;

		natcasesort($arrPermission);	
	
		
		if(is_array($arrPermission)){
			$strPermission = $this->json->encode($arrPermission);
		}
		
		

		$data['permission'] = $strPermission;
		$this->load->model('core/module');
		
		if($this->request->get['id']){
			$this->cache=$this->model_core_module->getModule($this->request->get['id']);
		}
		
		$this->model_core_module->updateModule($data, $this->cache);
		
		//Update UserType
		$this->load->model('core/usertype');
		$UserTypes=$this->model_core_usertype->getUsertypes();
		foreach($UserTypes as $UserType)
		{
			$UserType['permission'] = str_replace($this->cache['moduleid'], $data['moduleid'], $UserType['permission']);
			$this->model_core_usertype->updateUsertype($UserType);	
		}
	}
	
	public function delete($id)
	{
		$this->load->model('core/module');
		return $this->model_core_module->deleteModule($id);
	}
	
	public function validateForm()
	{
		$err=array();
		$moduleid = $this->request->post['moduleid'];
		if($moduleid=="")
			$err['moduleid']="ModuleID khong duoc rong";
		$this->load->model('core/module');
		$arr=$this->model_core_module->getModule($moduleid);
		if(count($arr)>0)
			$err['moduleid']="Dulikey ModuleID";
		return $err;
	}
}
?>