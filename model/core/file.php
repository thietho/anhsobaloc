<?php
class ModelCoreFile extends Model 
{ 
	public function getFile($id)
	{
		$id=(int)@$id;
		$query = $this->db->query('Select * from `file` where fileid ='.$id);
		return $query->row;
	}
	
	public function getFiles($where = "")
	{
		$query = $this->db->query('Select * from `file` WHERE 1=1 ' .$where);
		return $query->rows;
	}
	
	public function getImageBy($where)
	{
		$sql="Select * from `file` WHERE extension in ('jpg','png','gif') ".$where;
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	public function getFileChild($parent)
	{
		$query = $this->db->query('Select * from `file` where fileparent ='.$parent.' Order by fileid');
		return $query->rows;
	}
	
	private function nextID()
	{
		return $this->db->getNextId("file","fileid");
	}
	
	public function insertFile($data)
	{
		$fileid=(int)@$data['fileid'];
		$filename=$this->db->escape(@$data['filename']);
		$filepath=$this->db->escape(@$data['filepath']);
		$fileparent=(int)@$data['fileparent'];
		$width=(int)@$data['width'];
		$height=(int)@$data['height'];
		$tagkeyword=$this->db->escape(@$data['tagkeyword']);
		$activedate=$this->db->escape(@$data['activedate']);
		$updateddate=$this->db->escape(@$data['updateddate']);
		//$deleteddate=$this->db->escape(@$data['deleteddate']);
		$activeby=$this->db->escape(@$data['activeby']);
		$updatedby=$this->db->escape(@$data['updatedby']);
		//$deletedby=$this->db->escape(@$data['deletedby']);
		$filesize=(float)@$data['filesize'];
		$extension=$this->db->escape(@$data['extension']);
		$filetypeid=$this->db->escape(@$data['filetypeid']);
		$field=array(
						"fileid",
						"filename",
						"filepath",
						"fileparent",
						"width",
						"height",
						"tagkeyword",
						"activedate",
						"updateddate",
						"activeby",
						"updatedby",
						"filesize",
						"extension",
						"filetypeid"
					);
		$value=array(
						$fileid,
						$filename,
						$filepath,
						$fileparent,
						$width,
						$height,
						$tagkeyword,
						$activedate,
						$updateddate,
						$activeby,
						$updatedby,
						$filesize,
						$extension,
						$filetypeid
					);
		$this->db->insertData("file",$field,$value);
	}
	
	public function updateTagKeyword($fileid, $keyword)
	{
		$sql = "Update `file` set `tagkeyword` = '".$keyword."' where `fileid` = '".$fileid."'";
		$this->db->query($sql);
		
	}
	
	public function updateFileTemp($imageid)
	{
		if($imageid != "")
		{
			$sql = "Update `file` set tagkeyword='' where fileid = '".$imageid."'";
			$this->db->query($sql);
		}
	}
	
	public function updateListFileTemp($listimageid)
	{
		if(count($listimageid) >0 )
		{
			$list = implode("','",$listimageid);
			$sql = "Update `file` set tagkeyword='' where fileid in ('".$list."')";
			$this->db->query($sql);
		}
		
	}
	
	public function clearTemp()
	{
		$sql="Select * from `file` WHERE `tagkeyword` = 'temp'";
		$query = $this->db->query($sql);
		foreach( $query->rows as $item)
		{
			$this->deleteFile($item['fileid']);
		}
		
	}
	
	public function updateFile($data, $languageid)
	{
		$fileid=(int)@$data['fileid'];
		$filename=$this->db->escape(@$data['filename']);
		$filepath=$this->db->escape(@$data['filepath']);
		$fileparent=(int)@$data['fileparent'];
		$width=(int)@$data['width'];
		$height=(int)@$data['height'];
		$tagkeyword=$this->db->escape(@$data['tagkeyword']);
		//$activedate=$this->db->escape(@$data['activedate']);
		$updateddate=$this->db->escape(@$data['updateddate']);
		$deleteddate=$this->db->escape(@$data['deleteddate']);
		//$activeby=$this->db->escape(@$data['activeby']);
		$updatedby=$this->db->escape(@$data['updatedby']);
		$deletedby=$this->db->escape(@$data['deletedby']);
		$filesize=(float)@$data['filesize'];
		$extension=$this->db->escape(@$data['extension']);
		$filetypeid=$this->db->escape(@$data['filetypeid']);
		$field=array(
						"fileid",
						"filename",
						"filepath",
						"fileparent",
						"width",
						"height",
						"tagkeyword",
						"updateddate",
						"deleteddate",
						"updatedby",
						"deletedby",
						"filesize",
						"extension",
						"filetypeid"
					);
		$value=array(
						$fileid,
						$filename,
						$filepath,
						$fileparent,
						$width,
						$height,
						$tagkeyword,
						$updateddate,
						$deleteddate,
						$updatedby,
						$deletedby,
						$filesize,
						$extension,
						$filetypeid
					);
		$where="fileid = ".$fileid;
		$this->db->updateData('file',$field,$value,$where);
		
		$languageid=(int)@$languageid;
		$Title = $this->db->escape(@$data['Title']);
		$field=array(
						"fileid",
						"languageid",
						"Title"
					);
		$value=array(
						$fileid,
						$languageid,
						$Title
					);
		$where="fileid = ".$fileid." and languageid = ".$languageid;
		$this->db->updateData('file_description',$field,$value,$where);
	}
	
	public function deleteFile($id)
	{
		$file=$this->getFile($id);
		
		if(file_exists(DIR_FILE.$file['filepath']))
			unlink(DIR_FILE.$file['filepath']);
		
		$fileid=(int)@$id;
		$where="fileid = ".$fileid;
		$this->db->deleteData('file',$where);
	}
	
	public function checkExtension($ext, $filetypeid="any")
	{
		$this->load->model("core/filetype");
		if($filetypeid=="any" || $filetypeid="")
			return true;
		
		$flag=false;		
		$ext;
		$result=$this->model_core_filetype->getFiletype($filetypeid);
		$list=split(",", $result[0]['ListExtension']);
		for($i=0;$i<count($list);$i++)
		{
			if(trim($list[$i])==$ext)
			{	
				$flag=true;
				break;
			}
		}
		return $flag;
	}
	
	function uploaduserfile($filepath)
	{
		$file = $_FILES[$filepath];
		$arfile = split('\.', $file['name'] );
		$extension = strtolower($arfile[1]);
		
		$path = DIR_FILE."user/".$this->user->getId()."/";

		if (! is_dir($path))
			mkdir( $path , 0777 );
		
		$targetpath = $path.$filepath.".".$extension;
		move_uploaded_file($file['tmp_name'],$targetpath);
	}
	
	function setUserThemeFile($value)
	{
		$path = DIR_FILE."user/".$this->user->getId()."/";

		if (! is_dir($path))
			mkdir( $path , 0777 );
			
		$file = DIR_FILE."user/".$this->user->getId()."/".$this->user->getId().".data";
    	
		$handle = fopen($file, 'w');

    	fwrite($handle, $value);
		
    	fclose($handle);
	}
	
	function saveFile($file,$filepath="",$filetypeid="image",$tagkeyword="")
	{
		
		$arfile = split('\.', $file['name'] );
		$datafile = array();
		//Filename
		$filename = $this->string->chuyenvekodau($arfile[0]);
		
		$extension = strtolower($arfile[count($arfile)-1]);
		//convert byte sang KB
		$filesize=($file['size'])/1024;

		if($this->validateExtension($extension,$filesize,$filetypeid))
		{
			//get width + height cua file image
			$width=0;//default = 0
			$height=0;
			if($filetypeid=="image")
			{
				$size = getimagesize($file['tmp_name']);
				$width=$size[0];
				$height=$size[1];
			}
			
			
			
			//Upload & Save file
			$count=1;
			if (trim($file['tmp_name']) != '') 
			{
				$uploadDir= $filepath;
				
				//Tao thu muc
				$listdir=split("/",	$uploadDir);
				$path=DIR_FILE;
				foreach($listdir as $dir)
				{
					
					if($dir!="")
					{
						$path.=$dir."/";
						if (! is_dir($path))
							mkdir( $path , 0777 );
					}
				}
				
				$uploadDir= DIR_FILE.$filepath;
				
				$datafile['filename']=$filename.".".$extension;
				$datafile['filepath']=$filepath;
				$datafile['filetypeid']=$filetypeid;
				while(file_exists($uploadDir.$datafile['filename']))
				{
					$datafile['filename']=$filename.$count.".".$extension;
					$count++;
				}
				
				$datafile['filepath'].=$datafile['filename'];
				
				$datafile['fileid']=$this->model_core_file->nextID();
				$datafile['fileparent']="";
				$datafile['width']=$width;	
				$datafile['height']=$height;	
				$datafile['tagkeyword']=$tagkeyword;
				$datafile['filesize']=$filesize;
				$datafile['extension']=$extension;
				$datafile['filetypeid']=$filetypeid;
				$datafile['activedate']=$this->date->getToday();
				$datafile['updateddate']=$this->date->getToday();
				$datafile['activeby']=$this->user->getId();
				$datafile['updatedby']=$this->user->getId();
				$this->insertFile($datafile);
				move_uploaded_file($file['tmp_name'],$uploadDir.$datafile['filename']);
			}
			$fileID = $datafile['fileid'];
			return $datafile;
		}
		else
		{
			return '';
		}
	}
	
	function validateExtension($extension,$filesize,$filetypeid)
	{
		switch($filetypeid)
		{
			case "image":
				if($extension != "jpg" && $extension != "png" && $extension != "gif" && $extension != "bmp" && $extension != "jpeg")
				{
					return false;
				}
				elseif($filesize > 2048)
				{
					return false;
				}
			break;
		}
		return true;
	}
	
	function saveAjaxFile($file,$data)
	{
		$arfile = split('\.', $file['name'] );
		$name=$arfile[0];
	 	$ext = $arfile[count($arfile)-1];
		$ext=strtolower($ext);
		$total=substr_count($data['filetypeid'], ',')+1;
		if($this->checkExtension($ext, $data['filetypeid']))
		{
			//convert byte sang MB
			$file['size']=($file['size'])/1048576;
			$count=1;
			//get width + height cua file image
			$width=0;//default = 0
			$height=0;
			if($data['filetypeid']==1)
			{
				$size = getimagesize($file['tmp_name']);
				$width=$size[0];
				$height=$size[1];
			}
			if (trim($file['tmp_name']) != '') 
			{
				$uploadDir= $data['filepath'];
				//Tao thu muc
				$listdir=split("/",	$uploadDir);
				$path=DIR_FILE;
				foreach($listdir as $dir)
				{
					
					if($dir!="")
					{
						$path.=$dir."/";
						if (! is_dir($path))
							mkdir( $path , 0777 );
					}
				}
				
				$uploadDir= DIR_FILE.$data['filepath'];
				//$uploadDir= $_SERVER['DOCUMENT_ROOT'].$data['filepath'];
				$datafile['filename']=$name.".".$ext;
				$datafile['filepath']=$data['filepath'];
				while(file_exists($uploadDir.$datafile['filename']))
				{
					$datafile['filename']=$name.$count.".".$ext;
					$count++;
				}
				$datafile['filepath'].=$datafile['filename'];
				if($data['fileid']=="" || $data['fileid']==0)
				{
					$datafile['fileid']=$this->model_core_file->nextID();
					
					$datafile['fileparent']=$data['fileparent'];
					$datafile['width']=$width;	
					$datafile['height']=$height;	
					$datafile['tagkeyword']=$data['tagkeyword'];
					$datafile['filesize']=$file['size'];
					$datafile['extension']=$ext;
					$datafile['filetypeid']=$data['filetypeid'];
					$datafile['activedate']=$data['activedate'];
					$datafile['updateddate']=$data['updateddate'];
					$datafile['activeby']=$data['activeby'];
					$datafile['updatedby']=$data['updatedby'];
					$datafile['languageid']=$data['languageid'];
					$datafile['Title']=$data['Title'];
					$this->insertFile($datafile, $data['languageid']);
					rename($file['tmp_name'],$uploadDir.$datafile['filename']);	
					//move_uploaded_file($file['tmp_name'],$uploadDir.$datafile['filename']);
				}
				else
				{
					$datafile['fileid']=$data['fileid'];
					$da=$this->getFile($data['fileid']);
					if(file_exists($da[0]['filename']))
						unlink($da[0]['filename']);
					$datafile['fileparent']=$data['fileparent'];
					$datafile['width']=$width;	
					$datafile['height']=$height;
					$datafile['tagkeyword']=$data['tagkeyword'];
					$datafile['filesize']=$file['size'];
					$datafile['extension']=$ext;
					$datafile['filetypeid']=$data['filetypeid'];
					$datafile['updateddate']=$data['updateddate'];
					$datafile['deleteddate']=$data['deleteddate'];
					$datafile['updatedby']=$data['updatedby'];
					$datafile['deletedby']=$data['deletedby'];
					$datafile['languageid']=$data['languageid'];
					$datafile['Title']=$data['Title'];
					$this->updateFile($datafile, $data['languageid']);
					rename($file['tmp_name'],$uploadDir.$datafile['filename']);
					//move_uploaded_file($file['tmp_name'],$uploadDir.$datafile['filename']);
				}	
			}
			$fileID = $datafile['fileid'];
			return $fileID;
		}
		else
		{
			return '';
		}
	}
	
/*	function saveAjaxFile($file,$data)
	{
		$arfile = split('\.', $file['name'] );
		$name=$arfile[0];
		$ext = $arfile[1];
		$ext=strtolower($ext);
		$total=substr_count($data['filetypeid'], ',')+1;
		if($this->checkExtension($ext, $data['filetypeid']))
		{
			//convert byte sang MB
			$file['size']=($file['size'])/1048576;
			$count=1;
			//get width + height cua file image
			$width=0;//default = 0
			$height=0;
			if($data['filetypeid']==1)
			{
				$size = getimagesize($file['tmp_name']);
				$width=$size[0];
				$height=$size[1];
			}
			if (trim($file['tmp_name']) != '') 
			{
				
				$uploadDir= $data['filepath'];
				//Tao thu muc
				$listdir=split("/",	$uploadDir);
				$path=DIR_FILE;
				foreach($listdir as $dir)
				{
					
					if($dir!="")
					{
						$path.=$dir."/";
						if (! is_dir($path))
							mkdir( $path , 0777 );
					}
				}
				
				$uploadDir= DIR_FILE.$data['filepath'];
		
				if($data['fileid']=="" || $data['fileid']==0)
				{
					$datafile['fileid']=$this->model_core_file->nextID();
					$datafile['filename']=$name.".".$ext;
					$datafile['filepath']=$uploadDir.$name.".".$ext;
					while(file_exists($datafile['filepath']))
					{
						$datafile['filename']=$name.$count.".".$ext;
						$datafile['filepath']=$uploadDir.$name.$count.".".$ext;
						$count++;
					}
					$datafile['fileparent']=$data['fileparent'];
					$datafile['width']=$width;	
					$datafile['height']=$height;
					$datafile['tagkeyword']=$data['tagkeyword'];
					$datafile['filesize']=$file['size'];
					$datafile['extension']=$ext;
					$datafile['filetypeid']=$data['filetypeid'];
					$datafile['activedate']=$data['activedate'];
					$datafile['updateddate']=$data['updateddate'];
					$datafile['activeby']=$data['activeby'];
					$datafile['updatedby']=$data['updatedby'];
					$datafile['languageid']=$data['languageid'];
					$datafile['Title']=$data['Title'];
					$this->insertFile($datafile, $data['languageid']);
					rename($file['tmp_name'],$uploadDir);
				}
				else
				{
					
					$datafile['fileid']=$data['fileid'];
					$da=$this->getFile($data['fileid']);
					if(file_exists($da[0]['filename']))
						unlink($da[0]['filename']);
					
					$datafile['filename']=$name.".".$ext;
					$datafile['filepath']=$uploadDir.$name.".".$ext;
					while(file_exists($datafile['filepath']))
					{
						$datafile['filename']=$name.$count.".".$ext;
						$datafile['filepath']=$uploadDir.$name.$count.".".$ext;
						$count++;
					}
					$datafile['fileparent']=$data['fileparent'];
					$datafile['width']=$width;	
					$datafile['height']=$height;
					$datafile['tagkeyword']=$data['tagkeyword'];
					$datafile['filesize']=$file['size'];
					$datafile['extension']=$ext;
					$datafile['filetypeid']=$data['filetypeid'];
					$datafile['updateddate']=$data['updateddate'];
					$datafile['deleteddate']=$data['deleteddate'];
					$datafile['updatedby']=$data['updatedby'];
					$datafile['deletedby']=$data['deletedby'];
					$datafile['languageid']=$data['languageid'];
					$datafile['Title']=$data['Title'];
					$this->updateFile($datafile, $data['languageid']);
					rename($file['tmp_name'],$uploadDir);
				}
				
			}
			$fileID = $datafile['fileid'];
			return $fileID;
		}
		else
		{
			return '';
		}
	}*/
	
	public function insertDefaultAvatar()
	{
		$languageid=1;//vn=1 en=2
		$fileid=0;
		$filename='user_avatar.png';
		$filepath='view/skin1/image/user_avatar.png';
		$fileparent='';
		$width=48;
		$height=48;
		$tagkeyword='user avatar default';
		$activedate=$this->date->getToday();
		$updateddate=$this->date->getToday();
		//$deleteddate=$this->db->escape(@$data['deleteddate']);
		$activeby='';
		$updatedby='';
		//$deletedby=$this->db->escape(@$data['deletedby']);
		$filesize='0.00442028045654';
		$extension='png';
		$filetypeid='1';
		$field=array(
						"fileid",
						"filename",
						"filepath",
						"fileparent",
						"width",
						"height",
						"tagkeyword",
						"activedate",
						"updateddate",
						"activeby",
						"updatedby",
						"filesize",
						"extension",
						"filetypeid"
					);
		$value=array(
						$fileid,
						$filename,
						$filepath,
						$fileparent,
						$width,
						$height,
						$tagkeyword,
						$activedate,
						$updateddate,
						$activeby,
						$updatedby,
						$filesize,
						$extension,
						$filetypeid
					);
		$this->db->insertData("file",$field,$value);
		
		//$languageid=(int)@$languageid;
		$Title = 'user avatar default';
		$field=array(
						"fileid",
						"languageid",
						"Title"
					);
		$value=array(
						$fileid,
						$languageid,
						$Title
					);
		$this->db->insertData("file_description",$field,$value);
		return $fileid;
	}
}
?>