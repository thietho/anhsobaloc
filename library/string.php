<?php
final class String
{
	function getPrefix($letter,$n)
	{
		$s="";
		for($i=0;$i<$n;$i++)
			$s.=$letter;
		return $s;
	}
	
	public function inArray($str, $arr=array())
	{
		if(!is_array($arr))
		{
			if($str == $arr) return 0;
		}elseif(count($arr) > 0)
		{
			foreach($arr as $key => $value)
			{
				if($str == $value) return $key;
			}
		}
		return -1;
	}
	
	public function matrixToArray($data,$col)
	{
		$arr = array();
		foreach($data as $item)
			$arr[]=$item[$col];
		return $arr;
	}
	
	public function array_Filter($data,$col,$value)
	{
		$arr = array();
		foreach($data as $item)
		{
			if($item[$col] == $value)
				$arr[]=$item;
		}
		return $arr;
	}
	
	public function swapArray($arr)
	{
		$ar=array();
		while(count($arr))
		{
			$ar[]=array_pop($arr);
		}
		return $ar;
	}
	
	public function numberFormate($num,$n = 0)
	{
		return number_format($num, $n, '.', ',');
	}
	
	public function toNumber($str)
	{
		return str_replace(",","",$str);
	}
	
	function arrayRemove($arr,$pos)
	{
		$ar=array();
		foreach($arr as $key => $item)
		{
			if($key!=$pos)
				$ar[$key]=$item;
		}
		return $ar;
	}
	
	function remove_item_by_value($array, $val = '', $preserve_keys = true) 
	{
   		if (count($array)==0 || !is_array($array)) return false;
    	if (!in_array($val, $array)) return $array;
 
    	foreach($array as $key => $value) 
		{
        	if ($value == $val) unset($array[$key]);
    	}
 
  		return ($preserve_keys === true) ? $array : array_values($array);
	}
	function generateRandStr($length)
	{
		$randstr = "";
		for($i=0; $i<$length; $i++)
		{
			 $randnum = mt_rand(0,61);
			 if($randnum < 10){
				$randstr .= chr($randnum+48);
			 }else if($randnum < 36){
				$randstr .= chr($randnum+55);
			 }else{
				$randstr .= chr($randnum+61);
			 }
		}
		return $randstr;
   } 
	
	function findTag($tag,$closetag,$positon,$s)
	{
		$count=0;
		while($count < $positon)
		{
			
			$pos=strpos($s,$tag);
			$s=substr($s,$pos+strlen($tag));
			$count++;
		}
		$s=$this->findCloseTag($tag,$closetag,$s);
		return substr($s,strpos($s,">")+1);
		
	}
	
	function findCloseTag($tag,$closetag,$s)
	{
		$numtag=0;
		$find=strlen($s);
		for($i=0;$i<strlen($s);$i++)
		{
			$istag=false;
			$closetage=false;
			if($s[$i]==$tag[0])
			{
				$istag=true;
				for($j=0;$j<strlen($tag);$j++)
				{	
					if($s[$i+$j]!=$tag[$j])
						$istag=false;
				}
			}
			if($s[$i]==$closetag[0])
			{
				$closetage=true;
				for($j=0;$j<strlen($closetag);$j++)
				{
					if($s[$i+$j]!=$closetag[$j])
						$closetage=false;
				}
			}
			if($istag==true)
				$numtag++;
			if($closetage==true)
			{
				if($numtag > 0)
					$numtag--;
				else
				{
					$find=$i;
					break;
				}
			}
		}
		return substr($s,0,$find);	
	}
	
	function getSubString($string,$start,$end)
	{
		$poss = strpos($string,$start);
		$temp=substr($string,strpos($string,$start)+strlen($start));
		$pose=strpos($temp,$end) + strlen($start)+2;
		$s=substr($string,$poss,$pose-1);
		$s=str_replace($start,'',$s);
		$s=str_replace($end,'',$s);
		return $s;
	}
	
	
	function removeSubString($string,$start,$end)
	{
		$poss = strpos($string,$start);
		$temp=substr($string,strpos($string,$start)+strlen($start));
		$pose=strpos($temp,$end) + strlen($start)+2;
		return str_replace(substr($string,$poss,$pose-1),"",$string);
	}
	function removeAll($string,$start,$end)
	{
		while(strpos($string,$start)!== false)
		{
			$string=$this->removeSubString($string,$start,$end);
		}
		return $string;
	}
	
	function isImage($ext)
	{
		
		$image = array('jpg','png','gif');
		if(in_array($ext,$image))
			return true;
		else
			return false;
	}
	
