<div id="desscription" style="display:none">
	<strong><?php echo $item['title']?></strong><br><?php echo html_entity_decode($item['description'])?>
</div>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">

var pos = 0;
var flagedit=false;
var x = parseFloat("<?php echo $location['x']?>");
var y = parseFloat("<?php echo $location['y']?>");
var zoom = parseInt("<?php echo $location['zoom']?>");
	


function initialize(x,y,zoom) 
{
	
	geocoder = new google.maps.Geocoder();
	var latlng = new google.maps.LatLng(x, y);
	var myOptions = 
	{
	  zoom: zoom,
	  center: latlng,
	  mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	
	markerobj = new google.maps.Marker({
			map: map, 
			position: latlng,
			draggable:false
					});
	 var contentString = $("#desscription").html();
        
    var infowindow = new google.maps.InfoWindow({
        content: contentString,
        maxWidth: 200
    });
	google.maps.event.addListener(markerobj, 'click', function() {
      infowindow.open(map,markerobj);
    });
	
}


</script>
<div id="map_canvas" style="width: 500px; height: 500px;"></div>
<script language="javascript">

	initialize(x,y,zoom);
	
</script>
 