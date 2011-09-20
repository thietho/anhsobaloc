<?php
final class Member {
	private $userid;
	private $username;
	private $siteid;
	private $usertypeid;
  	private $permission = array();
	private $Control = array();
	
	public $go_country;
  	
	public function __construct() {
		$this->db = Registry::get('db');
		$this->request = Registry::get('request');
		$this->session  = Registry::get('session');
		$this->json  = Registry::get('json');
		$this->string  = Registry::get('string');
		$this->date  = Registry::get('date');
		
		
		/*switch($this->request->get['lang'])
		{
			case "":
				$this->siteid = SITEID;
				break;
			case "vn":
				$this->siteid = "vietname";
				break;
			case "en":
				$this->siteid = SITEID;
				break;
		}*/
		if($this->request->get['lang'])
		{
			
			$this->siteid = $this->request->get['lang'];
		}
		else
		{
			$this->siteid = SITEID;
		}
		
		if($this->request->get['contry'])
		{
			$this->go_country = $this->request->get['contry'];
			$this->session->set('country',$this->go_country);
		}
		else
		{
			$this->go_country = $this->session->data['country'];
		}
		if($_COOKIE['username'] != "")
		{
			$this->login($_COOKIE['username'],$_COOKIE['password']);	
		}
    	if (isset($this->session->data['memberid'])) {
			$query = $this->db->query("SELECT * FROM user WHERE userid = '" . $this->db->escape($this->session->data['memberid']) . "'");
			
			if ($query->num_rows) {
				$this->userid = $query->row['userid'];
				$this->username = $query->row['username'];
				
      			$this->db->query("UPDATE user SET userip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE userid = '" . $this->session->data['memberid'] . "'");
				$sql = "SELECT permission FROM usertype where usertypeid = (Select usertypeid from user where userid = '" . $this->db->escape($this->session->data['memberid']) . "')";
      			$query = $this->db->query($sql);
				$this->setPermission($query->row['permission']);
			}elseif(isset($this->session->data['safemode'])){
				$this->userid = $this->session->data['memberid'];
				$this->username = $this->session->data['membername'];
			} else {
				$this->logout();
			}
    	}
		$this->updatelistonline();
		$this->writelog();
  	}
		
  	public function login($username, $password) 
	{
		
		if($username=="" || $password=="")
			return false;
		$sql="SELECT * FROM user WHERE username = '" . $this->db->escape($username) . "' AND password = '" . $this->db->escape(md5($password)) . "' AND status = 'active' AND deletedby = ''";
	   	$query = $this->db->query($sql);
		
    	if ($query->num_rows) 
		{
			$this->session->set('membertypeid',$query->row['usertypeid']);
			$this->session->set('memberid',$query->row['userid']);
			$this->session->set('membername',$query->row['username']);	
				
      		return TRUE;
    	} 
		else 
		{
      		return FALSE;
    	}
  	}

	public function loginByProgram($user) 
	{
		$this->session->set('membertypeid',$user['usertypeid']);
		$this->session->set('memberid',$user['userid']);
		$this->session->set('membername',$user['username']);	
			
		return TRUE;
    	
  	}
	
  	public function logout() {
		unset($_SESSION['safemode']);
		unset($_SESSION['memberid']);
		unset($this->session->data['memberid']);	
		$this->userid = '';
		$this->username = '';
		$this->safemode = false;
  	}
	
	public function setPermission($strPermission)
	{
		$this->permission = array();
		
		$this->permission = $this->string->referSiteMapToArray($strPermission);
		
	}

	public function setControl($key, $button)
	{
		$arr = array();
		if(!is_array($button)) {array_push($arr,$button);} else {$arr = $button;}
		$this->Control[$key] = array($arr);
	}
	
	public function getControl()
	{
		return $this->Control;
	}

	public function hasPermission($moduleid, $action) 
	{
		$allow = false;
		if (count($this->permission)) 
		{
			$moduleid = trim($moduleid);
			$action = trim($action);
			foreach($this->permission as $item)
			{
				$arr = split("-",$item);
				if($arr[0] ==$moduleid && $arr[1] == $action )
					$allow = true;
			}
		}
		
		return $allow;
	}
  
