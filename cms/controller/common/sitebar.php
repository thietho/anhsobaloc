<?php
class ControllerCommonSitebar extends Controller
{
	function index()
	{	
		$this->getForm();
		$this->id='content';
		$this->template='common/sitebar.tpl';
		$this->layout="layout/center";
		$this->render();
	}
	
	private function getForm()
	{
		
		$this->load->model("core/media");
		$this->load->model("core/category");
		$this->data['item']['mediaid'] = "setting";
		
		
		$this->data['nhanhieu'] = array();
		$this->model_core_category->getTree("nhanhieu",$this->data['nhanhieu']);
		unset($this->data['nhanhieu'][0]);
		$nuochoanu = $this->model_core_media->getInformation($this->data['item']['mediaid'], 'nuochoanu');
		$nuochoanam = $this->model_core_media->getInformation($this->data['item']['mediaid'], 'nuochoanam');
		
		$this->data['menu']['nuochoanu']= $this->string->referSiteMapToArray($nuochoanu);
		$this->data['menu']['nuochoanam']= $this->string->referSiteMapToArray($nuochoanam);
		
		$nuochoanu_sitebar = $this->model_core_media->getInformation($this->data['item']['mediaid'], 'nuochoanu-sitebar');
		$nuochoanam_sitebar = $this->model_core_media->getInformation($this->data['item']['mediaid'], 'nuochoanam-sitebar');
		
		$this->data['sitebar']['nuochoanu'] = $this->string->referSiteMapToArray($nuochoanu_sitebar);
		$this->data['sitebar']['nuochoanam']= $this->string->referSiteMapToArray($nuochoanam_sitebar);	
	}
	
	public function save()
	{
		$data = $this->request->post;
		
		
		$this->load->model("core/media");
		//Save setting
		
		
		$this->model_core_media->saveInformation($data['mediaid'],"nuochoanu-sitebar",$this->string->arrayToString($data['nuochoanu']));
		$this->model_core_media->saveInformation($data['mediaid'],"nuochoanam-sitebar",$this->string->arrayToString($data['nuochoanam']));
			
		$this->data['output'] = "true";
		
		$this->id='content';
		$this->template='common/output.tpl';
		$this->render();
	}
}
?>