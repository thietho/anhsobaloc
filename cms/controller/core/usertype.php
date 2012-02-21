<?php
	class ControllerCoreUsertype extends Controller
	{
		public function index()
		{
			$this->load->model("core/usertype");
			$this->load->model("core/user");
			$this->load->model("core/module");
			$this->load->model("core/sitemap");
			$this->load->model("common/control");
			
			$user=$this->model_core_user->getItem($this->user->getId());
			//echo $user[0]['usertypeid'];
			/*if($user[0]['usertypeid']!=1)
				$this->response->redirect("index.php?route=error/permission");*/
			//echo $this->user->getId();
			if ( strcasecmp( @ $_SERVER['REQUEST_METHOD'], 'POST' ) == 0 )
			{
				if(isset($this->request->post['del_all']))
				{
					$listid=$this->request->post['del'];
					$arrChecked=array();
					foreach($listid as $id)
					{
						if($this->validateDelete($id))
						{	
							array_push($arrChecked, $id);
						}
					}
					$this->delete($arrChecked);
				}
			}
			$this->getList();
			/*switch($this->request->get['formtype'])
			{
				case "":
						if ( strcasecmp( @ $_SERVER['REQUEST_METHOD'], 'POST' ) == 0 )
						{
							if(isset($this->request->post['del_all']))
							{
								$listid=$this->request->post['del'];
								$arrChecked=array();
								foreach($listid as $id)
								{
									if($this->validateDelete($id))
									{	
										array_push($arrChecked, $id);
									}
								}
								$this->delete($arrChecked);
							}
						}
						$this->getList();
						break;
				case "add":
						if ( strcasecmp( @ $_SERVER['REQUEST_METHOD'], 'POST' ) == 0 )
						{
							if(isset($this->request->post['save']))
							{
								if($this->validateForm())
								{
									$this->insert();
									$this->response->redirect("index.php?route=core/usertype");
								}
							}
						}
						$this->getForm();
						break;
				case "edit":
						if ( strcasecmp( @ $_SERVER['REQUEST_METHOD'], 'POST' ) == 0 )
						{
							if(isset($this->request->post['save']))
							{
								
									$this->update();
									$this->response->redirect("index.php?route=core/usertype");
								
							}
						}
						//$this->updateList();
						$this->getForm();
						break;
				
				case "delete":
						if( strcasecmp( @ $_SERVER['REQUEST_METHOD'], 'GET' ) == 0 )
						{
							
								$id=$this->request->get['id'];
								$arrChecked=array();
								
									array_push($arrChecked, $id);
							
								$this->delete($arrChecked);
							
						}
						$this->response->redirect("index.php?route=core/usertype");
						$this->getList();
						break;
			}*/
			$this->id="content";
			$this->render();			
		}
		
		function edit()
		{
			$this->getForm();
			$this->id="content";
			$this->render();
		}
		
		function save()
		{
			$this->load->model("core/usertype");
			$data['usertypeid'] = $this->request->post['usertypeid'];
			$data['permission'] = $this->request->post['permission'];
			$this->model_core_usertype->updatePermission($data);
			$this->data['output'] = "true";
			$this->id="content";
			$this->template="common/output.tpl";
			$this->render();
		}
		
		function getList()
		{
			$this->user->setControl('add','btnAdd');
			$this->user->setControl('addMember','btnAddMember');
			$this->user->setControl('edit','btnEdit');
			$this->user->setControl('delete','btnDelete');
			
			$list = array();
			$this->data["usertypes"]=array();
			$this->model_core_usertype->getTreeUserType("",$list);
			
			$this->data['btnAdd'] = $this->model_common_control->getButton("btnAdd","btnAdd","Add new group","?route=core/usertype&formtype=add");
			foreach($list as $resutl )
			{
				$deep=$this->model_core_usertype->getDeep($resutl['usertypeid']);
				$parent=$this->model_core_usertype->getUserType($resutl['UserTypeParent']);
				
				if($parent[0]['usertypename'] == "")
				{
					$btnAddMember = $this->model_common_control->getControlAddMember("btnAddMember","btnAddMember","[Add more user type]","?route=core/usertype&formtype=add&id=".$resutl['usertypeid']);
				}
				else
				{
					$btnAddMember = "";
				}
				$controlEdit = $this->model_common_control->getControlEdit("controlEdit","controlEdit","[<?php echo $button_edit?>]","?route=core/usertype/edit&id=".$resutl['usertypeid']);
				$controlDelete = $this->model_common_control->getControlDelete("controlDelete","controlDelete","[Delete]","?route=core/usertype&formtype=delete&id=".$resutl['usertypeid']);
				
				
				$this->data["usertypes"][]=array(
											'usertypeid'=>$resutl['usertypeid'],
											'usertypename'=>$resutl['usertypename'],
											'Prefix'=>$this->string->getPrefix("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+&nbsp;&nbsp;&nbsp;",$deep -1),
											'Deep'=>$deep + 1,
											'UserTypeParent'=>$parent[0]['usertypename'],
											'UserTypeParentID'=>$parent[0]['usertypeid'],
											'btnAddMember' => $btnAddMember ,
											'btnEdit' => $controlEdit,
											'btnDelete' => $controlDelete
											);
			}
			
			
			
			$this->template="core/usertype_list.tpl";
			$this->layout="layout/center";	
		}
		
	
		function getForm()
		{
			$this->load->model("core/usertype");
			$this->load->model("core/user");
			$this->load->model("core/module");
			$this->load->model("core/sitemap");
			$this->load->model("common/control");
			$id = $this->request->get['id'];
			$this->data['usertype'] = $this->model_core_usertype->getUserType($id);
			$this->data['permission'] = $this->string->referSiteMapToArray($this->data['usertype']['permission']);
			
			$this->data['sitemaps'] = array();
			$this->data['listPermission'] = $this->model_core_usertype->listPermission;
			$this->model_core_sitemap->getTreeSitemap("",$this->data['sitemaps'],$this->user->getSiteId());
			$this->data['modules'] = $this->model_core_sitemap->getModuleAddons();
			
			$this->template = 'core/usertype_form.tpl';
			$this->layout="layout/center";
		}
	
		function cache()
		{
			$this->data['cache']['usertypename']=$this->request->post['usertypename'];
		}
		
		function updateList()
		{
			$usertypeid=$this->request->get['id'];
			$result=$this->model_core_usertype->getUsertype($usertypeid);
			$this->data['UserType']=array(
					'usertypeid'=>$result['usertypeid'],
					'usertypename'=>$result['usertypename']
			);
		}
		
		function validateForm()
		{	
			$usertypename = $this->request->post['usertypename'];
			//require
			if($usertypename=='')
				$this->data['require']='Bạn chưa nhập tên loại người dùng';
			//unique usertypename
			$results=$this->model_core_usertype->getAllUsertype();
			foreach($results as $result)
			{
				if($usertypename==$result['usertypename'])
				{
					$this->data['unique']='Tên loại người dùng này đã tồn tại';
					break;
				}
			}
			if($this->data['require']!=null||$this->data['unique']!=null)
				return false;
			else
				return true;
		}
		
		function validateDelete($usertypeid)
		{
			$flag=false;
			$results=$this->model_core_usertype->getUsertypeNoRelation($usertypeid);
			foreach($results as $result)
			{
				if($usertypeid==$result['usertypeid'])
				{
					$flag=true;
					break;
				}
			}
			return $flag;
		}
		
		function insert()
		{
				$data['usertypeid']=$this->model_core_usertype->nextID();
				$data['usertypename']=$this->request->post['usertypename'];
				$data['UserTypeParent']=$this->request->post['UserTypeParent'];
				$data['permission'] = $this->getPermissionJSONString();
				$this->model_core_usertype->insertUsertype($data);	
		}
		
		function delete($data)
		{
			$this->model_core_usertype->deleteUsertype($data);	
		}
		
		
		function update()
		{
			$data['usertypeid']=$this->request->post['usertypeid'];
			$data['usertypename']=$this->request->post['usertypename'];
			$data['UserTypeParent']=$this->request->post['UserTypeParent'];
			$data['permission'] = $this->getPermissionJSONString();
			$this->model_core_usertype->updateUsertype($data);	
		}
	}
?>