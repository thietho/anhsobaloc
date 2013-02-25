<?php
	class ControllerCommonUploadpreview extends Controller
	{
		function index()
		{	
			$this->load->helper('image');
			$this->load->model('core/file');
			//$this->data['output'] = json_encode(array('files' => $_FILES));
			if($_FILES['image2']['name'] != "")
			{
				$filepath = "upload/";
				$data['image'] = $this->model_core_file->saveFile($_FILES['image2'],$filepath,"image","temp");
				if($data['image']['fileid'] == '')
				{
					$arr = array(
						'error' => 'Your upload image is wrong or size of this image more than 2MB!'
					);
					$this->data['output'] = json_encode(array('files' => $arr));
				}
				else
				{
					$file = $this->model_core_file->getFile($data['image']['fileid']);
					$arr = array(
						'error' => 'none',
						'imageid' => $file['fileid'],
						'imagename' => $file['filename'],
						'imagepath' => $file['filepath'],
						'imagethumbnail' => HelperImage::resizePNG($file['filepath'], 200, 200)
					);
					sleep(1);
					$this->data['output'] = json_encode(array('files' => $arr));
				}
			}
			$this->id="uploadpreview";
			$this->template="common/output.tpl";
			$this->render();
		}
		
	}
?>