	function browser_info($agent=null) 
	{
		// Declare known browsers to look for
		$known = array('msie', 'firefox', 'safari', 'webkit', 'opera', 'netscape',
		'konqueror', 'gecko');
		
		// Clean up agent and build regex that matches phrases for known browsers
		// (e.g. "Firefox/2.0" or "MSIE 6.0" (This only matches the major and minor
		// version numbers.  E.g. "2.0.0.6" is parsed as simply "2.0"
		$agent = strtolower($agent ? $agent : $_SERVER['HTTP_USER_AGENT']);
		$pattern = '#(?<browser>' . join('|', $known) .
		')[/ ]+(?<version>[0-9]+(?:\.[0-9]+)?)#';
		
		// Find all phrases (or return empty array if none found)
		if (!preg_match_all($pattern, $agent, $matches)) return array();
		
		// Since some UAs have more than one phrase (e.g Firefox has a Gecko phrase,
		// Opera 7,8 have a MSIE phrase), use the last one found (the right-most one
		// in the UA).  That's usually the most correct.
		$i = count($matches['browser'])-1;
		return array($matches['browser'][$i] => $matches['version'][$i]);
	}
	
	function xmltoArray($objxml)
	{
		$data=array();
		$index=0;
		foreach($objxml->children() as $child)
		{
			foreach( $child->attributes() as $key => $item)
			{
				$data[$index][$key]= $item;
			}
			$data[$index]['xmlvalue'] = $child;
			$index++;
		}
		return $data;
	}
	
	function searchKey($ar,$att,$value)
	{
		foreach($ar as $item)
		{
			if($item[$att]==$value)
				return $item;
		}
		return false;
	}
	
	function referSiteMapToArray($refersitemap)
	{
		$refersitemap = str_replace("][","@",$refersitemap);
		$refersitemap = str_replace("[","",$refersitemap);
		$refersitemap = str_replace("]","",$refersitemap);
		$arr = split("@",$refersitemap);
		return $arr;
	}
	
	function arrayToString($arr)
	{
		$s="";
		foreach($arr as $item)
			$s="[".$item."]";
		return $s;
	}
	
	function getFileName($path)
	{
		$arr = split("/",$path);
		return $arr[count($arr)-1];
	}
	
	function getFileExt($path)
	{
		$arr = split("\.",$path);
		return $arr[count($arr)-1];
	}
	
	function arraykituviet($kytu)
	{
		
		switch($kytu)
		{
			
			case 'a':
			case 'A':
				$mkt=array('&aacute;','&agrave;','&#7843;','&atilde;','&#7841;','&#259;','&#7855;','&#7857;','&#7859;','&#7861;','&#7863;','&acirc;','&#7845;','&#7847;','&#7849;','&#7851;','&#7853;','&Aacute;','&Agrave;','&#7842;','&Atilde;','&#7840;','&#258;','&#7854;','&#7856;','&#7858;','&#7860;','&#7862;','&Acirc;','&#7844;','&#7846;','&#7848;','&#7850;','&#7852;',"à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă","ằ","ắ","ặ","ẳ","ẵ","À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă","Ằ","Ắ","Ặ","Ẳ","Ẵ",);
				break;
			case 'd':
			case 'D':
				$mkt=array('&#273;','&#272;','đ','Ð','d','ð','Ä');
				break;
			case 'e':
			case 'E':
				$mkt=array('&eacute;','&egrave;','&#7867;','&#7869;','&#7865;','&ecirc;','&#7871;','&#7873;','&#7875;','&#7877;','&#7879;','&Eacute;','&Egrave;','&#7866;','&#7868;','&#7864;','&Ecirc;','&#7870;','&#7872;','&#7874;','&#7876;','&#7878;',"è","é","ẹ","ẻ","ẽ","ê","ề","ế","ệ","ể","ễ","È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ");
				break;
			case 'o':
			case 'O':
				$mkt=array('&oacute;','&ograve;','&#7887;','&otilde;','&#7885;','&ocirc;','&#7889;','&#7891;','&#7893;','&#7895;','&#7897;','&#417;','&#7899;','&#7901;','&#7903;','&#7905;','&#7907;','&Oacute;','&Ograve;','&#7886;','&Otilde;','&#7884;','&Ocirc;','&#7888;','&#7890;','&#7892;','&#7894;','&#7896;','&#416;','&#7898;','&#7900;','&#7902;','&#7904;','&#7906;',"ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ","ờ","ớ","ợ","ở","ỡ","Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ","Ờ","Ớ","Ợ","Ở","Ỡ");
				break;
			case 'i':
			case 'I':
				$mkt=array('&iacute;','&igrave;','&#7881;','&#297;','&#7883;','&Iacute;','&Igrave;','&#7880;','&#296;','&#7882;',"ì","í","ị","ỉ","ĩ","Ì","Í","Ị","Ỉ","Ĩ");
				break;
			case 'u':
			case 'U':
				$mkt=array('&uacute;','&ugrave;','&#7911;','&#361;','&#7909;','&#432;','&#7913;','&#7915;','&#7917;','&#7919;','&#7921;','&Uacute;','&Ugrave;','&#7910;','&#360;','&#7908;','&#431;','&#7912;','&#7914;','&#7916;','&#7918;','&#7920;',"ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ","Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ");
				break;
			case 'y':
			case 'Y':
				$mkt=array('&yacute;','&#7923;','&#7927;','&#7929;','&#7925;','&Yacute;','&#7922;','&#7926;','&#7928;','&#7924;',"ỳ","ý","ỵ","ỷ","ỹ","Ỳ","Ý","Ỵ","Ỷ","Ỹ");
				break;
		}
		return $mkt;
		
	}
	
