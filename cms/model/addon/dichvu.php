<?php
class ModelAddonDichvu extends Model 
{
	private $columns = array(
								'dichvuid',
								'tendichvu',
								'giamatdinh',
								'trangthai'
							);
	public function getList($where = "")
	{
		$sql = "Select `qlb_dichvu`.* from `qlb_dichvu` where 1=1 ".$where;
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getItem($dichvuid)
	{
		$sql = "Select * from `qlb_dichvu` where dichvuid = '".$dichvuid."'";
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	
	public function insert($data)
	{
		$data['giamatdinh']=$this->string->toNumber($data['giamatdinh']);
		$data['trangthai']="active";
		foreach($this->columns as $val)
		{
			if($val!="")
			{
				$field[] = $val;
				$value[] = $this->db->escape($data[$val]);	
			}
		}
		
		$getLastId = $this->db->insertData("qlb_dichvu",$field,$value);
				
		return $getLastId;
	}
	
	
	public function update($data)
	{		
		$data['giamatdinh']=$this->string->toNumber($data['giamatdinh']);
		foreach($this->columns as $val)
		{
			if($val!="")
			{
				$field[] = $val;
				$value[] = $this->db->escape($data[$val]);	
			}
		}
		
		$where="dichvuid = '".$data['dichvuid']."'";
		$this->db->updateData("qlb_dichvu",$field,$value,$where);
	}	
		
	public function updateCol($dichvuid,$col,$val)
	{
		$dichvuid=$this->db->escape(@$dichvuid);
		$col=$this->db->escape(@$col);
		$val=$this->db->escape(@$val);
		$field=array(
						$col
					);
		$value=array(
						$val
					);
					
		$where="dichvuid = '".$dichvuid."'";
		$this->db->updateData("qlb_dichvu",$field,$value,$where);
	}
	
	//Xóa dich vu
	public function delete($dichvuid)
	{
		$dichvuid=$this->db->escape(@$dichvuid);
		
		$this->updateCol($dichvuid,"trangthai",'deleted');
		
	}

}
?>