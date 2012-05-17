<?php
class ModelAddonBiennhan extends Model 
{
	private $columns = array(
								'biennhanid',
								'sobiennhan',
								'ngaylap',
								'ngayhen',
								'createdate',
								'nguoilap',
								'khachhangid',
								'tenkhachhang',
								'sodienthoai',
								'email',
								'diachi',
								'tongcong',
								'tongtien',
								'giamgia',
								'phantramgiamgia',
								'tamung',
								'ghichu',
								'tinhtrang',
								'trangthai'
							);
	public function getList($where = "")
	{
		$sql = "Select `qlb_biennhan`.* from `qlb_biennhan` where 1=1 ".$where;
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getItem($biennhanid)
	{
		$sql = "Select * from `qlb_biennhan` where biennhanid = '".$biennhanid."'";
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	private function creatSoBienNhan($prefix)
	{
		
		return $this->db->getNextIdVarChar("qlb_biennhan","sobiennhan",$prefix);
	}
	
	public function insert($data)
	{
		$now = $this->date->getToday();
		$year = $this->date->getYear($now);
		$month = $this->date->getMonth($now);
		$data['sobiennhan']=$this->creatSoBienNhan($year.$month);
		$data['nguoilap'] = $this->user->getId();
		$data['ngaylap']=$this->db->escape(@$this->date->formatViewDate($data['ngaylap']));
		$data['ngayhen']=$this->db->escape(@$this->date->formatViewDate($data['ngayhen']));
		$data['createdate'] = $this->date->getToday();
		$data['tongtien']=$this->db->escape(@$this->string->toNumber($data['tongtien']));
		$data['giamgia']=$this->db->escape(@$this->string->toNumber($data['giamgia']));
		$data['phantramgiamgia']=$this->db->escape(@$this->string->toNumber($data['phantramgiamgia']));
		$data['tamung']=$this->db->escape(@$this->string->toNumber($data['tamung']));
		$data['tinhtrang']='new';
		$data['trangthai']='active';
		foreach($this->columns as $val)
		{			
			$field[] = $val;
			$value[] = $this->db->escape($data[$val]);	
			
		}
		$getLastId = $this->db->insertData("qlb_biennhan",$field,$value);
				
		return $getLastId;
	}
	
	
	public function update($data)
	{		
		
		$data['ngaylap']=$this->db->escape(@$this->date->formatViewDate($data['ngaylap']));
		$data['ngayhen']=$this->db->escape(@$this->date->formatViewDate($data['ngayhen']));
		$data['tongtien']=$this->db->escape(@$this->string->toNumber($data['tongtien']));
		$data['giamgia']=$this->db->escape(@$this->string->toNumber($data['giamgia']));
		$data['phantramgiamgia']=$this->db->escape(@$this->string->toNumber($data['phantramgiamgia']));
		$data['tamung']=$this->db->escape(@$this->string->toNumber($data['tamung']));
		
		foreach($this->columns as $val)
		{
	
			if($data[$val]!="")
			{
				$field[] = $val;
				$value[] = $this->db->escape($data[$val]);	
			}
		}
					
		$where="biennhanid = '".$data['biennhanid']."'";
		$this->db->updateData("qlb_biennhan",$field,$value,$where);
	}	
		
	public function updateCol($biennhanid,$col,$val)
	{
		$biennhanid=$this->db->escape(@$biennhanid);
		$col=$this->db->escape(@$col);
		$val=$this->db->escape(@$val);
		$field=array(
						$col
					);
		$value=array(
						$val
					);
					
		$where="biennhanid = '".$biennhanid."'";
		$this->db->updateData("qlb_biennhan",$field,$value,$where);
	}
	
	//Xóa nhân viên
	public function delete($biennhanid)
	{
		$biennhanid=$this->db->escape(@$biennhanid);
		
		$this->updateCol($biennhanid,"trangthai",'deleted');
		
	}
	//chi tiet bien nhan
	
	public function getBienNhanChiTiet($id)
	{
		$sql = "Select * 
						from `qlb_biennhanchitiet` 
						where id ='".$id."'";
		$query = $this->db->query($sql);
		return $query->row;	
	}
	
	public function getBienNhanChiTietList($where)
	{
		$sql = "Select `qlb_biennhanchitiet`.* 
									from `qlb_biennhanchitiet` 
									where 1=1 " . $where ;
		
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	public function saveBienNhanChiTiet($data)
	{
		$data['sotien']=$this->db->escape(@$this->string->toNumber($data['sotien']));
		$data['ngaylap']=$this->db->escape(@$this->date->formatViewDate($data['ngaylap']));
		
		foreach($data as $key => $val)
		{
			if($val!="")
			{
				$field[] = $key;
				$value[] = $this->db->escape($val);	
			}
		}		
				
		
		
		if((int)$data['id']==0)
		{
			
			$this->db->insertData("qlb_biennhanchitiet",$field,$value);
			$id = $this->db->getLastId();
		}
		else
		{			
			$where="id = '".$data['id']."'";
			$this->db->updateData('qlb_biennhanchitiet',$field,$value,$where);
		}
		return $id;
	}
	
	public function updateBienNhanChiTiet($id,$col,$val)
	{
		$id = $this->db->escape(@$id);
		$col=$this->db->escape(@$col);
		$val=$this->db->escape(@$val);
		
		$field=array(
						$col
						
					);
		$value=array(
						$val
					);
		
		$where="id = '".$id."'";
		$this->db->updateData('qlb_biennhanchitiet',$field,$value,$where);
	}
		
	public function deleteBienNhanChiTiet($id)
	{
		$id = $this->db->escape(@$id);		
		
		$where="id = '".$id."'";
		$this->db->deleteData('qlb_biennhanchitiet',$where);
	}
	//Thu chi
	public function getDatra($biennhanid)
	{
		$sql = "SELECT sum(quidoi) as datra FROM `ben_thuchi` WHERE taikhoanthuchi = 'thutienbienlai' AND nguongoc = '".$biennhanid."'";
		$query = $this->db->query($sql);
		return $query->row['datra'];
	}
}
?>