  	public function isLogged() {
    	if($this->session->data['memberid']){
			$this->usertypeid = $this->session->data['membertypeid'];
			$this->userid = $this->session->data['memberid'];
			$this->username = $this->session->data['membername'];	
			$this->siteid = $this->session->data['siteid'];		
			return true;
		}
		elseif($this->session->data['safemode']){
			$this->usertypeid = $this->session->data['membertypeid'];
			$this->userid = $this->session->data['memberid'];
			$this->username = $this->session->data['membername'];	
			$this->siteid = $this->session->data['siteid'];		
			return true;
		}
		return false;
  	}
  
  	public function getId() {
    	return $this->userid;
  	}
	
	public function getUserTypeId() {
    	return $this->usertypeid;
  	}
	
	public function getSiteId() {
    	return $this->siteid;
  	}
	
  	public function getUserName() {
    	return $this->username;
  	}
	
	public function getPermission() {
		return $this->permission;
	}
	
	
	
//BENGIN PERMISSION JSON
	
	
	//return array
	public function _getJSONArray($strJSON)
	{
		//$this->json  = Registry::get('json');
		$arr = array();
		if($strJSON != "") return $this->json->decode($strJSON);
		return $arr;
	}
	
	//return array
	public function _getModules($arrJSON)
	{
		$arr = array();
		if(count($arrJSON) > 0)
		{
			return $arrJSON[0];
		}
		return $arr;
	}


	public function _getModules_Filter($arrJSON)
	{
		$arr = array();
			
		if(count($arrJSON) > 0)
		{
			
			if(count($arrJSON[0]) > 0)
			{
				foreach($arrJSON[0] as $moduleid)
				{
					$arrP = $this->_getPermissions($moduleid, $arrJSON);
					$arrS = $this->_getSitemaps($moduleid, $arrJSON);
					if(count($arrP) > 0 || count($arrS) > 0)
					{
						array_push($arr, $moduleid);
					}
				}
			}
		}
		return $arr;
	}
	
	private function writelog()
	{
		$starttime = $this->date->getToday();
		$sessionid = session_id();
		$username  = $this->username;
		$ip = $_SERVER['REMOTE_ADDR'];
		//kiem tra co id chua
		$sql = "SELECT * 
				FROM `user_stats`
				WHERE sessionid = '".$sessionid."'
				" ;
		$query = $this->db->query($sql);
		if($query->num_rows==0)
		{
			$sql = "INSERT INTO `user_stats` (
								`id` ,
								`starttime` ,
								`sessionid` ,
								`username` ,
								`ip` 
								)
								VALUES (
								NULL , 
								'".$starttime."', 
								'".$sessionid."', 
								'".$username."', 
								'".$ip."'
									);";
			$this->db->query($sql);
		}
		else
		{
			$sql = "UPDATE `user_stats` SET 
					`starttime` = '".$starttime."' 
					`username` = '".$username."'
					`ip` = '".$ip."'
					
					WHERE `user_stats`.`sessionid` ='".$sessionid."'";
		}
		
		
	}
	
	public function getOnline()
	{
		$sql = "Select `user_stats`.* 
									from `user_stats` ";
		$query = $this->db->query($sql);
		return count($query->rows);
	}
	
	private function updatelistonline()
	{
		$current_time = $this->date->getToday();
		$session_timelimit = 20; 
		$session_timout = $this->date->addMinutes($current_time,-$session_timelimit) ;
		$sql="DELETE FROM `user_stats` WHERE `user_stats`.`starttime` <= '".$session_timout."'";
		$this->db->query($sql);
	}
	
	//return array
	public function _getPermissions($moduleid, $arrJSON)
	{
		$arr = array();
		
		$arrModule = $this->_getModules($arrJSON);
		
		$index = $this->string->inArray($moduleid, $arrModule) + 1;
		
		if($index > 0 && count($arrJSON[$index][0]) > 0)
		{
			return $arrJSON[$index][0];
		}

		return $arr;
	}
	
	//return array
	public function _getSitemaps($moduleid, $arrJSON)
	{
		$arr = array();
		
		$arrModule = $this->_getModules($arrJSON);
		
		$index = $this->string->inArray($moduleid, $arrModule) + 1;
		
		if($index > 0 && count($arrJSON[$index][1]) > 0)
		{
			return $arrJSON[$index][1];
		}

		return $arr;
	}
//END PERMISSION JSON
	
}
?>