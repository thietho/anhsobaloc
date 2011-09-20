<?php
class ModelCoreModule extends Model 
{ 
	public function getModules()
	{
		$query = $this->db->query("Select * from `module` Order By position");
		return $query->rows;
	}
	
	public function getSitemapModules()
	{
		$query = $this->db->query("Select * from `module` where status = 'Sitemap' OR status = 'Active' Order By position");
		return $query->rows;
	}
	
	public function getModulesIn($list)
	{
		$query = $this->db->query("Select * from `module` Where moduleid in ($list) Order By position");
		return $query->rows;
	}
	
	public function getModule($moduleid)
	{
		$query = $this->db->query("SELECT * 
									FROM `module` 
									WHERE `moduleid` = '".$moduleid."'
									");
		return $query->row;
	}	
	
	public function liststatus()
	{
		return array(
				"Active"=>"Active",
				"Sitemap"=>"Sitemap",
				"UnActive"=>"UnActive"
				);
	}
	
	public function nextID()
	{
		return $this->db->getNextIdVarChar("module","moduleid","Module");
	}
	
	public function nextPosition($parent)
	{
		$query = $this->db->query("Select max(position) as max From module where moduleparent='".$parent."' Order By position");
		return $query->rows[0]['max'] +1 ;
	}
	
	public function insertModule($data)
	{
		$moduleid=$this->db->escape(@$data['moduleid']);
		$modulename=$this->db->escape(@$data['modulename']);
		$moduleparent=$this->db->escape(@$data['moduleparent']);
		$position=(int)@$data['position'];
		$status=$this->db->escape(@$data['status']);
		$modulepath=$this->db->escape(@$data['modulepath']);
		$permission=$this->db->escape(@$data['permission']);	
		$permission=$this->db->escape(@$data['permission']);	
		$field=array(
						'moduleid',
						'modulename',
						'moduleparent',
						'position',
						'status',
						'modulepath',
						'permission'
					);
		$value=array(
						$moduleid,
						$modulename,
						$moduleparent,
						$position,
						$status,
						$modulepath,
						$permission
					);
		$this->db->insertData("module",$field,$value);
	}
		
	
	
	
	public function updateModule($data, $cache)
	{
		$lastmoduleid = $this->db->escape(@$cache['moduleid']);
		$moduleid=$this->db->escape(@$data['moduleid']);
		$modulename=$this->db->escape(@$data['modulename']);
		$moduleparent=$this->db->escape(@$data['moduleparent']);
		$position=(int)@$data['position'];
		$status=$this->db->escape(@$data['status']);
		$modulepath=$this->db->escape(@$data['modulepath']);	
		$permission=$this->db->escape(@$data['permission']);	
		$field=array(
						'moduleid',
						'modulename',
						'moduleparent',
						'position',
						'status',
						'modulepath',
						'permission'
					);
		$value=array(
						$moduleid,
						$modulename,
						$moduleparent,
						$position,
						$status,
						$modulepath,
						$permission
					);
		$where="moduleid = '".$lastmoduleid."'";
		$this->db->updateData("module",$field,$value,$where);
	}
	
	public function updateModulePosition($moduleid,$position)
	{
		$moduleid=$this->db->escape(@$moduleid);
		
		$position=(int)@$position;
		
		$field=array(
						'moduleid',
						
						'position'
						
					);
		$value=array(
						$moduleid,
						
						$position
						
					);
		$where="moduleid = '".$moduleid."'";
		$this->db->updateData("module",$field,$value,$where);
	}
	
	public function deleteModule($moduleid)
	{
		if($this->validateDelete($moduleid))
		{
			$where="moduleid = '".$moduleid."'";
			$this->db->deleteData('module',$where);	
			return true;
		}
		return false;
	}
	
	public function validateDelete($id)
	{
		//Sitemap
		$moduleid=$this->db->escape(@$id);
		$sql="SELECT * 
									FROM `sitemap` 
									WHERE `moduleid` = '".$moduleid."'
									";
		$query = $this->db->query($sql);
		$arr = $query->rows;
		if(count($arr))
			return false;
		
		//Sitemap content
		$query = $this->db->query("SELECT * 
									FROM `sitemap_media` 
									WHERE `moduleid` = '".$moduleid."'
									");
		$arr = $query->rows;
		if(count($arr))
			return false;
		
		return true;
	}
	
	public function validateDuplikey($id)
	{
		$rows=$this->getModule($id);
		if(count($rows))
			return true;
		else
			return false;
	}
}
?>