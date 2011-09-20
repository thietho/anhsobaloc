<?php
	class ControllerCommonUploadattachment extends Controller
	{
		function index()
		{	
			$this->load->helper('image');
			$this->load->model('core/file');
			//$this->data['output'] = json_encode(array('files' => $_FILES));
			if($_FILES['image2']['name'] != "")
			{
				$filepath = "upload/";
				$data['image'] = $this->model_core_file->saveFile($_FILES['image2'],$filepath,"any","temp");
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
					if($this->string->isImage($file['extension']))
					{
						$arr = array(
							'error' => 'none',
							'imageid' => $file['fileid'],
							'imagename' => $file['filename'],
							'imagepath' => $file['filepath'],
							'imagethumbnail' => HelperImage::resizePNG($file['filepath'], 50, 50)
						);
					}
					else
					{
						$arr = array(
							'error' => 'none',
							'imageid' => $file['fileid'],
							'imagename' => $file['filename'],
							'imagepath' => $file['filepath'],
							'imagethumbnail' => DIR_IMAGE."icon/dinhkem.png"
						);
					}
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