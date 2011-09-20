<?php
class ModelCoreSite extends Model 
{
	public function getList()
	{
		$query = $this->db->query("Select * from `site`");
		return $query->rows;
	}
	
	public function getItem($siteid)
	{
		$query = $this->db->query("Select * from `site` where siteid = '".$siteid."'");
		return $query->row;
	}
	
	public function getStatusList()
	{
		return array(
				"Active"=>"Active",
				"Pause"=>"Pause"
				);
	}
	
	public function insertSite($data)
	{
		$siteid=$this->db->escape(@$data['siteid']);
		$sitename=$this->db->escape(@$data['sitename']);
		$siteurl=$this->db->escape(@$data['siteurl']);
		$language=$this->db->escape(@$data['language']);
		$pagetopic=$this->db->escape(@$data['pagetopic']);
		$description=$this->db->escape(@$data['description']);
		$keywords=$this->db->escape(@$data['keywords']);
		$status=$this->db->escape(@$data['status']);
		
		$field=array(
						'siteid',
						'sitename',
						'siteurl',
						'language',
						'pagetopic',
						'description',
						'keywords',
						'status'
					);
		$value=array(
						$siteid,
						$sitename,
						$siteurl,
						$language,
						$pagetopic,
						$description,
						$keywords,
						$status
					);
		$this->db->insertData("site",$field,$value);
	}
	
	public function updateSite($data)
	{
		$siteid=$this->db->escape(@$data['siteid']);
		$sitename=$this->db->escape(@$data['sitename']);
		$siteurl=$this->db->escape(@$data['siteurl']);
		$language=$this->db->escape(@$data['language']);
		$pagetopic=$this->db->escape(@$data['pagetopic']);
		$description=$this->db->escape(@$data['description']);
		$keywords=$this->db->escape(@$data['keywords']);
		$status=$this->db->escape(@$data['status']);
		
		$field=array(
						'sitename',
						'siteurl',
						'language',
						'pagetopic',
						'description',
						'keywords',
						'status'
					);
		$value=array(
						$sitename,
						$siteurl,
						$language,
						$pagetopic,
						$description,
						$keywords,
						$status
					);
					
		$where="siteid = '".$siteid."'";
		$this->db->updateData("site",$field,$value,$where);
	}	
			
	public function deleteSite($siteid)
	{
		$siteid=$this->db->escape(@$siteid);
		$where="siteid = '".$siteid."'";
		$this->db->deleteData('site',$where);
	}
	
	public function deleteSites($data)
	{
		foreach($data as $siteid)
		{
			$this->deleteSite($siteid);
		}		
	}
	
}

?>