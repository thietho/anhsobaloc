<?php
class ControllerSitebarDanhgianuochoa extends Controller
{
	public function index()
	{
		
		$this->load->model("core/comment");
		$this->load->model("core/media");
		
		$where =" ORDER BY `commentdate` DESC LIMIT 0 , 5";
		$this->data['comments'] = $this->model_core_comment->getList($where);
		foreach($this->data['comments'] as $key => $item)
		{
			$media = $this->model_core_media->getItem($item['mediaid']);
			
			$arr = $this->string->referSiteMapToArray($media['refersitemap']);
			$this->data['comments'][$key]['link'] = $this->document->createLink($arr[0],$media['alias']);
		}
		$this->id="content";
		$this->template="sitebar/danhgianuochoa.tpl";
		$this->render();
	}
}
?>