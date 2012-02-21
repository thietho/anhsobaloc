<?php
class ModelCoreSitemap extends Model 
{
	public function getItem($sitemapid, $siteid, $where="")
	{
		$query = $this->db->query("Select `sitemap`.* 
									from `sitemap`
									where  siteid='".$siteid."' AND sitemapid='".$sitemapid."'
									");
		return $query->row;
	}
	
	public function getList($siteid, $where = "")
	{
		$query = $this->db->query("Select `sitemap`.* 
									from `sitemap`
									where `sitemap`.status not like 'Delete' AND siteid = '".$siteid."' ".$where.
									" ORDER BY position, siteid, id"
									);
		return $query->rows;
	}
	
	public function nextID()
	{
		return $this->db->getNextIdVarChar("sitemap","sitemapid","site");
	}
	
	public function nextPosition($parentid)
	{
		$query = $this->db->query("Select max(position) as max From sitemap where sitemapparent='".$parentid."' Order By position");
		return $query->rows[0]['max'] +1 ;
	}
	
	public function listStatus()
	{
		return array(
				"Active"=>"Active",
				"Hide"=>"Hide"
				);
	}
	
	
	//Cac dang lat list khac nhau
	public function getListByParent($parentid, $siteid, $status = "Active")
	{
		$where = " AND sitemapparent = '".$parentid."' ";
		if($status != "")
		{
			$where .= " AND `sitemap`.status = '".$status."' ";
		}
		return $this->getList($siteid, $where);
	}
	
	public function getListByModule($moduleid, $siteid)
	{
		$where = " AND `sitemap`.moduleid = '".$moduleid."'";
		return $this->getList($siteid, $where);
	}
	
	
/*	public function getListChild($parentid)
	{
		$query = $this->db->query("Select * From sitemap where sitemapparent='".$parentid."' and siteid='".$siteid."' Order By position");
		return $query->rows;
	}*/

	/*public function getListSitemapIDbyMediaID($id)
	{
		$query = $this->db->query("Select * from `sitemap_media` where mediaid='".$id."'");
		return $query->rows;
	}*/
	
	
	function getTreeSitemapEdit($id, $hidenid, &$data, $siteid)
	{
		if($id!=$hidenid)
		{
			$arr=$this->getItem($id, $siteid);
			if($id!="")
				array_push($data,$arr);
				
			$rows = $this->getListByParent($id, $siteid);
			
			if(count($rows))
				foreach($rows as $row)
				{
					$this->getTreeSitemapEdit($row['sitemapid'],$hidenid,$data, $siteid);
				}			
		}
	}
	
	
	function getDeep($id, $siteid)
	{
		$deep=0;
		$row=$this->getItem($id, $siteid);
		while($row['sitemapparent']!="")
		{
			$deep++;
			$row=$this->getItem($row['sitemapparent'], $siteid);
		}
		return $deep;
	}
	
	public function getRoot($id, $siteid)
	{
		if($id == "") return 'index';
		$row=$this->getItem($id, $siteid);
		if($row['sitemapparent'] == "")
		{
			return $row['sitemapid'];
		}
		while($row['sitemapparent']!="")
		{
			$row=$this->getItem($row['sitemapparent'], $siteid);
		}
		return $row['sitemapid'];
	}
	
	public function getPath($id, $siteid)
	{
		$arr=array();
		$row=$this->getItem($id, $siteid);
		array_push($arr,$row);
		while($row['sitemapparent']!="")
		{
			$row=$this->getItem($row['sitemapparent'], $siteid);
			array_push($arr,$row);
		}
		return $arr;
	}
	
	public function getBreadcrumb($id, $siteid, $end=0)
	{
		$data = $this->getPath($id, $siteid);
		$strBreadcrumb = "<a href='".HTTP_SERVER."'>Trang chủ</a>";
		for($i=count($data)-1;$i>$end;$i--)
		{
			
			$link = "<a href='".$this->document->createLink($data[$i]['sitemapid'])."'>".$data[$i]['sitemapname']."</a>";
			$strBreadcrumb .= " &#187; ".$link; 
		}
		return $strBreadcrumb;
	}
	
	/*public function pathOfPosition($id)
	{
		$arr=array();
		$row=$this->getItem($id);
		array_push($arr,$row['sitemapid']);
		while($row['sitemapparent']!="")
		{
			$row=$this->getSitemap($row['sitemapparent']);
			array_push($arr,$row['sitemapid']);
		}
		$path="";
		while(count($arr))
		{
			$position=array_pop($arr);
			if($position!="")
				$path.="-".$position;
		}
		//echo $path."<br>";
		return $path;
	}*/
	
	public function insertSiteMap($data, $languageid)
	{
		$sitemapid=$this->db->escape(@$data['sitemapid']);
		$siteid=$this->db->escape(@$data['siteid']);
		$sitemapparent = $this->db->escape(@$data['sitemapparent']);
		$sitemapname = $this->db->escape(@$data['sitemapname']);
		$othername = $this->db->escape(@$data['othername']);
		$position=(int)@$data['position'];
		$moduleid=$this->db->escape(@$data['moduleid']);
		$imageid=(int)@$data['imageid'];
		$imagepath = $this->db->escape(@$data['imagepath']);
		$status=$this->db->escape(@$data['status']);
		$field=array(
						"sitemapid",
						"siteid",
						"sitemapparent",
						"sitemapname",
						"othername",
						"position",
						"moduleid",
						"imageid",
						"imagepath",
						"status"
					);
		$value=array(
						$sitemapid,
						$siteid,
						$sitemapparent,
						$sitemapname,
						$othername,
						$position,
						$moduleid,
						$imageid,
						$imagepath,
						$status
					);
		$this->db->insertData("sitemap",$field,$value);
	}
	
	public function updateSiteMap($data,$languageid)
	{
		$sitemapid=$this->db->escape(@$data['sitemapid']);
		$siteid=$this->db->escape(@$data['siteid']);
		$sitemapparent = $this->db->escape(@$data['sitemapparent']);
		$sitemapname = $this->db->escape(@$data['sitemapname']);
		$othername = $this->db->escape(@$data['othername']);
		$position=(int)@$data['position'];
		$moduleid=$this->db->escape(@$data['moduleid']);
		$imageid=(int)@$data['imageid'];
		$imagepath = $this->db->escape(@$data['imagepath']);
		$status=$this->db->escape(@$data['status']);
		$field=array(
						"siteid",
						"sitemapparent",
						"sitemapname",
						"othername",
						"position",
						"moduleid",
						"imageid",
						"imagepath",
						"status"
					);
		$value=array(
						$siteid,
						$sitemapparent,
						$sitemapname,
						$othername,
						$position,
						$moduleid,
						$imageid,
						$imagepath,
						$status
					);
		$where="sitemapid = '".$sitemapid."'";
		$this->db->updateData('sitemap',$field,$value,$where);
	}
	
	public function updateSiteMapPosition($sitmapid,$position, $siteid)
	{
		$field=array(
						"position"
					);
		$value=array(
						$position
					);
		$where="sitemapid = '".$sitmapid."' AND siteid = '".$siteid."'";
		$this->db->updateData('sitemap',$field,$value,$where);
	}
	
	public function deleteSiteMap($id, $siteid)
	{
		if(count($this->getListByParent($id, $siteid))==0)
		{
			$sitemapid=$id;
			$where="sitemapid = '".$sitmapid."' AND siteid = '".$siteid."'";
			$this->db->deleteData('sitemap',$where);
			return true;
		}
		else return false;			
	}
	



	//Cac ham duyet cay sitemap//////////////////////////////////////////////////////////////
	
	
	function getTreeSitemap($id, &$data, $siteid, $level=-1, $path="", $parentpath="")
	{
		$arr=$this->getItem($id, $siteid);
		
		$rows = $this->getListByParent($id, $siteid);
		
		$arr['countchild'] = count(rows);
		
		if($arr['sitemapparent'] != "") $parentpath .= "-".$arr['sitemapparent'];
		
		if($id!="")
		{
			$level += 1;
			$path .= "-".$id;
			
			$arr['level'] = $level;
			$arr['path'] = $path;
			$arr['parentpath'] = $parentpath;
			
			array_push($data,$arr);
		}
		
		
		if(count($rows))
			foreach($rows as $row)
			{
				$this->getTreeSitemap($row['sitemapid'], $data, $siteid, $level, $path, $parentpath);
			}
	}
	//end cac ham duyet cay sitemap///////////////////////////////////////////////////////
}
?>