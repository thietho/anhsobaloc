<?php
	class ControllerCommonHeader extends Controller
	{
		public function index()
		{
			@$this->data['username'] = $this->session->data['username'];
			@$this->data['sitename'] = $this->session->data['sitename'];
			@$this->data['language'] = $this->getLanguageCBX();
			$this->id="header";
			$this->template="common/header.tpl";
			$this->render();
		}
		
		private function getLanguageCBX()
		{
			$this->load->model("common/control");
			$languages = $this->language->getLanguageList();
			$data = array();
			foreach($languages as $lang)
			{
				$data[$lang['code']] = $lang['name'];
			}
			
			$selectedvalue = $this->session->data['language'];
			return $this->model_common_control->getComboboxData("language", $data, $selectedvalue);
		}
		
	}
?>