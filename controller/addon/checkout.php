<?php
class ControllerAddonCheckout extends Controller
{
	private $error = array();
	public function index()
	{
		$this->document->breadcrumb .= $this->data['text_orderinformation'];
		$this->getList();
		$this->getMemberInfor();
		$this->id="content";
		$this->template="addon/checkout.tpl";
		$this->render();
	}
	
	public function getList()
	{
		$this->data['medias'] =array();
		if(isset($_SESSION['cart']))
		{
			$this->data['medias'] = $_SESSION['cart'];
		}
		
	}
	
	private function getMemberInfor()
	{
		$this->load->model("core/user");
		$this->data['member'] = $this->model_core_user->getItem($this->member->getId());
		if(count($this->data['member']))
			$this->data['readonly'] = 'readonly="readonly"';
	}
	
	public function checkout()
	{
		$data = $this->request->post;
		if($this->validateForm($data))
		{
			$this->load->model("addon/order");
			//Luu thong tin don hang
			$orderid = $this->model_addon_order->insert($data);
			//Luu chi tiet don hang
			foreach($_SESSION['cart'] as $item)
			{
				$detail['orderid'] = $orderid;
				$detail['mediaid'] = $item['mediaid'];
				$detail['quantity'] = $item['qty'];
				$detail['price'] = $item['price'];
				$detail['discount'] = 0;
				$this->model_addon_order->saveOrderProduct($detail);
			}
			unset($_SESSION['cart']);
			$this->data['output'] = "true-".$orderid;
		}
		else
		{
			foreach($this->error as $item)
			{
				$this->data['output'] .= $item."<br>";
			}
		}
		$this->id='content';
		$this->template='common/output.tpl';
		$this->render();
	}
	
	private function validateForm($data)
	{
		
		if(trim($data['customername']) =="")
		{
      		$this->error['customername'] = $this->data['war_fullnamenotnull'];
    	}
		
		if ($data['email'] == "") 
		{
      		$this->error['email'] = $this->data['war_emailnotnull'];
    	}
		else
		{
			if(!$this->validation->_checkEmail($data['email']))
			{
				$this->error['email'] = $this->data['war_emailnotformate'];
			}
		}

		
		
		if (count($this->error)==0) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
	}
}
?>