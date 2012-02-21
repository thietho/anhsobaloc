<?php
class ControllerAddonGoogsearch extends Controller
{
	private $error = array();
	public function index()
	{
		$this->document->breadcrumb .= "Tìm kiếm";
		
		$setSearchTerms = "JavaScript";
		$setSearchURL = "site:www.MercuryState.com";
		$keyword = $_GET['keyword'];
		$this->data['searchResultsArray'] = $this->retrieveGoogleSearch(urlencode($keyword));
		//print_r($this->data['searchResultsArray']);
		$this->id="content";
		$this->template="addon/googsearch.tpl";
		$this->render();
	}
	
	function retrieveGoogleSearch($searchTerms="ca",$searchURL="site:www.luthietho.info") 
	{
		$googleBaseUrl = "http://ajax.googleapis.com/ajax/services/search/web";
		$googleBaseQuery = "?v=1.0&q=";
		$googleFullUrl = $googleBaseUrl . $googleBaseQuery . $searchURL . "%20" . $searchTerms; 
		$str = file_get_contents($googleFullUrl);
		/*$curlObject = curl_init();
		curl_setopt($curlObject,CURLOPT_URL,$googleFullUrl);
		curl_setopt($curlObject,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($curlObject,CURLOPT_HEADER,false);
		curl_setopt($curlObject,CURLOPT_REFERER,"http://www.b13ed.com/");
		echo $returnGoogleSearch = curl_exec($curlObject);
		curl_close($curlObject);*/
		$returnGoogleSearch = json_decode($str,true);
		
		return $returnGoogleSearch["responseData"]["results"];
	}
}
?>