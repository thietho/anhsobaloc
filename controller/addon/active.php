<?php
class ControllerAddonActive extends Controller
{
	private $error = array();
	public function index()
	{
		$this->document->breadcrumb .= "Kích hoạt tài khoảng";
		$this->id="content";
		$this->template="addon/active.tpl";
		$this->render();
	}
	
	public function active()
	{
		$data = $this->request->get;
		if($this->validateForm($data))
		{
			$this->load->model("core/user");
			$activecode = $this->model_core_user->getInformation($data['username'], "activecode");
			if($data['activecode'] == $activecode)
			{
				//Kich hoat tai khoang
				$user['userid'] = $data['username'];
				$user['status'] = "active";
				$this->model_core_user->updatestatus($user);
				$this->data['output'] = "true";
				$this->model_core_user->saveInformation($data['username'], "activecode", "");
			}
			else
			{
				$this->data['output'] = "Mã kích hoạt không đúng";
			}
			
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
		
		
    	if(trim($data['username']) == "")
		{
      		$this->error['username'] = "Bạn chưa nhập tên đăng nhập";
    	}
		
		if(trim($data['activecode']) =="")
		{
      		$this->error['activecode'] = "Bạn chưa nhập mã kích hoạt";
    	}
		else
		{
			$this->load->model("core/user");
			$activecode = $this->model_core_user->getInformation($data['username'], "activecode");
			if($activecode == "")
				$this->error['activecode'] = "Tài khoảng của bạn đã kích hoạt rồi";
		}
		
		if (count($this->error)==0) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
	}
}
?>