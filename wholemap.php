<!DOCTYPE html>
<?php 
$gApiKey = "AIzaSyCMeCU-45BrK0vyJCc4y2TYMdDJLNGdifM";//$_GET['key']
$zoom = isset($_GET['zoom'])?$_GET['zoom']:16;
$type = $_GET['type']==1?1:0;
$language = isset($_GET['print_language']) ? $_GET['print_language'] : 'ja';
?>
<html>
  <head>
  	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  	<style type="text/css">
  		html, body { width:277mm;height:179mm;margin: 0px; padding: 0px; font-family: 'Noto Sans Japanese', sans-serif; }
  	</style>
	<script src="https://maps.googleapis.com/maps/api/js?language=<?php echo $language?>&key=<?=$gApiKey?>"></script>
	  	
<?php  if($type==0) {?> 	

    <script src="/js/maplabel.js"></script>
	<script>
		var locations = parent.locations; 
		var buildName = parent.buildings; 
		var map;
		function init() {
			var myOptions = {
				zoom: <?=$zoom?>,
				center: new google.maps.LatLng(36.6733301,135.2284552),
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			map = new google.maps.Map(document.getElementById('map'), myOptions);
		    var latlngbounds = new google.maps.LatLngBounds();
			for (i = 0; i < locations.length; i++) {
				var splitLatLong = locations[i].split(',');
				var lat = splitLatLong[0];
				var lng = splitLatLong[1];
				var mapLabel = new MapLabel({
					text: (i+1)+'. '+buildName[i], //abcカウンタの初期化 123 カウンタの初期化
					position: new google.maps.LatLng(lat, lng),
					map: map,
					fontSize: 12,
					align: 'center'
				});
				mapLabel.set('fontColor', '#000000');
				mapLabel.set('fontFamily', 'Noto Sans Japanese');
				mapLabel.set('position', new google.maps.LatLng(lat, lng));
		
				var marker = new google.maps.Marker();
				marker.bindTo('map', mapLabel);
				marker.bindTo('position', mapLabel);
		        latlngbounds.extend(new google.maps.LatLng(lat, lng));
			}
		    map.setCenter(latlngbounds.getCenter());
		    map.fitBounds(latlngbounds);
		}
<?php } else {?>

	<script>
		var locations = parent.locations; 
		var buildName = parent.buildings; 
		var map;
		function init() {
			var myOptions = {
				zoom: <?=$zoom?>,
				center: new google.maps.LatLng(36.6733301,135.2284552),
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			map = new google.maps.Map(document.getElementById('map'), myOptions);
		    var latlngbounds = new google.maps.LatLngBounds();
			for (i = 0; i < locations.length; i++) {
				var splitLatLong = locations[i].split(',');
				var lat = splitLatLong[0];
				var lng = splitLatLong[1];
				var marker = new google.maps.Marker({
				    position: new google.maps.LatLng(lat, lng),
				    map: map,
				    icon: "/images/marker/number_"+(i+1)+".png"
				  });
		        latlngbounds.extend(new google.maps.LatLng(lat, lng));
			}
		    map.setCenter(latlngbounds.getCenter());
		    map.fitBounds(latlngbounds);
		}

<?php } ?>

		window.getZoom = function() {
			var zoom = (typeof map!="undefined")?map.getZoom():'0';
			return zoom;
		}
		google.maps.event.addDomListener(window, 'load', init);
	</script>
  </head>
  <body>
	<div id="map" style="width:277mm;height:179mm;"></div>
  </body>
</html>