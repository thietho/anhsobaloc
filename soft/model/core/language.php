<?php
	class ModelCoreLanguage extends Model 
	{
		public function getLanguages()
		{
			$query = $this->db->query("SELECT * FROM `language` ");
			return $query->rows;
		}
		
		public function getLanguage($LanguageID)
		{
			$query = $this->db->query("Select * form `language` where LanguageID =".$LanguageID);
			return $query->rows;
		}
		
		public function insertLanguage($data)
	{
		$LanguageID=(int)@$data['LanguageID'];
		$Name=$this->db->escape(@$data['Name']);
		$Code=$this->db->escape(@$data['Code']);
		$Locale=$this->db->escape(@$data['Locale']);
		$Image=$this->db->escape(@$data['Image']);
		$Directory=$this->db->escape(@$data['Directory']);
		$Filename=$this->db->escape(@$data['FileName']);
		$SortOrder=(int)@$data['SortOrder'];
		$Status=(int)@$data['Status'];
		$field=array(
						'LanguageID',
						'Name' ,
						'Code',
						'Locale',
						'Image',
						'Directory',
						'Filename',
						'SortOrder'
					);
		$value=array(
						$LanguageID,
						$Name,
						$Code,
						$Locale,
						$Image,
						$Directory,
						$Filename,
						$SortOrder,
						$Status
					);
		$this->db->insertData("langguage",$field,$value);
		}
		
		public function updateLanguage($data)
	{
		$LanguageID=(int)@$data['LanguageID'];
		$Name=$this->db->escape(@$data['Name']);
		$Code=$this->db->escape(@$data['Code']);
		$Locale=$this->db->escape(@$data['Locale']);
		$Image=$this->db->escape(@$data['Image']);
		$Directory=$this->db->escape(@$data['Directory']);
		$Filename=$this->db->escape(@$data['FileName']);
		$SortOrder=(int)@$data['SortOrder'];
		$Status=(int)@$data['Status'];
		$field=array(
						'LanguageID',
						'Name' ,
						'Code',
						'Locale',
						'Image',
						'Directory',
						'Filename',
						'SortOrder'
					);
		$value=array(
						$LanguageID,
						$Name,
						$Code,
						$Locale,
						$Image,
						$Directory,
						$Filename,
						$SortOrder,
						$Status
					);
					
		$where="LanguageID = ".$LanguageID;
		$this->db->updateData("langguage",$field,$value,$where);
		}	
		
		public function deleteLanguege($data)
	{
		foreach($data as $LanguageID)
		{
			
			$where="FileID = ".$LanguageID;
			$ob->deleteData('language',$where);
		}		
	}
		
		
	}















?>