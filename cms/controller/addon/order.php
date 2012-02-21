<?php
class ControllerAddonOrder extends Controller
{
	private $error = array();
	
	public function index()
	{
		$this->load->language('addon/order');
		$this->data = array_merge($this->data, $this->language->getData());
		
		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model("addon/order");
		$this->getList();
	}
	
	public function view()
	{
		$this->load->language('addon/order');
		
		$this->data = array_merge($this->data, $this->language->getData());
		$this->load->model("addon/order");
		$this->load->model('core/media');
		$orderid = $this->request->get['orderid'];
		$this->load->helper('image');
		$this->data = $this->model_addon_order->getItem($orderid);
		if($this->data['order']['status']=='')
			$this->data['order']['text_active'] = "New";
		else
			$this->data['order']['text_active'] = "Checked";
		foreach($this->data['detail'] as $key => $item)
		{
			$parent = $this->model_core_media->getItem($item['mediaparent']);
			if(count($parent)==0)
			{
				$imagepreview = "<img width=100 src='".HelperImage::resizePNG($item['imagepath'], 180, 180)."' >";
				$this->data['detail'][$key]['imagepreview'] = $imagepreview;
				$this->data['detail'][$key]['title'] = $item['title'];
			}
			else
			{
				$imagepreview = "<img width=100 src='".HelperImage::resizePNG($parent['imagepath'], 180, 180)."' >";
				$this->data['detail'][$key]['imagepreview'] = $imagepreview;
				$this->data['detail'][$key]['title'] = $parent['title'] ." - ". $item['title'];
			}
		}
		
		$this->id='content';
		$this->template="addon/order_form.tpl";
		$this->layout="layout/center";
		$this->render();
	}
	
	private function getList() 
	{
		$this->data['insert'] = $this->url->http('core/user/insert');
		$this->data['delete'] = $this->url->http('core/user/delete');		

		$this->data['orders'] = array();
		$where = "";
		
		$datasearchlike['orderid'] = $this->request->get['orderid'];
		$datasearchlike['customername'] = $this->request->get['customername'];
		$datasearchlike['address'] = $this->request->get['address'];
		$datasearchlike['email'] = $this->request->get['email'];
		$datasearchlike['phone'] = $this->request->get['phone'];
		
		$datasearch['userid'] = $this->request->get['userid'];
		$datasearch['status'] = $this->request->get['status'];
		
		$arr = array();
		foreach($datasearchlike as $key => $item)
		{
			if($item !="")
				$arr[] = " AND " . $key ." like '%".$item."%'";
		}
		
		foreach($datasearch as $key => $item)
		{
			if($item !="")
				$arr[] = " AND " . $key ." = '".$item."'";
		}
		//Truong hop khac
		$datasearch['fromdate'] = $this->date->formatViewDate($this->request->get['fromdate']);
		$datasearch['todate'] = $this->date->formatViewDate($this->request->get['todate']);
		
		if($datasearch['fromdate'] != "")
			$arr[] = " AND orderdate >= '".$datasearch['fromdate']."'";
		
		if($datasearch['todate'] != "")
			$arr[] = " AND orderdate <= '".$datasearch['todate']."'";
		
		
		$where .= implode("",$arr);
		
		$where .= " ORDER BY  `order`.`orderdate` DESC ";
		$this->data['orders'] = $this->model_addon_order->getList($where);
		
		$this->data['refres']=$_SERVER['QUERY_STRING'];
		$this->id='content';
		$this->template="addon/order_list.tpl";
		$this->layout="layout/center";
		$this->render();
	}
	
	public function updatestatus()
	{
		$this->load->model("addon/order");
		$orderid = $this->request->get['orderid'];
		$status = $this->request->get['status'];
		//$this->data = $this->model_addon_order->getItem($orderid);
		$data['orderid'] = $orderid;
		$data['status'] = $status;
		$this->model_addon_order->updateStatus($data);
		$this->id="content";
		$this->template="common/output.tpl";
		$this->render();
	}
	
	public function delete()
	{
		$listid=$this->request->post['delete'];
		
		$this->load->model("addon/order");
		if(count($listid))
		{
			foreach($listid as $orderid)
			{
				$this->model_addon_order->delete($orderid);
			}
			$this->data['output'] = "Delete success";
		}
		$this->id="content";
		$this->template="common/output.tpl";
		$this->render();
	}
	
	public function getOrders() 
	{
		$col = $this->request->get['col'];
		$val = $this->request->get['val'];
		$operator = $this->request->get['operator'];
		if($operator == "")
			$operator = "equal";
		$this->load->model("addon/order");
		$where = "";
		switch($operator)
		{
			case "equal":
				$where = " AND ".$col." = '".$val."'";
				break;
			case "like":
				$where = " AND ".$col." like '%".$val."%'";
				break;
			case "other":
				$where = " AND ".$col." <> '".$val."'";
				break;
			case "in":
				$where = " AND ".$col." in  (".$val.")";
				break;
			
		}
		
		$where .= " ORDER BY  `order`.`orderdate` DESC ";
		$datas = $this->model_addon_order->getList($where);
		
		$this->data['output'] = json_encode(array('orders' => $datas));
		$this->id="content";
		$this->template="common/output.tpl";
		$this->render();
	}
}
?>