<?php
$this->load->model("core/file");
class ModelCoreMessage extends ModelCoreFile
{ 
	public function getItem($messageid, $where="")
	{
		$sql="Select `message`.* 
									from `message` 
									where messageid ='".$messageid."' ".$where;
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	public function getList($where="", $from=0, $to=0)
	{
		
		$sql = "Select `message`.* 
									from `message` 
									where status <> 'delete' " . $where ;
		if($to > 0)
		{
			$sql .= " Limit ".$from.",".$to;
		}
		
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	public function insert($data)
	{
		$messageid=time();
		$userid=$this->db->escape(@$data['userid']);
		$from=$this->db->escape(@$data['from']);
		$to=$this->db->escape(@$data['to']);
		$title=$this->db->escape(@$data['title']);
		$description=$this->db->escape(@$data['description']);
		$title=$this->db->escape(@$data['title']);
		$summary=$this->db->escape(@$data['summary']);
		$description=$this->db->escape(@$data['description']);
		$attachment=$this->db->escape(@$data['attachment']);
		$status=$this->db->escape(@$data['status']);
		$folder=$this->db->escape(@$data['folder']);
		$senddate=$this->date->getToday();
		$replyfrom=$this->db->escape(@$data['replyfrom']);
		
		$field=array(
						'`messageid`',
						'`userid`',
						'`from`',
						'`to`',
						'`title`',
						'`description`',
						'`attachment`',
						'`status`',
						'`folder`',
						'`senddate`',
						'`replyfrom`'
						
					);
		$value=array(
						$messageid,
						$userid,
						$from,
						$to,
						$title,
						$description,
						$attachment,
						$status,
						$folder,
						$senddate,
						$replyfrom,
					);
		$this->db->insertData("message",$field,$value);
		$data['messageid']=$messageid;
		if($attachment!="")
		{	
			$listfile = split(",",$attachment);
			$this->updateListFileTemp($listfile);
			$this->model_core_message->clearTemp();
		}
		
		//echo "test";
		//Lay danh sach gui message
		$datasend = $this->getTarget($to);
		//print_r($datasend);
		//Gui message den tung user trong list
		foreach($datasend['listuser'] as $item)
		{
			$data['username'] = $item;
			$this->sendMessage($data);
		}
		//Gui message de tung e mail trong list
		foreach($datasend['listemail'] as $item)
		{
			$data['email'] = $item;
			$this->sendEmail($data);
		}
		return $messageid;
	}
	
	
	
	public function delete($messageid)
	{
		$messageid=$this->db->escape(@$messageid);
		//Xoa nhung file dinh kem
		/*$message = $this->getItem($messageid);
		if($message['attachment']!="")
		{
			$list = split(",",$message['attachment']);
			foreach($list as $item)
				$this->deleteFile($item);
		}*/
		//Xoa tin nhan
		if($messageid != "")
		{
			$sql = "Update `message` set status='delete' where messageid = '".$messageid."'";
			$this->db->query($sql);
		}
	}
	
	private function sendMessage($data)
	{
		$messageid=$this->db->escape(@$data['messageid']);
		$username=$this->db->escape(@$data['username']);
		$senddate=$this->date->getToday();
		$field=array(
						'messageid',
						'username',
						'status',
						'folder',
						'senddate'
					);
		$value=array(
						$messageid,
						$username,
						"",
						"inbox",
						$senddate
					);
		$this->db->insertData("messagesend",$field,$value);
	}
	
	public function sendEmail($data)
	{
		$to=$data['email'];
		// subject
		$subject = $data['title'];
		// message
		$message = $data['description'];
		
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		
		// Additional headers
		$headers .= 'From: '.$data['from'];
							
		// Mail it
		@mail($to, $subject, $message, $headers);
	}
	
	private function getTarget($to)
	{
		$listarrdress = split(",",$to);
		$listuser = array();
		$listemail = array();
		//Loc ra danh sach username va danh sach email
		foreach($listarrdress as $item)
		{
			$mystring = trim($item);
			$findme   = '@';
			$pos = strpos($mystring, $findme);
			if ($pos === false) 
			{
				//Not found
				$listuser[]=$this->processString($item);
			} 
			else 
			{
				//found
				$listemail[]=$this->processString($item);
			}
		}
		$data['listuser'] = $listuser;
		$data['listemail'] = $listemail;
		return $data;
	}
	
	private function processString($str)
	{
		$pos = strpos($str,'&lt;');
		if ($pos === false) 
		{
			return trim($str);
		}
		else
		{
			$s = $this->string->getSubString($str,'&lt;','&gt;');
			$s = str_replace('&','',$s);
			return trim($s);
		}
	}
	
	public function getMessages($where, $from=0, $to=0)
	{
		
		$sql = "Select `messagesend`.*
									from `messagesend` 
									where 1=1 " . $where ;
		if($to > 0)
		{
			$sql .= " Limit ".$from.",".$to;
		}
		
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	public function updateStatus($messageid,$status)
	{
		$messageid=$this->db->escape(@$messageid);
		$status=$this->db->escape(@$status);
		$field=array(
						'messageid',
						'status',
					);
		$value=array(
						$messageid,
						$status
					);
		$where="messageid = '".$messageid."'";
		$this->db->updateData('messagesend',$field,$value,$where);
	}
	
	public function updateFolder($messageid,$folder)
	{
		$messageid=$this->db->escape(@$messageid);
		$folder=$this->db->escape(@$folder);
		$field=array(
						'messageid',
						'folder',
					);
		$value=array(
						$messageid,
						$folder
					);
		$where="messageid = '".$messageid."'";
		$this->db->updateData('messagesend',$field,$value,$where);
	}
	
	public function delectMessage($messageid)
	{
		$where="messageid = '".$messageid."'";
		$this->db->deleteData('messagesend',$where);
	}
}