<?php
class ModelCoreCategory extends Model
{ 
	private $root = "category";
	function __construct() 
	{
		
		$data = $this->getItem($this->root);
		if(count($data)==0)
		{
			$data['categoryid'] = $this->root;
			$data['categoryname'] = "Category";
			$data['parent'] = "";
			$data['position'] = 0;
			$this->insert($data);
		}
   	}
	
	public function getItem($categoryid, $where="")
	{
		$query = $this->db->query("Select `category`.* 
									from `category` 
									where categoryid ='".$categoryid."' ".$where);
		return $query->row;
	}
	
	public function getList($where="", $from=0, $to=0,$order = " Order by position")
	{
		
		$sql = "Select `category`.* 
									from `category` 
									where 1=1 " . $where . $order;
		if($to > 0)
		{
			$sql .= " Limit ".$from.",".$to;
		}
		
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	public function getChild($categoryid,$order = " Order by position")
	{
		$where = " AND parent = '".$categoryid."'";
		return $this->getList($where);
	}
	
	protected function getnextid($prefix)
	{
		$id=$this->db->getNextIdVarChar("category","categoryid",$prefix);
		return $id;
	}
	
	public function nextposition($parent)
	{
		$sql = "Select max(position) as max From category where parent='".$parent."'";
		$query = $this->db->query($sql);
		return $query->rows[0]['max'] +1 ;
	}
	
	public function insert($data)
	{
		$categoryid= $this->db->escape(@$data['categoryid']);
		$categoryname=$this->db->escape(@$data['categoryname']);
		$parent=$this->db->escape(@$data['parent']);
		$position= (int)@$this->nextposition($parent);
		
		
		
		$field=array(
						'categoryid',
						'categoryname',
						'parent',
						'position'
					);
		$value=array(
						$categoryid,
						$categoryname,
						$parent,
						$position
					);
		$this->db->insertData("category",$field,$value);
		
		return $categoryid;
	}
	
	public function update($data)
	{
		$categoryid= $this->db->escape(@$data['categoryid']);
		$categoryname=$this->db->escape(@$data['categoryname']);
		$parent=$this->db->escape(@$data['parent']);
		
		
		
		
		$field=array(
						'categoryid',
						'categoryname',
						'parent'
					);
		$value=array(
						$categoryid,
						$categoryname,
						$parent
					);
		
		$where="categoryid = '".$categoryid."'";
		$this->db->updateData("category",$field,$value,$where);
		
		
		
		return true;
	}
	
	public function updateposition($data)
	{
		$categoryid= $this->db->escape(@$data['categoryid']);
		$position= (int)@$data['position'];
		
		$field=array(
						
						'position'
					);
		$value=array(
		
						$position
					);
		
		$where="categoryid = '".$categoryid."'";
		$this->db->updateData("category",$field,$value,$where);
		
		
		
		return true;
	}
	
	public function save($data)
	{
		$item = $this->getItem($data['categoryid']);
		if(count($item) == 0)
		{
			$this->insert($data);
		}
		else
		{
			$this->update($data);
		}
	}
	
	public function delete($categoryid)
	{
		$data = $this->getChild($categoryid);
		if(count($data)==0)
		{
			$where="categoryid = '".$categoryid."'";
			$this->db->deleteData("category",$where);
			
		}
	}
	
	public function deletedatas($data)
	{
		if(count($data)>0)
		{
			foreach($data as $item)	
				$this->delete($item);
		}
	}
	
	//Tree
	function getTree($id, &$data, $level=-1, $path="", $parentpath="")
	{
		$arr=$this->getItem($id);
		
		$rows = $this->getChild($id);
		
		$arr['countchild'] = count(rows);
		
		if($arr['parent'] != "") 
			$parentpath .= "-".$arr['parent'];
		
		if($id!="" )
		{
			$level += 1;
			$path .= "-".$id;
			
			$arr['level'] = $level;
			$arr['path'] = $path;
			$arr['parentpath'] = $parentpath;
			
			array_push($data,$arr);
		}
		
		
		if(count($rows))
			foreach($rows as $row)
			{
				$this->getTree($row['categoryid'], $data, $level, $path, $parentpath);
			}
	}
	
	public function getDanhMucPhanLoai()
	{
		$data = array();
		$this->getTree($this->root,$data);
		foreach($data as $key =>$item)
		{
			$data[$key]['parentpath'] = str_replace("-".$this->root,"",$data[$key]['parentpath']);
			$data[$key]['path'] = str_replace("-".$this->root,"",$data[$key]['path']);
		}
		return $data;
	}
}
?>