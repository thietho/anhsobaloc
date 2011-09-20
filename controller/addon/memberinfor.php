<?php
class ControllerAddonMemberinfor extends Controller
{
	private $error = array();
	public function index()
	{
		$this->document->breadcrumb .= "Thông tin cá nhân";
		$this->data['DIR_UPLOADPHOTO'] = HTTP_SERVER."index.php?route=common/uploadpreview";
		$this->getMemberInfor();
		$this->id="content";
		$this->template="addon/memberinfor.tpl";
		$this->render();
	}
	
	private function getMemberInfor()
	{
		$this->load->model("core/user");
		$this->load->helper('image');
		$this->data['member'] = $this->model_core_user->getItem($this->member->getId());
		$this->data['member']['imagethumbnail']=HelperImage::resizePNG($this->data['member']['imagepath'], 200, 200);
	}
	
	public function saveAvatar()
	{
		$data = $this->request->post;
		$this->load->model("core/user");
		$this->model_core_user->updatecol($data['userid'],"imageid",$data['imageid']);
		$this->model_core_user->updatecol($data['userid'],"imagepath",$data['imagepath']);
		$this->data['output'] = "true";
		$this->id='content';
		$this->template='common/output.tpl';
		$this->render();
	}
	
	public function saveInfor()
	{
		$data = $this->request->post;
		$this->load->model("core/user");
		$this->model_core_user->updatecol($data['userid'],$data['colname'],$data['value']);
		
		$this->data['output'] = "true";
		$this->id='content';
		$this->template='common/output.tpl';
		$this->render();
	}
	
	public function saveDate()
	{
		$data = $this->request->post;
		$this->load->model("core/user");
		$data['value'] = $this->date->formatViewDate($data['value']);
		$this->model_core_user->updatecol($data['userid'],$data['colname'],$data['value']);
		
		$this->data['output'] = "true";
		$this->id='content';
		$this->template='common/output.tpl';
		$this->render();
	}
}
?>