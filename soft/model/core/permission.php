<?php
	class ModelCorePermission extends Model 
	{
		public function getPermissions()
		{
			$query = $this->db->query("Select * form `permission`");
			return $query->rows;
		}
		
		public function getPermission($PermissionID)
		{
			$query = $this->db->query("Select * form `permission` where PermissionID=".$PermissionID);
			return $query->rows;
		}
		
		public function insertLanguage($data)
		{
			$PermissionID=(int)@$data['PermissionID'];
			$PermissionName=$this->db->escape(@$data['PermissionName']);
			
			$field=array(
							'PermissionID',
							'PermissionName' 
						);
			$value=array(
							$PermissionID,
							$PermissionName
						);
			$this->db->insertData("permission",$field,$value);
		}
			
		
		
		
		public function insertLanguage($data)
		{$PermissionID=(int)@$data['PermissionID'];
			$PermissionName=$this->db->escape(@$data['PermissionName']);
			
			$field=array(
							'PermissionID',
							'PermissionName' 
						);
			$value=array(
							$PermissionID,
							$PermissionName
						);
			$where = "PermissionID = ".$PermissionID;
			$this->db->updateData("permission",$field,$value,$where);
		}
		
		
		public function deleteLanguege($data)
		{
			foreach($data as $PermissionID)
			{
				
				$where = "PermissionID = ".$PermissionID;
				$ob->deleteData('permission',$where);
			}		
		}
			
		
	}


?>