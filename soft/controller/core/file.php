<?php
class ControllerCoreFile extends Controller
{
	public function index()
	{
		$this->load->model("core/media");
		$this->load->model("core/sitemap");
		
		
		//$this->data['sitemap'] = $this->model_core_sitemap->getListSiteMapCheckBox($media);
		//$this->getList();
		$this->data['DIR_UPLOADPHOTO'] = HTTP_SERVER."index.php?route=common/uploadpreview";
		$this->data['DIR_UPLOADATTACHMENT'] = HTTP_SERVER."index.php?route=common/uploadattachment";
		$this->id='content';
		$this->template="core/file.tpl";
		if($_GET['dialog'] == '')
		{
			$this->template="core/file_list.tpl";
			$this->layout="layout/center";
		}
		$this->render();
	}

	public function getList()
	{
		$this->load->model("core/media");
		//Loc theo media
		$keyword = $this->request->get['keyword'];
		$location = $this->request->get['location'];
		$sitemap = trim($this->request->get['sitemap'],",");
		$list = "";
		
		
		
		$this->load->model("core/sitemap");
		$this->load->helper('image');
		$where="";
		if($list!="")
			$where.=" AND fileid in (".$list.")";
		if($keyword!="")
		{
			$where .= " AND filename like '%".$keyword."%'";	
		}
		$rows = $this->model_core_media->getFiles($where." ORDER BY `file`.`fileid` DESC");
		//Page
		$page = $this->request->get['page'];		
		$x=$page;		
		$limit = 28;
		$total = count($rows); 
		// work out the pager values 
		$this->data['pager']  = $this->pager->pageLayoutAjax($total, $limit, $page); 
		
		$pager  = $this->pager->getPagerData($total, $limit, $page); 
		$offset = $pager->offset; 
		$limit  = $pager->limit; 
		$page   = $pager->page;
		
		$this->data['output'] ="";
		for($i=$offset;$i < $offset + $limit && count($rows[$i])>0;$i++)
		{
			
			$this->data['files'][$i] = $rows[$i];
			$this->model_core_file->updateFileTemp($this->data['files'][$i]['fileid']);
			$this->data['files'][$i]['imagethumbnail'] = HelperImage::resizePNG($this->data['files'][$i]['filepath'], 130, 130);
			if(!$this->string->isImage($this->data['files'][$i]['extension']))
				$this->data['files'][$i]['imagethumbnail'] = DIR_IMAGE."icon/dinhkem.png";
			
		}
		
		$this->data['output'].=$this->data['pager'];
		$this->id='content';
		$this->template="core/file_grid.tpl";
		$this->render();
	}
	
	
	
	function getFile()
	{
		$width = (int)$this->request->get['width'];
		$height = (int)$this->request->get['height'];
		$this->load->model("core/file");
		$this->load->helper('image');
		$fileid = $this->request->get['fileid'];
		$file=$this->model_core_file->getFile($fileid);
		if($this->string->isImage($file['extension']))
			$file['imagepreview'] = HelperImage::resizePNG($file['filepath'], $width, $height);
		else
			$file['imagepreview'] = DIR_IMAGE."icon/dinhkem.png";
		$this->data['output'] = json_encode(array('file' => $file));
		$this->id='post';
		$this->template="common/output.tpl";
		$this->render();
	}
	public function delFile()
	{
		$this->load->model("core/file");
		$fileid = $this->request->get['fileid'];
		$this->model_core_file->deleteFile($fileid);
		
		$this->data['output'] = "true";
		$this->id='post';
		$this->template="common/output.tpl";
		$this->render();
	}
}
?>