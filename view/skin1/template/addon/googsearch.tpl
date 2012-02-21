<script src="https://www.google.com/jsapi?key=ABQIAAAAzidZaHNRmrIba2nU10IxMBQLZ-7hxZRWLzxnTjImYf-aqAlvMBQOUE5b96c9dxhgKNiGxIGEx0DOVw"
        type="text/javascript"></script>
    <script type="text/javascript">
      google.load("search", "1", {"language" : "en"});

      // Call this function when the page has been loaded
      function initialize() {
        var searchControl = new google.search.SearchControl();
		
		// site restricted web search
		var siteSearch = new google.search.WebSearch();
		siteSearch.setUserDefinedLabel("http://vnexpress.net/");
		siteSearch.setUserDefinedClassSuffix("siteSearch");
		siteSearch.setSiteRestriction("http://vnexpress.net/");
		searchControl.addSearcher(siteSearch);
			
		//Search API Topics
		//searchControl.addSearcher(new google.search.WebSearch());
       /* searchControl.addSearcher(new google.search.NewsSearch());
		searchControl.addSearcher(new google.search.BlogSearch());
		searchControl.addSearcher(new google.search.ImageSearch());
		searchControl.addSearcher(new google.search.BookSearch());
		searchControl.addSearcher(new google.search.VideoSearch());*/
		//others
		//searchControl.addSearcher(new google.search.LocalSearch());
		//searchControl.addSearcher(new google.search.PatentSearch());
			
		// create a drawOptions object
		var drawOptions = new google.search.DrawOptions();
		// tell the searcher to draw itself in tabbed mode
		drawOptions.setDrawMode(google.search.SearchControl.DRAW_MODE_TABBED);
		searchControl.draw(document.getElementById("searchcontrol"), drawOptions);
		$(".gsc-input").val("<?php echo $keyword?>");
		$(".gsc-search-box").submit();
		$(".gsc-search-button").addClass("ben-button");
		$(".gsc-input").addClass("ben-textbox");
		$(".gsc-input").css("width","95%");
		$(".gsc-search-button").val("<?php echo $button_search?>");
		
      }
      google.setOnLoadCallback(initialize);
	  
	$(document).ready(function(e) {
		//alert("aa");
     	//$(".gsc-input").val("a");
    });
    </script>
	
	<style type="text/css">
		/* the width of the controls (keep same as gsc-results for flush look) */
		#searchcontrol { width:745px; }
		
		.gsc-control { width:745px; }
		/* the width of the search results box; no height value = nice auto look  */
		.gsc-results { width:745px; }
		/* the width of the search input */
		.gsc-input { width:20px; }
		/* hide "powered by google" (optional) */
		.gsc-branding { display:none; }
		.gs-title a { font-weight:bold; }
		#searchcontrol a { color:#FFF; }
		.gsc-tabsArea{display:none}
		.gsc-result-info{color:#FFF}
		.gs-result a.gs-visibleUrl, .gs-result .gs-visibleUrl{color:#FFF;}
		.gsc-results .gsc-cursor-box .gsc-cursor-page{color:#fff;}
		.gsc-results .gsc-cursor-box .gsc-cursor-current-page{color:#000 !important}
		
	</style>
	<div id="searchcontrol"></div>
    <!--<?php foreach($searchResultsArray as $searchResults){ ?>
        <?php foreach($searchResults as $result){ ?>
        <li><strong><a href="<?php echo $result["url"];?>"><?php echo $result["title"];?></a></strong> </li>
        <?php } ?>
    <?php } ?>-->
