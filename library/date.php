<?php
final class Date{
	//Kieu ngay chuan: yyyy-mm-dd 00:00:00 - MySQLDate
	//Kieu ngay view: dd-mm-yyyy 00:00:00 - ViewDate
	public $now;
	
	function __construct() 
	{
		$this->now = getdate();	
		
	}
	
	
	//CAC HAM DANH CHO NGAY CHUAN
	function getDay($date)//format yyyy-mm-dd
	{
		$day=substr($date,8,2);  
		return $day;
	}
	
	function getMonth($date)//format yyyy-mm-dd
	{
		$month=substr($date,5,2); 
		return $month;
	}
	
	function getYear($date)//format yyyy-mm-dd
	{
		$year=substr($date,0,4);  
		return $year;
	}
	
	function getMinute($date)
	{
		$m=substr($date,14,2);  
		return $m;
	}
	
	function getHour($date)
	{
		$h=substr($date,11,2);  
		return $h;
	}
	
	function getSecond($date)
	{
		$s=substr($date,17,2);  
		return $s;
	}
	
	function getTime($date)
	{
		$time = substr($date,11,19);  
		return $time;
	}
	
	function getDate($date)
	{
		$date = substr($date,0,10);  
		return $date;
	}
	
	function getToday()
	{
		$today = getdate();
		
		$time = $today['year'].'-'.$this->numberFormate($today['mon']).'-'.$this->numberFormate($today['mday']).' '.$this->numberFormate($today['hours']).":".$this->numberFormate($today['minutes']).":".$this->numberFormate($today['seconds']);
		return $time;
	}
	
	function getTodayNoTime()
	{
		$today = getdate();
		
		$time = $today['year'].'-'.$this->numberFormate($today['mon']).'-'.$this->numberFormate($today['mday']);
		return $time;
	}
	
	function addday($stringdate,$days) //fomate yy-mm-dd
	{
		//string date ( string $format [, int $timestamp] )
		//mktime(0,0,0,
		$d=$this->getDay($stringdate);
		$mon=$this->getMonth($stringdate);
		$y=$this->getYear($stringdate);
		$time = mktime(0,0,0,intval($mon),intval($d)+$days,intval($y));
		return date("Y-m-d",$time);
	}
	
	function addmonth($stringdate,$months) //fomate yy-mm-dd
	{
		
		//string date ( string $format [, int $timestamp] )
		//mktime(0,0,0,
		$d=$this->getDay($stringdate);
		$mon=$this->getMonth($stringdate);
		$y=$this->getYear($stringdate);
		$time = mktime(0,0,0,intval($mon)+$months,intval($d),intval($y));
		return date("Y-m-d",$time);
	}
	
	function addYear($stringdate,$years) //fomate yy-mm-dd
	{
		
		//string date ( string $format [, int $timestamp] )
		//mktime(0,0,0,
		$d=$this->getDay($stringdate);
		$mon=$this->getMonth($stringdate);
		$y=$this->getYear($stringdate);
		$time = mktime(0,0,0,intval($mon),intval($d),intval($y)+$years);
		return date("Y-m-d",$time);
	}
	
	function addHour($stringdate,$hour) //fomate yy-mm-dd
	{
		
		//string date ( string $format [, int $timestamp] )
		//mktime(0,0,0,
		$d=$this->getDay($stringdate);
		$mon=$this->getMonth($stringdate);
		$y=$this->getYear($stringdate);
		
		$h=$this->getHour($stringdate)+$hour;
		$m=$this->getMinute($stringdate);
		$s=$this->getSecond($stringdate);
		$time = mktime(intval($h),intval($m),intval($s),intval($mon),intval($d),intval($y));
		return date("Y-m-d H:i:s",$time);
	}
	
	function addMinutes($stringdate,$minutes) //fomate yy-mm-dd
	{
		
		//string date ( string $format [, int $timestamp] )
		//mktime(0,0,0,
		$d=$this->getDay($stringdate);
		$mon=$this->getMonth($stringdate);
		$y=$this->getYear($stringdate);
		
		$h=$this->getHour($stringdate);
		$m=$this->getMinute($stringdate);
		$s=$this->getSecond($stringdate);
		$time = mktime(intval($h),intval($m) + $minutes,intval($s),intval($mon),intval($d),intval($y));
		return date("Y-m-d H:i:s",$time);
	}
	
