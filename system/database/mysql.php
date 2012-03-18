<?php
final class MySQL {
	private $link;
	private $prefix;
	
	public function __construct($hostname, $username, $password, $database, $prefix = NULL) {
		if (!$this->link = mysql_connect($hostname, $username, $password)) {
      		exit('Error: Could not make a database connection using ' . $username . '@' . $hostname);
    	}

    	if (!mysql_select_db($database, $this->link)) {
      		exit('Error: Could not connect to database ' . $database);
    	}
		
		$this->prefix = $prefix;
		
		mysql_query("SET NAMES 'utf8'", $this->link);
		mysql_query("SET CHARACTER SET utf8", $this->link);
  	}
		
  	public function query($sql) {
		
		$resource = mysql_query(str_replace('#__', $this->prefix, $sql), $this->link);

		if ($resource) {
			if (is_resource($resource)) {
				$i = 0;
    	
				$data = array();
		
				while ($result = mysql_fetch_assoc($resource)) {
					$data[$i] = $result;
    	
					$i++;
				}
				
				mysql_free_result($resource);
				
				$query = new stdClass();
				$query->row      = isset($data[0]) ? $data[0] : array();
				$query->rows     = $data;
				$query->num_rows = $i;
				
				unset($data);

				return $query;	
    		} else {
				return TRUE;
			}
		} else {
      		exit('Error: ' . mysql_error() . '<br />Error No: ' . mysql_errno() . '<br />' . $sql);
    	}
  	}
	
	public function escape($value) {
		return mysql_real_escape_string($value, $this->link);
	}
	
  	public function countAffected() {
    	return mysql_affected_rows($this->link);
  	}

  	public function getLastId() {
    	return mysql_insert_id($this->link);
  	}
	
	public function getNextId($tablename,$tableid)
	{
		$sql="SELECT max($tableid) as max FROM `$tablename`";
		$query = $this->query($sql);
		return $query->rows[0]['max']+1;
	}
	
	function getNextIdVarChar($tablename,$tableid,$prefix)
	{
		$sql="SELECT $tableid FROM `$tablename` WHERE $tableid LIKE '$prefix%'";
		$query= $this->query($sql);
		$mid=$query->rows;
		if(count($mid)==0)
			return $prefix."1";
		$mnum=array();
		for($i=0; $i<count($mid); $i++)
		{
			array_push($mnum,substr($mid[$i][$tableid],strlen($prefix)));
		}
		$max=0;
		for($i=0; $i<count($mnum); $i++)
			if($max<intval($mnum[$i]))
				$max=intval($mnum[$i]);
		$nextid=$max+1;
		return $prefix.$nextid;
	}
	
	function insertData(  
					  $tablename = NULL, 
					  $fields = NULL,
					  $values = NULL 
					)
	{
		$sql = "INSERT INTO `".$tablename."`(" ;
		if(count($fields)!=count($values)){ die("<br><b>ERROR (Syntax Error):</b> Number of fields don't match with values.") ; }
		else
		{
			is_array($fields) ? $sql .= implode(",",$fields) : $sql .= $fields;
			$sql .= ") VALUES('";
			is_array($values) ? $sql .= implode("','",$values) : $sql .= "'".$values."'";
			$sql .= "')";
			$this->query($sql);
			return $this->getLastId();
		}
		
	}
	
	function updateData(
					  $tablename = NULL, 
					  $fields = NULL,
					  $values = NULL,
					  $where = NULL
					)
	{	
		$sql = "UPDATE `".$tablename."` SET " ;
		
		if(count($fields)!=count($values)){ die("ERROR (Syntax Error): Number of fields don't match with values.") ; }
		else
		{
			if(is_array($fields) && is_array($values))
			{
				for($i=0;$i<count($fields);$i++)	
				{
					$sql .= $fields[$i]." = '".$values[$i]."' " ;
					if($i==(count($fields)-1)) $sql .= " " ;
					else $sql .= ", ";
					
				}
			}
			else{ $sql .= $fields." = ".$values ; }	
			$sql .= " WHERE ".$where;
			$this->query($sql);
		}
	}
	
	function deleteData( 
					  $tablename = NULL, 
					  $where = NULL
					)
	{
		$sql="DELETE FROM `$tablename` WHERE $where";
		$this->query($sql);
	}

}
?>