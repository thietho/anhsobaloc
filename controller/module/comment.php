<?php
class ControllerModuleComment extends Controller
{
	private $error = array();
	public function index($mediaid)
	{
		$this->data['mediaid'] = $mediaid;
		$this->id="information";
		$this->template="module/comment.tpl";
		$this->render();
	}
	
	public function sendComment()
	{
		$data = $this->request->post;
		if($this->validateForm($data))
		{
			$this->load->model("core/comment");
			$data['userid'] = $this->member->getUserName();
			$this->model_core_comment->insert($data);
			
			//Gui thong bao vo mail
			/*$mail['from'] = "support@ancaratperfume.com";
			$mail['FromName'] = "Ancaratperfume";
			$mail['to'] = $data['email'];
			$mail['name'] = $data['fullname'];
			$mail['subject'] =  "Thong bao nhan tin";
			$mail['body'] = "Ban da dang ky nhan tin tu ancaratperfume.com thanh cong";
			$this->mailsmtp->sendMail($mail);*/
			
			$this->data['output'] = "true";
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
		if(trim($data['fullname']) == "")
		{
      		$this->error['fullname'] = "Bạn chưa nhập họ tên";
    	}
		
		if(trim($data['level']) =="")
		{
      		$this->error['level'] = "Bạn chưa đánh giá";
    	}
		
		if ($data['email'] == "") 
		{
      		$this->error['email'] = "Bạn chưa nhập email";
    	}
		else
		{
			if(!$this->validation->_checkEmail($data['email']))
			{
				$this->error['email'] = "Email không đúng dịnh dạng";
			}
			
		}
		
		if(trim($data['description']) =="")
		{
      		$this->error['description'] = "Bạn chưa nhập nội dung";
    	}
		
		if (count($this->error)==0) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
	}
	
	public function getList($where = "",$template = array())
	{
		$this->load->model("core/comment");
		$where.=" ORDER BY `commentdate` DESC";
		$this->data['comments'] = $this->model_core_comment->getList($where);
		$this->data['title'] = $template['title'];
		$this->id="content";
		$this->template=$template['template'];
		$this->render();
	}
}
?>