<?php
final class Cachehtml { 
	private $expire = 3600;

  	public function __construct() {
		$files = glob(DIR_CACHEHTML . 'cachehtml.*');
    	
		foreach ($files as $file) {
      		$time = end(explode('.', basename($file)));

      		if ($time < time()) {
				@unlink($file);
      		}
    	}	
  	}

	public function get($key) {
		if($key == "Controllerbuycarcarlist"){
			$key .= $_SERVER['QUERY_STRING'];
			$key .= $_SESSION['UserID'];
		}
		else
		{
			$key .= $_SERVER['QUERY_STRING'];
		}
		$key = eregi_replace('[/]', '_', $key);

    	foreach (glob(DIR_CACHEHTML . 'cachehtml.' . $key . '.*') as $file) {
			
      		$handle = fopen($file, 'r');
      		@$cache  = fread($handle, filesize($file));
	  
      		fclose($handle);

      		return $cache;
    	}
  	}

  	public function set($key, $value) {
		if($key == "Controllerbuycarcarlist"){
			$key .= $_SERVER['QUERY_STRING'];
			$key .= $_SESSION['UserID'];
		}
		else
		{
			$key .= $_SERVER['QUERY_STRING'];
		}
    	$key = eregi_replace('[/]', '_', $key);
		
		$this->delete($key);
		if (!is_dir(DIR_CACHEHTML))
			mkdir( DIR_CACHEHTML , 0777 );
		$file = DIR_CACHEHTML . 'cachehtml.' . $key . '.' . (time() + $this->expire);
    	
		$handle = fopen($file, 'w');

    	fwrite($handle, $value);
		
    	fclose($handle);
  	}
	
  	public function delete($key) {
    	foreach (glob(DIR_CACHEHTML . 'cachehtml.' . $key . '.*') as $file) {
      		@unlink($file);
    	}
  	}
}
?>