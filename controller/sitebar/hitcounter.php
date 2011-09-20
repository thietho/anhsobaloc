<?php
class ControllerSitebarHitcounter extends Controller
{
	public function index()
	{
		$this->getHitCounter();
		$this->id="content";
		$this->template="sitebar/hitcounter.tpl";
		$this->render();
	}
	
	public function getHitCounter()
	{
		$this->load->model("common/counter");
		// Kiểm tra xem counter có tồn tại hay chưa
		// Nếu chưa sẽ tạo counter trong database = 0
		$row=$this->model_common_counter->getCounter();
		$counter=$row[0]['fieldvalue'];
		if ( count($row) == 0 )
		{
			$counter='0';
			$this->model_common_counter->createCounter();
		}
		
		// Nếu tồn tại sẽ cập nhật counter và chạy trang intro
		if( count($row) != 0 && !isset($this->session->data['counter']) )
		{
			$counter=(int)$row[0]['fieldvalue']+1;
			$counter=(string)$counter;
			$this->session->set('counter','1');
			$this->model_common_counter->updateCounter($counter);
			$row=$this->model_common_counter->getCounter();
			$counter=$row[0]['fieldvalue'];
			//$this->response->redirect('intro.php');
		}
		$this->data['counterHit']=$counter;
	}
}
?>