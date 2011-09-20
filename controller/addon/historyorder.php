<?php
class ControllerAddonHistoryorder extends Controller
{
	private $error = array();
	public function index()
	{
		$this->document->breadcrumb .= "Lịch sử mua hàng";
		$this->getList();
		$this->id="content";
		$this->template="addon/historyorder.tpl";
		$this->render();
	}
	
	private function getList()
	{
		$this->load->model("core/user");
		$this->data['member'] = $this->model_core_user->getItem($this->member->getId());
		$this->load->model("addon/order");
		$where = "AND userid = '".$this->member->getId()."'";
		$this->data['orders'] = $this->model_addon_order->getList($where);
	}
}
?>