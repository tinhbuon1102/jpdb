<?php
require_once 'parallerCurl.php';
session_start();

// Define the config params
$app_ID  = 'dj0zaiZpPWpvUXpPQzh4UFpXTSZzPWNvbnN1bWVyc2VjcmV0Jng9OWU-';
$googleKey = 'AIzaSyBBbAzwZ7KZiiuKoaCAyp_FppbRwdtBQzQ';
$iResult = 100;
$numRequest = 1;
$defaultDistance = 1;

function renderTableResults($aStations, $my_address) {
	echo '<style>
			td, th {padding: 10px; text-align: center;}
		</style>';
	echo '
				<h3>Street Name : <span style="color: red">'. $my_address['long_name'] .'</span></h3>
				<table border="1" cellspacing="1" cellpadding="1"><tr><th>Station Name</th><th>Railways</th><th>Distance</th><th>Walking Time</th></tr>';
	foreach ($aStations as $station)
	{
		echo '<tr><td>'.$station['name'].'</td><td>'.$station['line'].'</td><td>'.$station['distance'].'</td><td>'. ceil($station['distance']/80).'(mins)</td></tr>';
	}
	echo '</table>';
}

function getClosestStreetName($lat, $lon, $googleKey)
{
	$googleAPIUrl = 'https://maps.googleapis.com/maps/api/geocode/json?language=ja-JP&location_type=GEOMETRIC_CENTER&latlng='.$lat.','.$lon.'&key='.$googleKey;
	$response = file_get_contents($googleAPIUrl);
	$oResponse = json_decode($response, true);
	if ($oResponse['status'] == 'OK' && isset($oResponse['results'][0]))
	{
		foreach ($oResponse['results'][0]['address_components'] as $addresses)
		{
			if (in_array('route', $addresses['types']))
			{
				$my_address = $addresses;
				
				if ($my_address['long_name'] == 'Unnamed Road')
				{
					$lat = $oResponse['results'][0]['geometry']['viewport']['northeast']['lat'];
					$lon = $oResponse['results'][0]['geometry']['viewport']['northeast']['lng'];
					$my_address = getClosestStreetName($lat, $lon, $googleKey);
					
					if ($my_address['long_name'] == 'Unnamed Road')
					{
						$lat = $oResponse['results'][0]['geometry']['viewport']['southwest']['lat'];
						$lon = $oResponse['results'][0]['geometry']['viewport']['southwest']['lng'];
						$my_address = getClosestStreetName($lat, $lon, $googleKey);
					}
				}
			}
		}
	}
	return $my_address;
}

// Reset session data
$_SESSION['oResponse'] = array();
$_SESSION['numRequest'] = $numRequest;
$_SESSION['numRequestCounting'] = 0;

$address = $_GET['address'];
$distance = isset($_GET['distance']) ? $_GET['distance'] : $defaultDistance;
$finalResults = array();

//Get GEO Coordinates
// $apiUrl = 'http://geo.search.olp.yahooapis.jp/OpenLocalPlatform/V1/geoCoder?output=json&sort=dist&results=1&appid='.$app_ID.'&query=' . $address;
$apiUrl = 'https://maps.googleapis.com/maps/api/geocode/json?language=ja-JP&address='.$address.'&key='.$googleKey;
$response = file_get_contents($apiUrl);
$oResponse = json_decode($response);

if (!empty($oResponse) && $oResponse->status == 'OK' && count($oResponse->results) > 0)
{
	$coordinates = $oResponse->results[0]->geometry->location;
	$lon = $coordinates->lng;
	$lat = $coordinates->lat;
	
	//REquest google API to get Street Name
	$my_address = getClosestStreetName($lat, $lon, $googleKey);
	
	
	$apiUrl = 'http://express.heartrails.com/api/json?method=getStations&x='.$lon.'&y='.$lat;
	$response = file_get_contents($apiUrl);
	$oResponse = json_decode($response, true);
	renderTableResults($oResponse['response']['station'], $my_address);
	
}
else {
	die('Address is not valid');
}
