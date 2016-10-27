<?php
abstract class Controller {
	protected $id;
	protected $template;
	protected $layout;
	protected $children = array();
	protected $data = array();
	//protected $error = array();
	protected $output;
	protected $name;
	protected $iscache = false;
	protected $module;
	
	public function __get($key) {
		return Registry::get($key);
	}
	
	public function __set($key, $value) {
		Registry::set($key, $value);
	}
			
	protected function forward($class, $method, $args = array()) {
		return new Action($class, $method, $args);
	}

	protected function redirect($url) {
		header('Location: ' . html_entity_decode($url));
		exit();
	}
	
	public function render() {		
		$cached = false;
		$outputhtml = "";
		if($this->iscache == true)
		{
			$this->output = $this->cachehtml->get($this->name);
			if($this->output != "")
			{
				
				$cached = true;
				//$this->output = $outputhtml;
				$this->response->setOutput($this->output);
				return;
			}
			
		}
		
		
		foreach ($this->children as $child) {
			$file  = DIR_APPLICATION . 'controller/' . $child . '.php';
			$class = 'Controller' . preg_replace('/[^a-zA-Z0-9]/', '', $child);
			
		
			if (file_exists($file)) {
				require_once($file);
				
				$controller = new $class();
				
				$controller->name = $class;
				
				$controller->module = $child;
				
				if($controller->iscache == true)
				{
					$outputhtml = $this->cachehtml->get($class);
					
					if($outputhtml != "")
					{
						$controller->output = $outputhtml;
						$controller->render();
					}
					else
					{
						$controller->index();
					}
				}
				else
				{
					$controller->index();
				}
				
				$this->data[$controller->id] = $controller->output;
			} else {
				exit('Error: Could not load controller ' . $child . '!');
			}
		}
		
		/*foreach($this->error as $key => $value)
		{
			$this->data['error_'.$key] = $value;
		}*/
		
		
		//$this->language->load($this->module, $this->user->getSiteId());
		$this->data = array_merge($this->data, $this->language->getData());
		$this->output = $this->fetch($this->template);
		
		if ($this->layout) {
			$file  = DIR_APPLICATION . 'controller/' . $this->layout . '.php';
			$class = 'Controller' . preg_replace('/[^a-zA-Z0-9]/', '', $this->layout);
			
			if (file_exists($file)) {
				require_once($file);
				
				$controller = new $class();
				
				$controller->name = $class;
				
				@$controller->module = $module;
				
				$controller->data[$this->id] = $this->output;
				
				
				$controller->index();
				
				$this->output = $controller->output;

			} else {
				exit('Error: Could not load controller ' . $this->layout . '!');
			}	
		}
		
		
		if($this->iscache == true && $cached == false)
		{
			$this->cachehtml->set($this->name, $this->output);
		}		
		
		$this->response->setOutput($this->output);

	}
	
	protected function fetch($filename) {
		$file = DIR_TEMPLATE . $filename;
    
		if (file_exists($file)) {
			extract($this->data);
			
      		ob_start();
      
	  		require($file);
      
	  		$content = ob_get_contents();

      		ob_end_clean();

      		return $content;
    	} else {
      		exit('Error2012: Could not load template ' . $file . '!');
    	}
	}
	
	public function loadModule($module, $method="index", $args = array())
	{
		$file  = DIR_APPLICATION . 'controller/' . $module . '.php';
		$class = 'Controller' . preg_replace('/[^a-zA-Z0-9]/', '', $module);
		
		if (file_exists($file)) {
			require_once($file);
			
			$controller = new $class();
			
			$controller->name = $class;
			
			$controller->module = $module;
			
			
			
			call_user_func_array(array($controller, $method), $args);
			
			return $controller->output;
		} else {
			exit('Error: Could not load controller ' . $module . '!');
		}
		
	}
	
	public function getRoute()
	{
		@$route = $this->request->get['route'];
		$arr = explode("/",$route);
		return @$arr[0]."/".@$arr[1];
	}
	
	public function getMethod()
	{
		$route = $this->request->get['route'];
		$arr = split("/",$route);
		return @$arr[2];
	}
	
	
	public function callmodule($file, $class, $output)
	{	
		if (file_exists($file)) {
			require_once($file);
			
			$controller = new $class();
			
			$controller->name = $class;
			
			$outputhtml = $this->cachehtml->get($class);;
			if($outputhtml != "")
			{
				$controller->output = $outputhtml;
				$controller->iscache = true;
				$controller->render();
			}
			else
			{
				$controller->index();
			}
			
			$this->data[$controller->id] = $controller->output;
		} else {
			exit('Error: Could not load controller ' . $child . '!');
		}
		
		
	}
	
	
}
?>