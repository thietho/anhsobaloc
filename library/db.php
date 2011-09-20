<?php
final class DB {
	private $driver;
	private $prefix;
	
	public function __construct($driver, $hostname, $username, $password, $database, $prefix = NULL) {
		if (!@require_once(DIR_DATABASE . $driver . '.php')) {
			exit('Error: Could not load database file ' . $driver . '!');
		}
		
		$this->driver = new $driver($hostname, $username, $password, $database, $prefix);
		
	}
		
  	public function query($sql) {
		//echo $sql."<br><br>";
		return $this->driver->query($sql);
  	}
	
	public function escape($value) {
		return $this->driver->escape($value);
	}
	
  	public function countAffected() {
		return $this->driver->countAffected();
  	}

  	public function getLastId() {
		return $this->driver->getLastId();
  	}
	
	public function getNextId($tablename,$tableid) {
		return $this->driver->getNextId($tablename,$tableid);
  	}
	
	public function getNextIdVarChar($tablename,$tableid,$prefix) {
		return $this->driver->getNextIdVarChar($tablename,$tableid,$prefix);
  	}
	
	public function insertData(  
					  $tablename = NULL, 
					  $fields = NULL,
					  $values = NULL 
					) {
		return $this->driver->insertData(  $tablename, $fields,$values);
  	}
	
	public function updateData(
					  $tablename = NULL, 
					  $fields = NULL,
					  $values = NULL,
					  $where = NULL
					) 
	{
		return $this->driver->updateData($tablename , $fields,$values,$where);
  	}
	
	public function deleteData( 
					  $tablename = NULL, 
					  $where = NULL
					) {
		return $this->driver->deleteData( $tablename, $where);
  	}	
}
?>