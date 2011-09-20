<?php
class ControllerCommonValidate extends Controller
{	
	public function isemail()
	{	
		$str=$this->request->get['email'];
		if ($this->validation->_checkEmail($str) == false )
			$this->data['output']="Sai email";
		$this->id="content";
		$this->template="common/output.tpl";
		$this->render();
	}
}
?>