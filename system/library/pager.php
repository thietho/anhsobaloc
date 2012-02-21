<?php 
class Pager 
{ 
	function getPagerData($numHits, $limit, $page) 
	{ 
		$numHits  = (int) $numHits; 
		$limit    = max((int) $limit, 1); 
		$page     = (int) $page; 
		$numPages = ceil($numHits / $limit); 
		
		$page = max($page, 1); 
		$page = min($page, $numPages); 
		if($page>0)
			$offset = ($page - 1) * $limit; 
		else
			$offset=0;
		$ret = new stdClass; 
		
		$ret->offset   = $offset; 
		$ret->limit    = $limit; 
		$ret->numPages = $numPages; 
		$ret->page     = $page; 
		return $ret; 
	}
	function pageLayout($numHits, $limit, $page)
	{
		$pager=$this->getPagerData($numHits, $limit, $page);
		$offset = $pager->offset;
		$limit  = $pager->limit; 
		$page   = $pager->page;
		$start=$page - 2;
		if($start < 1 )
		{
			$start=1;
			$end=5;
		}
		else
			$end= $page + 2;
		if($end > $pager->numPages)
		{
			
			$end=$pager->numPages;
			$start=$end-5;
			if($start < 1)
				$start = 1;
		}
		$data_paginations=array();
		$_SESSION['goback']=$this->getURLQueryString('page', $page);
		if($pager->numPages > 1 && $page >1)
		{
			array_push($data_paginations,"<a class='button' href='".$this->getURLQueryString('page', '1')."'>|<</a>");
			array_push($data_paginations,"<a class='button' href='".$this->getURLQueryString('page', $page - 1)."' ><</a>");	
		}
		
		for ($j = $start; $j <= $end; $j++) 
		{
			if($j==$page)
			{
				array_push($data_paginations,"<b>$j</b>");
				
			}
			else
			{
				array_push($data_paginations,"<a class='button' href='".$this->getURLQueryString('page',$j )."'>$j</a>");
			}
		}
		if($pager->numPages > 1 && $page<$pager->numPages )
		{
			array_push($data_paginations,"<a class='button' href='".$this->getURLQueryString('page', ($page+1))."'>></a>");
			array_push($data_paginations,"<a class='button' href='".$this->getURLQueryString('page', $pager->numPages)."'>>|</a>");
		}
		$data_pagenumber=$page."/".$pager->numPages;
		$playout=" <div class='pager' align='right'>";
		foreach($data_paginations as $val)
			$playout.=$val;
		$playout.=" </div>";
		return $playout;
	}
	
