<?php
class ModelAddonOrder extends Model
{ 
	public function getItem($orderid, $where="")
	{
		$orderid=$this->db->escape(@$orderid);
		$query = $this->db->query("Select `order`.* 
									from `order` 
									where orderid ='".$orderid."' ".$where);
		$data['order'] = $query->row;
		$sql = "Select `order_product`.*,mediaparent,title, imagepath
									from `order_product` , media
									where order_product.mediaid = media.mediaid and orderid = '".$orderid."'";
		$query = $this->db->query($sql);
		$data['detail']=$query->rows;
		return $data;
	}
	
	public function getList($where="", $from=0, $to=5)
	{
		
		$sql = "Select `order`.* 
									from `order` 
									where 1=1 " . $where;
		if($to > 0)
		{
			$sql .= " Limit ".$from.",".$to;
		}
		
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	private function nextID($prefix)
	{
		return $this->db->getNextIdVarChar("order","orderid",$prefix);	
	}
	
	public function insert($data)
	{
		$orderid= $this->nextID("order".time());
		$orderdate=$this->date->getToday();
		$userid=$this->db->escape(@$data['userid']);
		$customername=$this->db->escape(@$data['customername']);
		$address=$this->db->escape(@$data['address']);
		$email=$this->db->escape(@$data['email']);
		$phone=$this->db->escape(@$data['phone']);
		$status="new";
		$comment=$this->db->escape(@$data['comment']);
		
		
		$field=array(
						'orderid',
						'orderdate',
						'userid',
						'customername',
						
						'address',
						'email',
						'phone',
						'status',
						'comment'
					);
		$value=array(
						$orderid,
						$orderdate,
						$userid,
						$customername,
						
						$address,
						$email,
						$phone,
						$status,
						$comment
					);
		$this->db->insertData("order",$field,$value);
		return $orderid;
	}
	
	public function update($data)
	{
		$orderid = $this->db->escape(@$data['orderid']);
		
		$userid=$this->db->escape(@$data['userid']);
		$customername=$this->db->escape(@$data['customername']);
		$address=$this->db->escape(@$data['address']);
		$email=$this->db->escape(@$data['email']);
		$phone=$this->db->escape(@$data['phone']);
		
		$comment=$this->db->escape(@$data['comment']);
		$field=array(
						
						'userid',
						'customername',
						'userid',
						'address',
						'email',
						'phone',
						
						'comment'
					);
		$value=array(
						
						$userid,
						$customername,
						$userid,
						$address,
						$email,
						$phone,
						
						$comment
					);
		
		$where="orderid = '".$orderid."'";
		$this->db->updateData('order',$field,$value,$where);
		return true;
	}
	
	public function updateStatus($data)
	{
		$orderid = $this->db->escape(@$data['orderid']);
		$status=$this->db->escape(@$data['status']);
		$field=array(
						
						'status'
						
					);
		$value=array(
						
						$status
					);
		
		$where="orderid = '".$orderid."'";
		$this->db->updateData('order',$field,$value,$where);
		return true;
	}
	
	public function delete($orderid)
	{
		$status="delete";
		$statusdate = $this->date->getToday();
		$statusby=$this->user->getId();
		
		if($orderid != "")
		{
			$sql = "Update `order` set status='".$status."' where orderid = '".$orderid."'";
			$this->db->query($sql);
		}
	}
	
	//order product
	public function getOrderProduct($orderid,$mediaid)
	{
		$orderid=$this->db->escape(@$orderid);
		$mediaid=$this->db->escape(@$mediaid);
		$sql = "Select `order_product`.* 
									from `order_product` 
									where orderid = '".$orderid."' And mediaid='".$mediaid."'";
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	public function saveOrderProduct($data)
	{
		$orderid=$this->db->escape(@$data['orderid']);
		$mediaid=$this->db->escape(@$data['mediaid']);
		$quantity=$this->db->escape(@$data['quantity']);
		$price=$this->db->escape(@$data['price']);
		$discount=$this->db->escape(@$data['discount']);
		$subtotal=$quantity*$price*(1 - $discount/100);
		$field=array(
						'orderid',
						'mediaid',
						'quantity',
						'price',
						'discount',
						'subtotal'
					);
		$value=array(
						$orderid,
						$mediaid,
						$quantity,
						$price,
						$discount,
						$subtotal
					);
		$arr=$this->getOrderProduct($orderid,$mediaid);
		if(count($arr)==0)
		{
			$this->db->insertData("order_product",$field,$value);
		}
		else
		{
			$where="orderid = '".$orderid."' And mediaid='".$mediaid."'";
			$this->db->updateData('order_product',$field,$value,$where);
		}
	}
}
?>