<!DOCTYPE html>
<?php 
$lat = isset($_GET['lat'])?$_GET['lat']:0;
$lng = isset($_GET['lng'])?$_GET['lng']:0;
$gApiKey = "AIzaSyCMeCU-45BrK0vyJCc4y2TYMdDJLNGdifM";//$_GET['key']
$zoom = isset($_GET['zoom'])?$_GET['zoom']:16;
?>
<html>
  <head>
  	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style type="text/css">
		@import url(http://fonts.googleapis.com/earlyaccess/notosansjapanese.css);
      	html, body { width:277mm;height:179mm;margin: 0px; padding: 0px; font-family: 'Noto Sans Japanese', sans-serif; }
      	#map { width:277mm;height:179mm; }
    </style>
  </head>
  <body>
	<div id="map"></div>

    <script type="text/javascript">

	var map;
	function initMap() {
		var myLatLng = {lat:<?=$lat?>, lng:<?=$lng?>};
		map = new google.maps.Map(document.getElementById('map'), {
	    	center: myLatLng,
	    	zoom:<?=$zoom?>
		});
	
		var marker = new google.maps.Marker({
			position: myLatLng,
			map: map
		});

		console.log(map.getZoom());
	}

	window.getZoom = function() {
		var zoom = (typeof map!="undefined")?map.getZoom():'0';
		return zoom;
	}

    </script>
    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=<?=$gApiKey?>&callback=initMap">
    </script>
  </body>
</html>