	function addSecond($stringdate,$sec) //fomate yy-mm-dd
	{
		
		//string date ( string $format [, int $timestamp] )
		//mktime(0,0,0,
		$d=$this->getDay($stringdate);
		$mon=$this->getMonth($stringdate);
		$y=$this->getYear($stringdate);
		
		$h=$this->getHour($stringdate);
		$m=$this->getMinute($stringdate);
		$s=$this->getSecond($stringdate);
		$time = mktime(intval($h),intval($m),intval($s)+$sec,intval($mon),intval($d),intval($y)+$years);
		return date("Y-m-d  H:i:s",$time);
	}
	
	function isDate($year,$mon,$day)
	{
		$time = mktime(0,0,0,intval($mon),intval($day),intval($year));
		$da1=$year."-".$mon."-".$day;
		$da2= date("Y-m-d",$time);
		if($this->_compareDate($da1,$da2)==0)
			return true;
		else false;
	}
	
	function isDateNull($date)
	{
		if($date=="0000-00-00 00:00:00")
			return true;
		else
			return false;
	}
	function checkFormatDateDMY($input)
	{
		if(strrchr($input, "-")!=""||strrchr($input, "/")!="")
		{
			$day=substr($input,0,2);
			$month=substr($input,3,2);
			$year=substr($input,6,4);
			if($this->isDate($year,$month,$day))
				return true;
			else
				return false;
		}
		else
			return false;
	}
	function checkValidDate($input)
	{
		if($this->checkFormatDateDMY($input))
		{
			if(!(@preg_match('/^(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d$/', $input)))
				return true;
			else
				return false;
		}
		else	
			return false;
	}
	
	function _compareDate($PresentDate,$ExpiredDate)
	{
		//echo $this->timeToInt($PresentDate)." ";
		//echo $this->timeToInt($ExpiredDate)." ";
		return ($this->timeToInt($PresentDate) < $this->timeToInt($ExpiredDate)?1:0);
	}
	
	function timeToInt($stringdate)
	{	
		return strtotime($stringdate);
	}
	
	public function formatTime($time,$format = "")
	{
		switch($format)
		{
			case "":
				if($time == "")
					return "00:00";
				else
				{
					$arr = split(":",$time);
					return $arr[0].":".$arr[1];
				}
			case "longtime":
				if($time == "")
					return "00:00:00";
				else
				{
					return $time;	
				}
		}
	}
	
	//CAC HAM CHUYEN DOI NGAY CHUAN THANH DANG NGAY KHAC
	public function formatMySQLDate($date, $format='DMY', $character='-')
	{
		if($date == '' || $date =="0000-00-00 00:00:00")
			return '';
		
		switch($format)
		{
			case 'MDY':
				return $this->getMonth($date).$character.$this->getDay($date).$character.$this->getYear($date);
			case 'DMY':
				return $this->getDay($date).$character.$this->getMonth($date).$character.$this->getYear($date);
			case 'longdate':
				return $this->getHour($date).":".$this->getMinute($date)." | ".$this->getDay($date).$character.$this->getMonth($date).$character.$this->getYear($date);
		}
	}
	
	
	//CAC HAM CHUYEN DOI DANG NGAY KHAC THANH NGAY CHUAN
	public function formatViewDate($date, $format='DMY', $character='-')
	{
		if($date=="")
			return "";
		switch($format)
		{
			case 'MDY':
				$day=substr($date,3,2);
				$mon=substr($date,0,2);
				$year=substr($date,6,4);
				return $year.$character.$mon.$character.$day;
			case 'DMY':
				$day=substr($date,0,2);
				$mon=substr($date,3,2);
				$year=substr($date,6,4);
				return $year.$character.$mon.$character.$day;
		}
	}
	
	
	function getPath()
	{
		$today = getdate();
		
		$time = "uploads/".$today['year'].$this->numberFormate($today['mon']);
		return $time;
	}
	
	//CAC HAM PRIVATE CAN CHO MODULE
	public function numberFormate($n)
	{
		if($n<10)
			return "0".$n;
		else
			return $n;
	}
}

?>
