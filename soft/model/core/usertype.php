<?php
class ModelCoreUsertype extends Model 
{ 
	public $listPermission = array(
								 "access" => "Access",
								 "add" => "Add",
								 "edit" => "Edit",
								 "delete" => "Delete",
								 );
	public function getUserTypes()
	{
		$query = $this->db->query("Select * from `usertype` where usertypename not like 'member' and usertypename not like 'author'");
		return $query->rows;
	}
	
	public function getMemberType()
	{
		$query = $this->db->query("Select * from `usertype` where usertypename='member'");
		return $query->rows;
	}
	
	public function getUserType($id)
	{
		$sql = "Select * from `usertype` where usertypeid='".$id."'";
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	public function getList($where="")
	{
		$sql = "Select * from `usertype` WHERE 1=1 ".$where;	
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	public function getAllUsertype()
	{
		$query = $this->db->query("Select * from `usertype`");
		return $query->rows;
	}
	
	public function nextID()
	{
		return $this->db->getNextId("usertype","usertypeid");
	}
	public function getUserTypeName($name)
	{
		$query = $this->db->query("Select * from `usertype` where usertypename = '".$name."'");
		return $query->rows;
	}
	
	public function getUserTypeChild($id)
	{
		$sql = "Select * From usertype where UserTypeParent='".$id."'";
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	function getTreeUserType($id,&$data)
	{
		$arr=$this->getUserType($id);
		if($id!="")
			array_push($data,$arr);
		$rows = $this->getUserTypeChild($id);
		
		if(count($rows))
			foreach($rows as $row)
			{
				$this->getTreeUserType($row['usertypeid'],$data);
			}
	
	}
	
	function getDeep($id)
	{
		$deep=0;
		$row=$this->getUserType($id);
		while($row[0]['UserTypeParent']!="")
		{
			$deep++;
			$row=$this->getUserType($row[0]['UserTypeParent']);
		}
		return $deep;
	}
	
	public function insertUsertype($data)
	{
		$usertypeid=(int)@$data['usertypeid'];
		$usertypename=$this->db->escape(@$data['usertypename']);
		$permission=@$data['permission'];
		$UserTypeParent=(int)@$data['UserTypeParent'];

		$field=array(
						"usertypeid",
						"usertypename",
						"permission",
						"UserTypeParent"
					);
		$value=array(
						$usertypeid,
						$usertypename,
						$permission,
						$UserTypeParent
					);
		$this->db->insertData("usertype",$field,$value);
		
	}
	
	public function updateUsertype($data)
	{
		$usertypeid=(int)@$data['usertypeid'];
		$usertypename=$this->db->escape(@$data['usertypename']);
		$permission=@$data['permission'];
		$UserTypeParent=(int)@$data['UserTypeParent'];

		$field=array(
						"usertypeid",
						"usertypename",
						"permission",
						"UserTypeParent"
					);
		$value=array(
						$usertypeid,
						$usertypename,
						$permission,
						$UserTypeParent
					);
		$where="usertypeid = ".$usertypeid;
		$this->db->updateData('usertype',$field,$value,$where);
		
	}
	
	public function updatePermission($data)
	{
		$usertypeid=$this->db->escape(@$data['usertypeid']);
		$permission=$this->db->escape(@$data['permission']);

		$field=array(
						"permission"
					);
		$value=array(
						$permission
					);
		$where="usertypeid = '".$usertypeid."'";
		$this->db->updateData('usertype',$field,$value,$where);
		
	}
	
	public function deleteUsertype($data)
	{
		foreach($data as $usertypeid)
		{
			$usertypeid=(int)@$usertypeid;
			$where="usertypeid = ".$usertypeid;
			$this->db->deleteData('usertype',$where);
		}	
	}
	
}
?>