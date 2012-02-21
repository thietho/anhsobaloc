<?php
final class Request {
	public $get = array();
	public $post = array();
	public $cookie = array();
	public $files = array();
	public $server = array();
	
  	public function __construct() {
		$_GET = array_merge($_GET,$this->getPara());
		$this->get    = &$this->clean($_GET);
		
		
		$this->post   = &$this->clean($_POST);
		$this->cookie = &$this->clean($_COOKIE);
		$this->files  = &$this->clean($_FILES);
		$this->server = &$this->clean($_SERVER);
	}

  	public function clean($data) {
    	if (is_array($data)) {
	  		foreach ($data as $key => $value) {
	    		$data[$key] = &$this->clean($value);
	  		}
		} else {
	  		$data = stripslashes(htmlspecialchars($data, ENT_QUOTES, 'UTF-8'));
			$data = trim($data);
		}
	
		return $data;
	}
	
	public function getPara()
	{
		$uri = $_SERVER['REQUEST_URI'];
		$arr = split("\?",$uri);
		
		$listpara = split("&",$arr[1]);
		$para = array();
		foreach($listpara as $val)
		{
			$ar = split("=",$val);	
			$para[$ar[0]] = $ar[1];
		}
		return $para;
	}
}
?>