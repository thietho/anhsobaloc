<?php
class ControllerCommonCountry extends Controller
{
	public function index()
	{	
		
		$this->id="country";
		$this->template="common/output.tpl";
		$this->render();
	}
	
	public function getzonescb()
	{
		$this->load->model("core/country");
		$countrycode=$this->request->get['countrycode'];
		$selectzone=$this->request->get['selectzone'];
		$zones=$this->model_core_country->getZonesByCode($countrycode);
		$this->data['output']="";
		foreach($zones as $item)
		{
			$sel="";
			if($selectzone == $item['zoneid'])
				$sel='selected="selected"';
			$this->data['output'].="<option value='".$item['zoneid']."' ".$sel.">".$item['zonename']."</option>";
		}
		$this->id="country";
		$this->template="common/output.tpl";
		$this->render();
	}
}
?>