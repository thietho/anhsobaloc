<?php
	class ControllerCommonProfile extends Controller
	{
		function index()
		{	
			$this->load->model("core/user");
			$this->load->model("core/file");
			
			$userid = $this->user->getId();
			if ( strcasecmp( @ $_SERVER['REQUEST_METHOD'], 'POST' ) == 0 )
			{	
				if(isset($this->request->post['save']))
				{
					if($_FILES['image']['tmp_name']!="")
						$this->updateUserAvatar();
					if($this->request->post['Title']!=""&&$this->request->post['Detail']!="")
						$this->sendRequest();
				}	
			}
			$this->userProfile($userid);
			$this->loadProfile_form();
		}
		
		function loadProfile_form()
		{
			$this->id='content';
			$this->template='common/profile.tpl';
			$this->layout='layout/center';	
			$this->render();
		}
		
		function userProfile($id)
		{	
			$result=$this->model_core_user->getItem($id);
			
			//lay filepath cua image
				$fileid=$result['imageid'];
				$temp=$this->model_core_file->getFile($fileid);
				$filename=$temp['filename'];
				$filepath=DIR_FILE.$temp['filepath'];
			//convert date dang chuan yyyy/mm/dd sang dang dd/mm/yyyy
			$birth=$this->date->formatMySQLDate($result['birthday'], 'DMY', '/');
				
			$this->data["userProfile"]=array(
				"userid"=>$result['userid'],
				//"usertypeid"=>$result[0]['usertypeid'],
				"username"=>$result['username'],
				//"password"=>$result[0]['password'],
				"fullname"=>$result['fullname'],
				
				"email"=>$result['email'],
				"personalid"=>$result['personalid'],
				"filepath"=>$filepath,
				"FileID"=>$fileid,
				"address"=>$result['address'],
				
				"provincecity"=>$result[0]['provincecity'],
				"country"=>$result[0]['country'],
				"birthday"=>$birth,
				"phone"=>$result[0]['phone']
				);
			return $this->data["userProfile"];
		}
		
		function updateUserAvatar()
		{
			if($_FILES['image']['tmp_name']!='')
			{
				if($this->request->post['FileID']=='0'||$this->request->post['FileID']==null)
				{
					$datafile['FileID']= '';
				}
				else
					$datafile['FileID']= $this->request->post['FileID'];
				
				$datafile['filepath']=$this->date->getPath()."user/";
				$datafile['TagKeyword']='avatar';
				$datafile['FileTypeID']="1";//truong hop attachfile
				$datafile['updateddate']=$this->date->getToday();
				$datafile['deleteddate']=$this->date->getToday();
				$datafile['updatedby']="123";
				$datafile['deletedby']="123";
				$datafile['LanguageID']=1;
				$datafile['Title']="avatar";
				$fileid=$this->model_core_file->saveFile($_FILES['image'],$datafile);	
			}
			else
				$fileid=$this->request->post['FileID'];
			
			$this->model_core_user->updateProfileAvatar('1', $fileid);//$this->user->getId()
		}
		
		function sendRequest()
		{
			$userid=$this->data["userProfile"]["userid"];
			$fullname=$this->data["userProfile"]["fullname"];
			$username=$this->data["userProfile"]["username"];
			$email=$this->data["userProfile"]["email"];
			$cmnd=$this->data["userProfile"]["personalid"];
			$phone=$this->data["userProfile"]["phone"];
			$comment=$this->request->post['Detail'];
			
			$subject=$this->request->post['Title'];	
			$to="thai.le@ben-solution.com";
			// message
			$message = "
			userid: $userid<br>
			Fullname: $fullname<br>
			Username: $username<br>
			email: $email<br>
			ID card: $cmnd<br>
			Phone: $phone<br>
			Request: $comment<br>
			";
			
			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			
			// Additional headers
			//$headers .= 'To: '. $to  . "\r\n";
			$headers .= 'From: sale@ladyb.com.vn';
								
			// Mail it
			mail($to, $subject, $message, $headers);
		}
	}
?>