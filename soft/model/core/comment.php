<?php
class ModelCoreComment extends Model
{ 
	
	public function getItem($id, $where="")
	{
		$query = $this->db->query("Select `comment`.* 
									from `comment` 
									where id ='".$id."' ".$where);
		return $query->row;
	}
	
	public function getList($where="",$from=0,$to=0)
	{
		
		$sql = "Select `comment`.* 
									from `comment` 
									where status not like 'delete' " . $where ;
		if($to > 0)
		{
			$sql .= " Limit ".$from.",".$to;
		}
		
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	
	
	protected function getnextid()
	{
		$id=$this->db->getNextId("comment","id");
		return $id;
	}
	
	
	
	public function insert($data)
	{
		$id=$this->getnextid();
		$fullname=$this->db->escape(@$data['fullname']);
		$email=$this->db->escape(@$data['email']);
		$level=$this->db->escape(@$data['level']);
		$description=$this->db->escape(@$data['description']);
		$commentdate = $this->date->getToday();
		$mediaid=$this->db->escape(@$data['mediaid']);
		$status="new";
		$userid=$this->db->escape(@$data['userid']);
		
		$field=array(
						'id',
						'fullname',
						'email',
						'level',
						'description',
						'commentdate',
						'mediaid',
						'status',
						'userid'
					);
		$value=array(
						$id,
						$fullname,
						$email,
						$level,
						$description,
						$commentdate,
						$mediaid,
						$status,
						$userid
					);
		
		$this->db->insertData("comment",$field,$value);
		
		return $id;
	}
	
	public function updateCol($id,$col,$val)
	{
		$id= $this->db->escape(@$id);
		$col= $this->db->escape(@$col);
		$val= $this->db->escape(@$val);
		
		
		
		$field=array(
						$col
					);
		$value=array(
						$val
					);
		
		$where="id = '".$id."'";
		$this->db->updateData("comment",$field,$value,$where);
		
		
		
		return true;
	}
	
	public function delete($id)
	{
		$id= $this->db->escape(@$id);
		$where="id = '".$id."'";
		$this->db->deleteData("comment",$where);
			
		
	}
		
}
?>