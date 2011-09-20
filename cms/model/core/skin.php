<?php
$this->load->model("core/file");
class ModelCoreSkin extends ModelCoreFile 
{
	private $data = array();
	private $filepath;
	function __construct() 
	{
		$this->filepath = DIR_FILE."db/skin.json";
		$this->createDB();
		$this->getData();
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
	
	public function getData()
	{
		$filename = $this->filepath;
		$handle = fopen($filename, "r");
		@$contents = fread($handle, filesize($filename));
		fclose($handle);
		$obj = json_decode($contents);
		if(count($obj))
			foreach($obj as $key=>$item)
			{
				$this->data[$key]['skinid'] = $item->skinid;
				$this->data[$key]['skinname'] = $item->skinname;
				$this->data[$key]['imageid'] = $item->imageid;
				$this->data[$key]['imagepath'] = $item->imagepath;
			}
	}
	
	private function saveData()
	{
		$str = json_encode($this->data);
		$fp = fopen($this->filepath, 'w');
		fwrite($fp, $str);
		fclose($fp);
	}
	
	public function getList()
	{
		return $this->data;	
	}
	
	public function getItem($skinid)
	{
		foreach($this->data as $key=>$item)
		{
			if($skinid == $item['skinid'])
			{
				return $item;
			}
		}
	}
	
	public function insert($data)
	{
		$row['skinid'] = $data['skinid'];
		$row['skinname'] = $data['skinname'];
		$row['imageid'] = $data['imageid'];
		$row['imagepath'] = $data['imagepath'];
		
		$this->data[] = $row;
		$this->saveData();
	}
	
	public function update($data)
	{
		$pos = -1;
		if(count($this->data))
			foreach($this->data as $key=>$item)
			{
				if($data['skinid'] == $item['skinid'])
				{
					$this->data[$key]['skinid'] = $data['skinid'];
					$this->data[$key]['skinname'] = $data['skinname'];
					$this->data[$key]['imageid'] = $data['imageid'];
					$this->data[$key]['imagepath'] = $data['imagepath'];
					
					$pos = $key;
				}
			}
		$this->saveData();
		return $pos;
	}
	
	public function save($data)
	{
		$pos = $this->update($data);
		if($pos == -1)
			$this->insert($data);
	}
	
	public function delete($skinid)
	{
		foreach($this->data as $key=>$item)
		{
			if($skinid == $item['skinid'])
			{
				unset($this->data[$key]);
			}
		}
		$this->saveData();
	}
}
?>