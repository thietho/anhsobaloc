<?php
class ModelCoreBackup extends Model
{ 
	function backupData($tables = array())
	{
		if(count($tables)==0)
		{
			$tables = array();
			
			$query = $this->db->query('SHOW TABLES');
			foreach( $query->rows as $row)
			{
				foreach($row as $table)
					$tables[] = $table;
			}
			
		}
		else
		{
			$tables = is_array($tables) ? $tables : explode(',',$tables);
		}
		$txt_sql ="";
		$handle = fopen('db-backup.sql','w');
		foreach($tables as $table)
		{
			$sql = "SELECT * FROM `".$table."`";	
			$create = "SHOW CREATE TABLE `".$table."`";
			$query = $this->db->query($create);
			$txt_create = $query->row['Create Table'];
			//$txt_sql.=$txt_create.";";
			fwrite($handle,$txt_create.";");
			$query = $this->db->query($sql);
			foreach($query->rows as $item)
			{
					
				 foreach($item as $key => $val)
				 {
					//$arr_key[] =  $key;
					$val =addslashes($val);
					$val =  ereg_replace("\n","\\n",$val);
					$arr_val[] = $val;
					
					
				 }
				 //$cols = implode("`,`",$arr_key);
				 $vals = implode("','",$arr_val);
				 $insert = "INSERT INTO ".$table." VALUES(`".$vals."`);";
				//$txt_sql.=$insert;	
				fwrite($handle,$insert);		
			}
		}
		 
		
		
		fclose($handle);
	}
	public function backup()
	{
		//$str = $this->db->backupData();
	}
}

?>