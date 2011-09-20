<?php
class ControllerServicesMedia extends Controller
{	
	public function getMedias()
	{
		$col = $this->request->get['col'];
		$val = $this->request->get['val'];
		$operator = $this->request->get['operator'];
		$from = (int)@$this->request->get['from']; 
		$to = (int)@$this->request->get['to'];
		$operator = $this->request->get['operator'];
		if($operator == "")
			$operator = "equal";
		$this->load->model("core/media");
		$where = "";
		if($col !="")
		{
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
		}
		$datas = $this->model_core_media->getList($where,$from,$to);
		//print_r($datas);
		$this->data['output'] = json_encode(array('medias' => $datas));
		
		
		$this->id="media";
		$this->template="common/output.tpl";
		$this->render();
	}
}
?>