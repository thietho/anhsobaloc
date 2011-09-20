<?php
class ModelCommonCounter extends Model 
{ 
	public function getCounter()
	{
		$mediaid='counter';
		$fieldname='counter';
		$sql="Select * from media_information
					WHERE mediaid='".$mediaid."'
							AND fieldname ='".$fieldname."'";
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	public function createCounter()
	{
		$mediaid='counter';
		$fieldname='counter';
		$fieldvalue='0';//begin counter
		
		$field=array(
						"mediaid",
						"fieldname",
						"fieldvalue"
						
					);
		$value=array(
						$mediaid,
						$fieldname,
						$fieldvalue
						
						);
		$this->db->insertData("media_information",$field,$value);	
	}
	
	public function updateCounter($value)
	{
		$mediaid='counter';
		$fieldname='counter';
		$fieldvalue=$this->db->escape(@$value);
		$LanguageID='';
		$field=array(
					"mediaid",
					"fieldname",
					"fieldvalue"
				);
		$value=array(
					$mediaid,
					$fieldname,
					$fieldvalue
					);
		$where="mediaid = '".$mediaid."' AND fieldname = '".$fieldname."'";
		$this->db->updateData('media_information',$field,$value,$where);
	}
}
?>