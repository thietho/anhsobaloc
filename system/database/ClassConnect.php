<?php
class ClassConnect
{
	function connecttion( $serverName, $dbName, $userId, $pass )
	{
		// Connect to Database
		$conn = mysql_connect($serverName, $userId, $pass);
		mysql_select_db($dbName,$conn);
		return $conn;
	}
	function close($conn)
	{
		mysql_close($conn);
	}
	function mutiData($sql)
	{
		$show=mysql_query($sql);
		$table=array();
		while($result=mysql_fetch_array($show))
			array_push($table,$result);
		return $table;
	}
	function singleData($sql)
	{
		$show=mysql_query($sql);
		$result=mysql_fetch_array($show);
		return $result;
	}
	function getRowData($tablename,$tableid,$value)
	{
		$value = $this->safe($value);
		$sql="SELECT * FROM `$tablename` WHERE `$tableid`='$value'";
		$row= ClassConnect::singleData($sql);
		return $row;
	}
	function getMaxthutu($tablename)
	{
		$sql="SELECT max(ThuTu) as thutu FROM `$tablename`";
		$max= ClassConnect::singleData($sql);
		return $max['thutu'];
	}
	function getNextId($tablename,$tableid)
	{
		$sql="SELECT max($tableid) as max FROM `$tablename`";
		$max= ClassConnect::singleData($sql);
		return $max['max']+1;
	}
	function getNextIdVarChar($tablename,$tableid,$temp)
	{
	 	$temp = $this->safe($temp);
		$sql="SELECT $tableid FROM `$tablename` WHERE $tableid LIKE '$temp%'";
		$mid= ClassConnect::mutiData($sql);
		//print_r($mid);
		//echo count($mid);
		if(count($mid)==0)
			return $temp."1";
		$mnum=array();
		for($i=0; $i<count($mid); $i++)
		{
			//echo $mid[$i][$tableid];
			//echo substr($mid[$i][$tableid],strlen($temp));
			array_push($mnum,substr($mid[$i][$tableid],strlen($temp)));
		}
		$max=0;
		//print_r($mnum);
		for($i=0; $i<count($mnum); $i++)
			if($max<intval($mnum[$i]))
				$max=intval($mnum[$i]);
		$nextid=$max+1;
		return $temp.$nextid;
	}
	function tableData($sql,$fields)
	{
		$row=$sql;
		$show=mysql_query($row);
		is_array($fields) ? $col = count($fields) : $col = mysql_num_fields($result);
		$table="<table>";
		while($result=mysql_fetch_array($show))
		{
			$table.="<tr>";
			for($i=0;$i<$col;$i++)
				$table.="<td>".$result[$i]."</td>";	
			$table.="</tr>";
		}	
		$table.="</table>";
		return $table;
	}
	function cbData($sql,$value,$display,$fistvalue,$fistdisplay,$cbname)
	{
		$row=$sql;
		$show=mysql_query($row);
		$cb="<select name='".$cbname."'>";
		$cb.="<option value='".$fistvalue."'>".$fistdisplay."</option>";
		while($result=mysql_fetch_array($show))
		{
			$cb.="<option value='".$result[$value]."'>".$result[$display]."</option>";
		}	
		$cb.="</select>";
		return $cb;
	}
	function cbDataajax($sql,$value,$display,$fistvalue,$fistdisplay,$cbname,$action)
	{
		$row=$sql;
		$show=mysql_query($row);
		$cb="<select name='".$cbname."' onChange=\"$action\">";
		$cb.="<option value='".$fistvalue."'>".$fistdisplay."</option>";
		while($result=mysql_fetch_array($show))
		{
			$cb.="<option value='".$result[$value]."'>".$result[$display]."</option>";
		}	
		$cb.="</select>";
		return $cb;
	}
	function insertData( $conn, 
					  $table = NULL, 
					  $fields = NULL,
					  $values = NULL 
					)
	{
				  
		$values = $this->safe($values); 
		$sql = "INSERT INTO `".$table."`(" ;
		if(count($fields)!=count($values)){ die("<br><b>ERROR (Syntax Error):</b> Number of fields don't match with values.") ; }
		else
		{
			is_array($fields) ? $sql .= implode(",",$fields) : $sql .= $fields;
			$sql .= ") VALUES('";
			is_array($values) ? $sql .= implode("','",$values) : $sql .= "'".$values."'";
			$sql .= "')";
			//echo $sql;		
			$thucthi=mysql_query($sql, $conn) or die("<br><b>ERROR (SQL Error):</b> ".mysql_error()) ;
			
			//mysql_close($conn) ;
			return $thucthi;
		}
		
	}
	function updateData( $conn, 
					  $table = NULL, 
					  $fields = NULL,
					  $values = NULL,
					  $where = NULL,
					  $whereValue = NULL 
					)
	{
		 
		$values = $this->safe($values); 
		$whereValue = $this->safe($whereValue);
		
		$sql = "UPDATE `".$table."` SET " ;
		
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
			$sql .= " WHERE ".$where." = '".$whereValue."'";
			//echo $sql;
			$thucthi=mysql_query($sql, $conn) or die("<br><b>ERROR (SQL Error):</b> ".mysql_error()) ;
			//mysql_close($conn) ;
			return $thucthi;
		}
	}
	function deleteData( $conn, 
					  $table = NULL, 
					  $where = NULL,
					  $whereValue = NULL 
					)
	{
		$whereValue = $this->safe($whereValue); 
		$sql="DELETE FROM `$table` WHERE `$where` = '$whereValue'";
		$thucthi=mysql_query($sql, $conn) or die("<br><b>ERROR (SQL Error):</b> ".mysql_error()) ;
		//echo $sql;
			//mysql_close($conn) ;
			return $thucthi;
	}
	function query($conn,$sql)
	{
		$thucthi=mysql_query($sql, $conn) or die("<br><b>ERROR (SQL Error):</b> ".mysql_error()) ;
			//mysql_close($conn) ;
		return $thucthi;
	}
	function searchData($sql)
	{
		
	}
	function fixPos($tablename,$tableid)
	{
		$sql="SELECT  $tableid FROM `$tablename` ORDER BY `Pos` ASC";
		$table= ClassConnect::mutiData($sql);
		for($i=0;$i<count($table);$i++)
		{
			$sql="UPDATE `$tablename` SET `ThuTu` = ".($i+1)." WHERE `$tableid` ='".$table[$i][''.$tableid]."'";
			mysql_query($sql);
		}
	}
	function shitPos($tablename,$tableid,$pos)
	{
		$sql="SELECT  $tableid FROM `$tablename` ORDER BY `Pos` ASC";
		$table= ClassConnect::mutiData($sql);
		for($i=$pos-1;$i<count($table);$i++)
		{
			$sql="UPDATE `$tablename` SET `Pos` = ".($i+2)." WHERE `$tableid` =".$table[$i][''.$tableid];
			mysql_query($sql);
		}
	}
	
	function safe($values){
		if(is_array($values))
		{
			foreach($values as $value)
			{
				$value = mysql_real_escape_string($value);
			}
			return $values;
		}
		else
		{
			return mysql_real_escape_string($values);
		}
	} 
}
?>