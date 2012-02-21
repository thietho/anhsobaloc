<?php
final class Document {
	public $title;
	public $description;
	public $base;	
	public $charset = 'utf-8';		
	public $language = 'vi';	
	public $direction = 'ltr';		
	public $links = array();		
	public $styles = array();
	public $scripts = array();
	public $breadcrumbs;
	public $sitemapid = '';
	public $media = array();
	public $meta_description = '';
	public $meta_keyword = '';
	public $sitebar =array();
	public $text = array();
	public $setting = array();
	public $setup = array();
	public $status = array(
						   'new' => "Đơn hàng mới",
						   'pending' => "Đang chờ thanh toán",
						   'completed' => "Đã thanh toán"
						   );
	public $status_comment = array(
						   'new' => "Chưa duyệt",
						   'published' => "Duyệt",
						   'denial' => "Không duyệt"
						   );
	private $filepath;
	public function __construct() 
	{
		$this->db = Registry::get('db');
		$this->language = Registry::get('language');
		$this->text = $this->language->getData();
		
		$this->filepath = DIR_FILE."db/setting.json";
		$this->createDB();
		$this->getData();
		$this->loadSetting();
		$this->title = $this->setup['Title'];
	}
	
	private function loadSetting()
	{
		$sql = "Select `media_information`.* 
									from `media_information` Where mediaid = 'setting'";
		$query = $this->db->query($sql);
		foreach($query->rows as $item)
		{
			$this->setup[$item['fieldname']] = $item['fieldvalue'];
		}
		
	}
	
	private function createDB()
	{
		$arr = array();
		if(!is_dir(DIR_FILE."db"))
			mkdir(DIR_FILE."db");
		
		if(!is_file($this->filepath))
		{
			
			$fp = fopen($this->filepath, 'w');
			fwrite($fp, '');
			fclose($fp);	
		}
	}
	
	private function getData()
	{
		$filename = $this->filepath;
		$handle = fopen($filename, "r");
		@$contents = fread($handle, filesize($filename));
		fclose($handle);
		$this->setting = json_decode($contents);
		
	}
	
	public function setValue($key,$value)
	{
		$this->setting->$key = $value;
		$this->saveData();
	}
	
	private function saveData()
	{
		$str = json_encode($this->setting);
		$fp = fopen($this->filepath, 'w');
		fwrite($fp, $str);
		fclose($fp);
	}
	
	public function getSiteMap($sitemapid,$siteid,$name="sitemapname")
	{
		$query = $this->db->query("Select `sitemap`.* 
									from `sitemap` 
									where sitemapid ='".$sitemapid."' AND siteid = '".$siteid."'");
		return $query->row[$name];	
	}
	
	public function getCategory($categoryid,$name="categoryname")
	{
		$query = $this->db->query("Select `category`.* 
									from `category` 
									where categoryid ='".$categoryid."' ");
		return $query->row[$name];	
	}
	
	public function getMedia($mediaid,$name="title")
	{
		$query = $this->db->query("Select `media`.* 
									from `media` 
									where mediaid ='".$mediaid."' ");
		return $query->row[$name];	
	}
	
	public function createLink($sitemap="",$id="",$key = "",$val = "")
	{
		$link = HTTP_SERVER;
		if($sitemap)
			$link.= $sitemap;
		if($id)
			$link.= '/'.$id;
		if($key)
			$link.= '/'.$key;
		if($val)
			$link.= '/'.$val;
		return $link.'.html';
	}
	
	public function getPara()
	{
		$uri = $_SERVER['REQUEST_URI'];
		$arr = split("\?",$uri);
		
		$listpara = split("&",$arr[1]);
		$para = array();
		foreach($listpara as $val)
		{
			$ar = split("=",$val);	
			$para[$ar[0]] = $ar[1];
		}
		return $para;
	}
	public function getURI()
	{
		$uri = $_SERVER['REQUEST_URI'];
		//$arr = split("\?",$uri);
		
		
		return $uri;
	}
	
}
?>