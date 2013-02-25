<?php
class ModelBenThuchi extends Model 
{
	private $columns = array(
								'maphieu',
								'sophieu',
								'loaithuchi',
								'ngaylap',
								'taikhoanthuchi',
								'chungtulienquan',
								'makhachhang',
								'tenkhachhang',
								'gioitinh',
								'diachi',
								'cmnd',
								'email',
								'dienthoai',
								'fax',
								'masothue',
								'loaikhachhang',
								'manguoilapphieu',
								'tennguoilapphieu',
								'sotien',
								'donvi',
								'tigia',
								'quidoi',
								'hinhthucthanhtoan',
								'lydo',
								'nguongoc'
							);
	public function getList($where = "")
	{
		$sql = "Select `ben_thuchi`.* from `ben_thuchi` where 1=1 ".$where;
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getItem($maphieu)
	{
		$sql = "Select * from `ben_thuchi` where maphieu = '".$maphieu."'";
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	private function createSoPhieu($prefix)
	{
		//return $this->db->getNextIdVarChar("ben_thuchi","sophieu",$prefix);	
		
		$mun = $this->db->getNextIdVarCharNumber("ben_thuchi","sophieu",$prefix);
		return $this->string->numberToString($mun,3).$prefix;
	}
	
	public function insert($data)
	{
		if($data['prefix'] == "")
			$data['sophieu']=$this->db->escape(@$data['sophieu']);
		else
			$data['sophieu']=$this->createSoPhieu($data['prefix']);
			
		$data['ngaylap'] = $this->date->getToday();
		$data['sotien']=$this->string->toNumber($data['sotien']);
		
		foreach($this->columns as $val)
		{
			if($val!="")
			{
				$field[] = $val;
				$value[] = $this->db->escape($data[$val]);				
			}
		}
		
		$getLastId = $this->db->insertData("ben_thuchi",$field,$value);
				
		return $getLastId;
	}
	
	
	public function update($data)
	{		
		$data['sotien']=$this->string->toNumber($data['sotien']);
		foreach($this->columns as $val)
		{
			if($val!="")
			{
				$field[] = $val;
				$value[] = $this->db->escape($data[$val]);	
			}
		}
		
		$where="maphieu = '".$data['maphieu']."'";
		$this->db->updateData("ben_thuchi",$field,$value,$where);
	}	
		
	public function updateCol($maphieu,$col,$val)
	{
		$maphieu=$this->db->escape(@$maphieu);
		$col=$this->db->escape(@$col);
		$val=$this->db->escape(@$val);
		$field=array(
						$col
					);
		$value=array(
						$val
					);
					
		$where="maphieu = '".$maphieu."'";
		$this->db->updateData("ben_thuchi",$field,$value,$where);
	}
	
	//Xóa dich vu
	public function delete($maphieu)
	{
		$maphieu = $this->db->escape(@$maphieu);		
		
		$where="maphieu = '".$maphieu."'";
		$this->db->deleteData('ben_thuchi',$where);
		
	}

}
?>