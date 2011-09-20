<?php
class ModelCoreFiletype extends Model 
{ 
	public function getFiletype($id)
	{
		$query = $this->db->query("Select * from `filetype` where FileTypeID ='".$id."'");
		return $query->rows;
	}
	
	public function getFiletypes()
	{
		$query = $this->db->query("Select * from `filetype`");
		return $query->rows;
	}
	
	public function getFiletypeDescriptions($id, $langid)
	{
		$query = $this->db->query("Select * from `filetype_description` where FileTypeID ='".$id."' and LanguageID=".$langid);
		return $query->row;
	}	
}
?>