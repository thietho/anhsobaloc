<?php
$this->load->model("core/file");
class ModelCoreMedia extends ModelCoreFile 
{ 
	public function getItem($mediaid, $where="")
	{
		$query = $this->db->query("Select `media`.* 
									from `media` 
									where mediaid ='".$mediaid."' ".$where);
		return $query->row;
	}
	
	public function getByAlias($alias, $where="")
	{
		$query = $this->db->query("Select `media`.* 
									from `media` 
									where alias ='".$alias."' ".$where);
		return $query->row;
	}
	
	public function getList($where="", $from=0, $to=0,$order="")
	{
		
		$sql = "Select `media`.* 
									from `media` 
									where status not like 'delete' AND mediaid like '%".$this->member->getSiteId()."%' " . $where .$order ;
		if($order == "")
			$order = " Order by position, statusdate DESC";
		if($to > 0)
		{
			$sql .= $order." Limit ".$from.",".$to;
		}
		
		$query = $this->db->query($sql);
		return $query->rows;
	}
	public function getMedias($where="", $from=0, $to=5)
	{
		
		$sql = "Select `media`.* 
									from `media` 
									where status not like 'delete' " . $where ;
		if($to > 0)
		{
			$sql .= " Limit ".$from.",".$to;
		}
		
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	public function getPaginationList($options, $step=0, $to=0,$order="")
	{
		//From
		if((int)$step < 0) $step = 0;
		$from = (int)$step * (int)$to;
		
		//All Options
		$keyword = $options['keyword'];
		$mediaparent = $options['mediaparent'];
		$mediatype = $options['mediatype'];
		$day = $options['day'];
		$month = $options['month'];
		$year = $options['year'];
		$refersitemap = $options['refersitemap'];
		$groupkeys = $options['groupkeys'];
		
		//Where Command
		$where = "";
		//keyword
		if($keyword !="")
		{
			$where .= " AND ( title like '%".$keyword."%' OR summary like '%".$keyword."%' OR description like '%".$keyword."%')";
		}
		//Media Parent
		if(is_array($mediaparent))
		{
			foreach($mediaparent as $item)
			{
				$where .= " AND mediaparent ='".$item."'";
			}
		}
		elseif($mediaparent != "%")
		{
			$where .= " AND mediaparent ='".$mediaparent."'";
		}
		
		//Media Type
		if(is_array($mediatype))
		{
			foreach($mediatype as $item)
			{
				$where .= " AND mediatype ='".$item."'";
			}
		}
		elseif($mediatype != "%")
		{
			$where .= " AND mediatype ='".$mediatype."'";
		}
		
		//Date
		if($month != "" && $day != "" && $year != "")
		{
			$php_start_time = mktime(0,0,0, $month, $day, $year);
			$php_end_time = $php_start_time + (24 * 60 * 60); // Add 1 day to start date.
			$start_date = date('Y-m-d', $php_start_time) . ' 000000';
			$end_date = date('Y-m-d', $php_end_time) . ' 000000';
			
			$where .= " AND statusdate >= '".$start_date."' AND statusdate < '".$end_date."'";
		}
		
		//refersitemap
		if(is_array($refersitemap) && count($refersitemap))
		{
			foreach($refersitemap as $item)
			{
				$arr[] = " refersitemap like '%[".$item."]%'";
			}
			
			$where .= "AND (". implode($arr," OR ").")";
		}
		elseif($refersitemap != "%")
		{
			$where .= " AND refersitemap like '%[".$refersitemap."]%'";
		}
		
		//groupkeys
		if(is_array($groupkeys) && count($groupkeys))
		{
			foreach($groupkeys as $item)
			{
				$arr[] = " groupkeys like '%[".$item."]%'";
			}
			
			$where .= "AND (". implode($arr," OR ").")";
		}
		elseif($groupkeys != "")
		{
			$where .= " AND groupkeys like '%[".$groupkeys."]%'";
		}
		//echo "<br>".$where;
		return $this->getList($where, $from,$to,$order);
	}
	
	public function getOthersMedia($mediaid, $options, $to=20)
	{
		//All Options
		$mediaparent = $options['mediaparent'];
		$mediatype = $options['mediatype'];
		$day = $options['day'];
		$month = $options['month'];
		$year = $options['year'];
		$date = $options['date'];
		$refersitemap = $options['refersitemap'];
		
		//Where Command
		$where = " AND mediaid != '".$mediaid."'";
		
		//Media Parent
		if(is_array($mediaparent))
		{
			foreach($mediaparent as $item)
			{
				$where .= " AND mediaparent ='".$item."'";
			}
		}
		elseif($mediaparent != "%")
		{
			$where .= " AND mediaparent ='".$mediaparent."'";
		}
		
		//Media Type
		if(is_array($mediatype))
		{
			foreach($mediatype as $item)
			{
				$where .= " AND mediatype ='".$item."'";
			}
		}
		elseif($mediatype != "%")
		{
			$where .= " AND mediatype ='".$mediatype."'";
		}
		
		//Date
		if($date != "")
		{
			$where .= " AND statusdate < '".$date."'";
		}
		elseif($month != "" && $day != "" && $year != "")
		{
			$php_start_time = mktime(0,0,0, $month, $day, $year);
			$start_date = date('Y-m-d', $php_start_time) . ' 000000';
			$where .= " AND statusdate > '".$start_date."'";
		}
		
		//refersitemap
		if(is_array($refersitemap))
		{
			foreach($refersitemap as $item)
			{
				$arr[] = " refersitemap like '%[".$item."]%'";
			}
			
			$where .= "AND (". implode($arr," OR ").")";
		}
		elseif($refersitemap != "%")
		{
			$where .= " AND refersitemap like '%[".$refersitemap."]%'";
		}
		
		return $this->getList($where, 0, $to);
	}
	
	public function getInformationMedia($sitemapid, $type)
	{
		$query = $this->db->query("Select `media`.* 
									from `media` 
									where refersitemap like '%[".$sitemapid."]%' AND mediatype = '".$type."'");
									
		return $query->row;
	}
	
	public function getListBySitemap($sitemapid, $type)
	{
		$query = $this->db->query("Select `media`.* 
									from `media` 
									where refersitemap like '%[".$sitemapid."]%' AND mediatype = '".$type."'");
									
		return $query->rows;
	}
	
	public function getListByParent($parent,$order = "", $from=0, $length=0)
	{
		$where = "AND mediaparent = '".$parent."' ".$order;		
		return $this->getMedias($where, $from, $length);		
		
		
	}

	
	public function updateMediaDate($mediaid, $statusdate)
	{
		$createddate = $this->date->getToday();
		$sql = "Update `media` set `createddate` = '".$createddate."' where `mediaid` = '".$mediaid."'";
		$this->db->query($sql);
	}

	
	public function insert($data)
	{
		$mediaid=time();
		$mediaparent=$this->db->escape(@$data['mediaparent']);
		$mediatype=$this->db->escape(@$data['mediatype']);
		$refersitemap=$this->db->escape(@$data['refersitemap']);
		$userid=$this->db->escape(@$data['userid']);
		
		$title=$this->db->escape(@$data['title']);
		$summary=$this->db->escape(@$data['summary']);
		$description=$this->db->escape(@$data['description']);
		$author=$this->db->escape(@$data['author']);
		$source=$this->db->escape(@$data['source']);
		
		$imageid=(int)@$data['imageid'];
		$imagepath=$this->db->escape(@$data['imagepath']);
		$fileid=(int)@$data['fileid'];
		$filepath=$this->db->escape(@$data['filepath']);
		
		$groupkeys=$this->db->escape(@$data['groupkeys']);
		$viewcount=0;
		$position=(int)@$data['position'];
		$status="active";
		$statusdate = $this->date->getToday();
		$statusby=$this->db->escape(@$data['userid']);
		$updateddate = $this->date->getToday();
		
		$field=array(
						'mediaid',
						'mediaparent',
						'mediatype',
						'refersitemap',
						'userid',
						'title',
						'summary',
						'description',
						'author',
						'source',
						'imageid',
						'imagepath',
						'fileid',
						'filepath',
						'groupkeys',
						'viewcount',
						'position',
						'status',
						'statusdate',
						'statusby',
						'updateddate'
					);
		$value=array(
						$mediaid,
						$mediaparent,
						$mediatype,
						$refersitemap,
						$userid,
						$title,
						$summary,
						$description,
						$author,
						$source,
						$imageid,
						$imagepath,
						$fileid,
						$filepath,
						$groupkeys,
						$viewcount,
						$position,
						$status,
						$statusdate,
						$statusby,
						$updateddate
					);
		$this->db->insertData("media",$field,$value);
		$this->updateFileTemp($imageid);
		return $mediaid;
	}
	
	public function update($data)
	{
		$mediaid = (int)@$data['mediaid'];
		$mediaparent=$this->db->escape(@$data['mediaparent']);
		$mediatype=$this->db->escape(@$data['mediatype']);
		$refersitemap=$this->db->escape(@$data['refersitemap']);
		$userid=$this->db->escape(@$data['userid']);
		
		$title=$this->db->escape(@$data['title']);
		$summary=$this->db->escape(@$data['summary']);
		$description=$this->db->escape(@$data['description']);
		$author=$this->db->escape(@$data['author']);
		$source=$this->db->escape(@$data['source']);
		
		$imageid=(int)@$data['imageid'];
		$imagepath=$this->db->escape(@$data['imagepath']);
		$fileid=(int)@$data['fileid'];
		$filepath=$this->db->escape(@$data['filepath']);
		
		$groupkeys=$this->db->escape(@$data['groupkeys']);
		$tagkeyword=$this->db->escape(@$data['tagkeyword']);
		
		
		//$createddate=$this->db->escape(@$data['createddate']);
		
		$viewcount=(int)@$data['viewcount'];

		$updateddate = $this->date->getToday();
		
		$field=array(
						'mediaparent',
						'mediatype',
						'refersitemap',
						'userid',
						'title',
						'summary',
						'description',
						'author',
						'source',
						'imageid',
						'imagepath',
						'fileid',
						'filepath',
						'groupkeys',
						'updateddate'
					);
		$value=array(
						$mediaparent,
						$mediatype,
						$refersitemap,
						$userid,
						$title,
						$summary,
						$description,
						$author,
						$source,
						$imageid,
						$imagepath,
						$fileid,
						$filepath,
						$groupkeys,
						$updateddate
					);
		
		$where="mediaid = '".$mediaid."'";
		$this->db->updateData('media',$field,$value,$where);
		
		$this->updateFileTemp($imageid);
		
		if($mediaparent != "")
		{
			$this->updateCreatedDate($mediaparent);
		}
		return true;
	}
	
	public function saveAttachment($mediaid,$listfile)
	{
		if(count($listfile))
		{
			$listfileid=implode(",",$listfile);
			$this->model_core_media->saveInformation($mediaid, "attachment", $listfileid);
			$this->model_core_media->updateListFileTemp($listfile);
		}
		else
			$this->model_core_media->saveInformation($mediaid, "attachment", "");
	}
	
	public function getInformation($mediaid, $fieldname)
	{
		$sql = "Select * from media_information where mediaid = '".$mediaid."' and fieldname = '".$fieldname."'";
		$query = $this->db->query($sql);
		$info = $query->row;
		return $info['fieldvalue'];
	}
	
	public function saveInformation($mediaid, $fieldname, $fieldvalue)
	{
		$sql = "Select * from media_information where mediaid = '".$mediaid."' and fieldname = '".$fieldname."'";
		$query = $this->db->query($sql);
		$info = $query->rows;
		
		$field=array(
					"mediaid",
					"fieldname",
					"fieldvalue"
				);
				
		$value=array(
					$mediaid,
					$fieldname,
					$fieldvalue,
					);
	
		if(count($info) > 0)
		{
			$where="mediaid = '".$mediaid."' AND fieldname = '".$fieldname."'";
			$this->db->updateData('media_information',$field,$value,$where);
		}
		else
		{
			$this->db->insertData("media_information",$field,$value);	
		}
	}
	
	public function delete($mediaid)
	{
		$status="delete";
		$statusdate = $this->date->getToday();
		$statusby=$this->user->getId();
		
		if($mediaid != "")
		{
			$sql = "Update `media` set status='".$status."', statusdate='".$statusdate."', statusby='".$statusby."' where mediaid = '".$mediaid."'";
			$this->db->query($sql);
		}
	}
	
	public function removeSitemap($mediaid, $sitemapid)
	{	
		if($mediaid != "")
		{
			$media = $this->getItem($mediaid);
			$refersitemap = $this->getReferSitemapString($sitemapid, $media['refersitemap'], "delete");
			$sql = "Update `media` set refersitemap='".$refersitemap."' where mediaid = '".$mediaid."'";
			$this->db->query($sql);
		}
	}
	
	
	
	public function clearTempFile()
	{
		$this->clearTemp();
	}
	
	public function getReferSitemapString($sitemapid, $oldReferSitemap="", $type="add")
	{
		$sitemapid = "[".$sitemapid."]";
		$pos = strrpos($oldReferSitemap, $sitemapid);
		if ($pos === false) {
			if($type=="add"){ 
				$oldReferSitemap .= $sitemapid;
			}
		}elseif($type=="delete")
		{
			$oldReferSitemap = str_replace($sitemapid, "", $oldReferSitemap);
		}
		return $oldReferSitemap;
	}
	
	
	public function getPaginationLinks($index, $queryoptions, $querystring, $step, $to)
	{
		$step = (int)$step;
		$result = array();
		if($index > -1)
		{
			$alink = "";
			$newstep = $step + 1;
			$oldstep = $step - 1;
			
			$newerlist = $this->model_core_media->getPaginationList($queryoptions, $newstep, $to);
			$olderlist = $this->model_core_media->getPaginationList($queryoptions, $oldstep, $to);
			
			$newerid = (float)$medias[0]['id'];
			$olderid = (float)$medias[$index]['id'];
			
			if(count($newerlist) > 0 && $newstep >= 0)
			{
				$a = HTTP_SERVER.$querystring."&step=".$newstep;
				$result['nextlink'] = '<a href="'.$a.'" class="ben-right">Tiếp theo &raquo;</a>';
			}
			
			
			if(count($olderlist) > 0 && $oldstep >= 0)
			{
				//$alink = HTTP_SERVER.$username."/blog/?step=".$olderid.$alink;
				$a = HTTP_SERVER.$querystring."&step=".$oldstep;
				$result['prevlink'] = '<a href="'.$a.'" class="ben-left">&laquo; Về trước</a>';
			}
		}
		return $result;
	}
}
?>