<?php
class ControllerCommonFooter extends Controller
{
	public function index()
	{
		
		$this->id="footer";
		$this->template="common/footer.tpl";
		$this->render();
	}
}
?>