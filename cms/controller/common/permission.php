<?php    
class ControllerCommonPermission extends Controller {    
	
	public function index() {
		
		$arrControl = $this->user->getControl();
		
		$route = $this->getRoute();
		$part = explode('/', $route);
		$ModuleID = @$part[0] . '/' . @$part[1];
		
		$ignore = array(
				'page/home',
				'common/login',
				'common/logout',
				'common/permission',
				'common/help',
				'common/about',
				'core/cpanel',
				'core/module',
				'core/usertype',
				'media/media',
				'test/receivefilesearch',
				'media/filesearch',
				'core/fileajaxeditor',
				'catalog/productaction',
				'media/mediainsertajax',
				'common/newsaction',
				'core/changepassword',
				'core/profile',
				'core/site'
			);
		
		//Lay mang cac permission
		$this->data['hiddencontrols'] = array(); 
		if (!in_array(@$part[0] . '/' . @$part[1], $ignore)) {
		
			$arr = $this->user->getPermission();
		
			//Mang quyen
			$arrPermission = $arr[$ModuleID]['permissions'];
			
			$this->load->model('core/module');
			
			$dataModule = $this->model_core_module->getModule($ModuleID);
			
			$arrModulePermission = array();
			if(count($dataModule) > 0)
			{
				//mang tat ca quyen
				$arrModulePermission = $this->json->decode($dataModule["permission"]);
			}
			
			if(is_array($arrPermission)){
				foreach($arrPermission as $item)
				{
					unset($arrModulePermission[$this->string->inArray($item,$arrModulePermission)]);
				}
			}
			
			foreach($arrModulePermission as $item)
			{
				$this->data['hiddencontrols'][] = 'is'.$item;
			}
			/*foreach($arrModulePermission as $items)
			{
				foreach($items as $item)
				{
					foreach($item as $control)
					{
						$this->data['hiddencontrols'][] = 'is'.$control;
					}
				}
			}*/
		
		}
		
		
		
		$this->id="permission";
		
		$this->template = "common/permission.tpl";
		
		$this->render();		
	
	}
	
	public function checkPermission() {
		if (isset($this->request->get['route'])) {
			$route = $this->getRoute();
		  
			$part = explode('/', $route);
			
			$ignore = array(
				'page/home',
				'common/login',
				'common/requestpassword',
				'common/logout',
				'common/permission',
				'common/help',
				'common/about',
				'core/cpanel',
				
				'core/user',
				'core/fileadjustment',
				'core/changepassword',
				//'core/file',
				//'core/fileadjust',
				'message/list',
				'message/detail',
				'message/compose',
				'message/selectemail',
				'message/selectuser',
				
				'core/module',
				'core/usertype',
				'media/media',
				'test/receivefilesearch',
				'media/filesearch',
				'media/mediainsertajax'	,
				'core/fileajaxeditor',
				'catalog/productaction',
				'core/sitemap',
				'common/newsaction',
				'core/profile',
				'core/site'
			);
			
			if (!in_array(@$part[0] . '/' . @$part[1], $ignore)) {
				$ModuleID = @$part[0] . '/' . @$part[1];
				
				if(isset($this->request->get['formtype'])){
					$FormType = $this->request->get['formtype'];
				}
				
				if(isset($this->request->post['formtype'])){
					$FormType = $this->request->post['formtype'];
				}
				
				$SiteMapID = $this->request->get['sitemapid'];
				if (!$this->user->hasPermission($ModuleID, $FormType, $SiteMapID)) {
					return $this->forward('error/permission', 'index');
				}
			}
		}
	}
}
?>