	function ktcharviet($char)
	{
		$mkt=array('a','d','e','o','i','u','y');
		for($i=0;$i<count($mkt);$i++)
		{
			$m=$this->arraykituviet($mkt[$i]);
			if(in_array($char,$m))
				return 1;
		}
		return 0;
	}
	function botiengviet($kt)
	{
		$mkt=array('a','d','e','o','i','u','y');
		for($i=0;$i<count($mkt);$i++)
		{
			$m=$this->arraykituviet($mkt[$i]);
			for($j=0;$j<count($m);$j++)
			{
				if($kt==$m[$j])
					return $mkt[$i];
			}
		}
		return $kt;
	}
	function timchuviet($s)
	{
		$mktv=array();
		for($i=0;$i< strlen($s);$i++)
		{
			if($s[$i]=='&')
			{
				$temp=$i;
				$ss=$s[$i];
				do
				{
					$i++;
					$ss.=$s[$i];
				}
				while($s[$i]!=';');
				//return($ss);
				if(!in_array($ss,$mktv))
					array_push($mktv,$ss);
			}
			
			if($this->ktcharviet($s[$i])==1) 
			{
				
				if(!in_array($s[$i],$mktv))
					array_push($mktv,$s[$i]);	
			}
		}
		return $mktv;
	}
	function timktdb($s)
	{
		$mktv=array();
		for($i=0;$i< strlen($s);$i++)
		{
			if($s[$i]=='&')
			{
				$temp=$i;
				$ss=$s[$i];
				do
				{
					$i++;
					$ss.=$s[$i];
				}
				while($s[$i]!=';');
				//return($ss);
				if(!in_array($ss,$mktv))
					array_push($mktv,$ss);
			}
		}
		return $mktv;
	}
	/*function chuyenvekodau($s)
	{
		$mktv=$this->timchuviet($s);
		print_r($mktv);
		for($i=0;$i< count($mktv);$i++)
			$s=str_replace($mktv[$i],$this->botiengviet($mktv[$i]),$s);
		return $s;
	}*/
	
	function chuyenvekodau($s)
	{
		$mkt=array('a','d','e','o','i','u','y');
		foreach($mkt as $item)
		{
			$arr = $this->arraykituviet($item);
			foreach($arr as $val)
			{
				$s=str_replace($val,$item,$s);
			}
		}
		return $s;
	}
	
	function removeKtdatbiet($str)
	{
		$s="";
		for($i=0;$i < strlen($str) ; $i++)
		{
			if((ord($str[$i])>=97 && ord($str[$i])<= 122) || (ord($str[$i])>=48 && ord($str[$i])<= 57))
				$s .= $str[$i];
			else 
				$s .=" ";				
		}
		
		return $s;
	}
	
	function stringToKeyword($str)
	{
		$s=strip_tags($str);
		$s = $this->chuyenvekodau($s);
		$s= str_replace("\\n","",$s);
		$s = $this->removeKtdatbiet($s);
		$arr = split(" ",$s);
		
		
		return $arr;
	}
	
	function distinctArray($arr)
	{
		$ar = array();
		foreach($arr as $item)
		{
			$item=strtolower($item);
			if(!in_array($item,$ar))
				$ar[] = $item;
		}
		return $ar;
	}
	
	function getArrBu($arr1,$arr2)
	{
		$h1 = array_diff($arr1,$arr2);
		$h2 = array_diff($arr2,$arr1);
		return array_merge($h1,$h2);
	}
	
	function getArrGiao($arr1,$arr2)
	{
		$arr = array();
		foreach($arr1 as $item)
		{
			if(in_array($item,$arr2))
				$arr[]=$item;
		}
		return $arr;
	}
	
	function createDirpath($path)
	{
		$arr = split("/",$path);
		$pa="";
		foreach($arr as $item)
		{
			$pa .=	$item."/";
			if(!is_dir($pa))
				mkdir($pa);
		}
	}
	
	function getFileInfo($filepath)
	{
		$arr = split("/",$filepath);
		if(count($arr)>0)
		{
			$data['filename'] = array_pop($arr);
			$data['filepath'] = implode("/",$arr);
		}
		else
		{
			$data['filename'] = $filepath;
			$data['filepath'] = "";
		}
		$data['filesize'] = filesize($filepath);
		$arr = split("\.",$data['filename']);
		$data['ext'] = array_pop($arr);
		return $data;
	}
	
	function inludeParameterToTemplate($param,$template)
	{
		foreach($param as $key=>$item)
		{
			$template = str_replace($key,$item,$template);
		}
		return $template;
	}
}	
?>