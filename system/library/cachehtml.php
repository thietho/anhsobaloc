<?php
final class Cachehtml { 
	private $expire = 30;

  	public function __construct() {
		$files = glob(DIR_CACHEHTML . 'cachehtml.*');
    	
		foreach ($files as $file) {
      		//$time = end(explode('.', basename($file)));
			$time = fileatime($file);
			if (time()- $time >$this->expire)
			{
				unlink($file);
			}
      		
    	}	
  	}
	
	public function iscacht($key)
	{
		$file = DIR_CACHEHTML . 'cachehtml.' . $key ; 
		if(file_exists($file))
			return true;
		else
			return false;
				
	}
	
	public function get($key) 
	{
		$file = DIR_CACHEHTML . 'cachehtml.' . $key ; 
		if(file_exists($file))
		{
			$handle = fopen($file, 'r');
			$cache  = fread($handle, filesize($file));
			fclose($handle);
		}
		return $cache;
    	/*foreach (glob(DIR_CACHEHTML . 'cachehtml.' . $key . '.*') as $file) {
			
      		$handle = fopen($file, 'r');
      		@$cache  = fread($handle, filesize($file));
	  
      		fclose($handle);

      		return $cache;
    	}*/
  	}

  	public function set($key, $value) {
		
    	$key = eregi_replace('[/]', '_', $key);
		
		if (!is_dir(DIR_CACHEHTML))
			mkdir( DIR_CACHEHTML , 0777 );
		$file = DIR_CACHEHTML . 'cachehtml.' . $key ; 
		@$time = fileatime($file);
		if (time()- $time > $this->expire)
		{
    		$handle = fopen($file, 'w');
			fwrite($handle, $value);
			fclose($handle);
		}   	
		
  	}
	
  	
}
?>