	function pageLayoutAjax($numHits, $limit, $page,$eid="")
	{
		$pager=$this->getPagerData($numHits, $limit, $page);
		$offset = $pager->offset;
		$limit  = $pager->limit; 
		$page   = $pager->page;
		$start=$page - 2;
		if($start < 1 )
		{
			$start=1;
			$end=5;
		}
		else
			$end= $page + 2;
		if($end > $pager->numPages)
		{
			
			$end=$pager->numPages;
			$start=$end-5;
			if($start < 1)
				$start = 1;
		}
		$data_paginations=array();
		if($pager->numPages > 1 && $page >1)
		{
			array_push($data_paginations,'<a class="button" onclick="moveto(\''.$this->getURLQueryString('page', '1').'\',\''.$eid.'\')">|<</a>');
			array_push($data_paginations,'<a class="button" onclick="moveto(\''.$this->getURLQueryString('page', $page - 1).'\',\''.$eid.'\')"><</a>');	
		}
		
		for ($j = $start; $j <= $end; $j++) 
		{
			if($j==$page)
			{
				array_push($data_paginations,'<a class="button"><b>'.$j.'</b></a>');
				
			}
			else
			{
				array_push($data_paginations, '<a class="button" onclick="moveto(\''.$this->getURLQueryString('page', $j).'\',\''.$eid.'\')">'.$j.'</a>');
			}
		}
		if($pager->numPages > 1 && $page<$pager->numPages )
		{
			array_push($data_paginations, '<a class="button" onclick="moveto(\''.$this->getURLQueryString('page', ($page+1)).'\',\''.$eid.'\')">></a>');
			array_push($data_paginations, '<a class="button" onclick="moveto(\''.$this->getURLQueryString('page', $pager->numPages).'\',\''.$eid.'\')">>|</a>');
		}
		$data_pagenumber=$page."/".$pager->numPages;
		$playout=" <div class='links'>";
		foreach($data_paginations as $val)
			$playout.=$val;
		$playout.=" </div>";
		
		$playout.='<div class="results">Page '.$page.'/'.$pager->numPages.'</div>';
		
		return $playout;
	}
	function pageLayoutWeb($numHits, $limit, $page,$uri)
	{
		
		$pager=$this->getPagerData($numHits, $limit, $page);
		$offset = $pager->offset;
		$limit  = $pager->limit; 
		$page   = $pager->page;
		$start=$page - 2;
		if($start < 1 )
		{
			$start=1;
			$end=5;
		}
		else
			$end= $page + 2;
		if($end > $pager->numPages)
		{
			
			$end=$pager->numPages;
			$start=$end-5;
			if($start < 1)
				$start = 1;
		}
		$data_paginations=array();
		$char = '?';
		if(strpos($uri,$char))
			$char = '&';
		if($pager->numPages > 1 && $page >1)
		{
			array_push($data_paginations,"<a href='".$uri.$char."page=1"."'>|<</a>");
			array_push($data_paginations,"<a href='".$uri.$char."page=".($page - 1)."' ><</a>");	
		}
		
		for ($j = $start; $j <= $end; $j++) 
		{
			if($j==$page)
			{
				array_push($data_paginations,"<b>$j</b>");
				
			}
			else
			{
				array_push($data_paginations,"<a href='".$this->createQueryString($uri,"page",$j)."'>".$j."</a>");
			}
		}
		if($pager->numPages > 1 && $page<$pager->numPages )
		{
			array_push($data_paginations,"<a href='".$uri.$char."page=".($page + 1)."'>></a>");
			array_push($data_paginations,"<a href='".$uri.$char."page=".$pager->numPages."'>>|</a>");
		}
		$data_pagenumber=$page."/".$pager->numPages;
		$playout=" <div class='ben-page'>";
		foreach($data_paginations as $val)
			$playout.=$val;
		$playout.=" </div>";
		
		$playout.='<div class="results">Trang '.$page.'/'.$pager->numPages.'</div>';
		
		return $playout;
	}
	
	function createQueryString($url,$strkey, $setvalue)
	{
		$arr = split("\?",$url);
		
		$listpara = split("&",$arr[1]);
		
		$para = array();
		foreach($listpara as $val)
		{
			$ar = split("=",$val);	
			$para[$ar[0]] = $ar[1];
		}
		
		$para[$strkey] = $setvalue;
		$arrstr = array();
		foreach($para as $key => $val)
		{
			if($key)
				$arrstr[] = $key."=".$val;	
		}
		$qry = implode("&",$arrstr);
		return $arr[0]."?".$qry;
	}
	
	function getURLQueryString($strkey, $setvalue)
	{
		$address = $_SERVER['QUERY_STRING'];
		$arrParams = split("&", $address);
		if(count($arrParams)==1)
			return "?$address&$strkey=$setvalue";
		// Go though all elements
		$result = "?".$arrParams[0];
		for($i=1;$i<count($arrParams);$i++)
		{
			// replace already key
			$iskey = strpos($arrParams[$i], $strkey);
			if($iskey !== false) 
			{} 
			else 
			{ 
				if($i>0 && $result != '?') { $result .= "&"; }
				$result .= $arrParams[$i]; 
			}				
		}
		//
		if($result != '?') { $result .= "&"; }
		return $result .= "$strkey=$setvalue";
	}
	
	
}

?>