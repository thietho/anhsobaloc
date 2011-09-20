<?php
class ModelCoreCountry extends Model 
{
	public function getCountrys()
	{
		$query = $this->db->query("Select * from `country`");
		return $query->rows;
	}
	
	public function getCountry($countryid)
	{
		$sql = "Select * from `country` where countryid = '".$countryid."'";
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	public function getCountryByCode($countryid)
	{
		$sql = "Select * from `country` where iso_code_2 = '".$countryid."'";
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	public function getZonesByCode($code)
	{
		$query = $this->db->query("Select * from `zone` 
							Where countryid = (Select countryid from `country` Where iso_code_2='".$code."')");
		return $query->rows;
	}
	
	public function getZone($zoneid)
	{
		$sql= "Select * from `zone` where zoneid = '".$zoneid."'";
		$query = $this->db->query($sql);
		return $query->row;
	}	
	
	public function getZoneByCode($code)
	{
		echo $sql= "Select * from `zone` where code  = '".$code."'";
		$query = $this->db->query($sql);
		return $query->row;
	}	
}

?>