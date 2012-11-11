<?php

define('WRAPPER_ACTIVE', true);

include('WaterWeatherDefines.php');

if(DEBUG) header('content-type: text/plain');
else header('content-type: text/html');

if(preg_match("/WaterWeatherWrapper.php/",$_SERVER['SCRIPT_FILENAME'])) $standAlone = true;
else $standAlone = false;

$metaTags = get_meta_tags($_SERVER['SCRIPT_FILENAME']);
//$metaTags = get_meta_tags('http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);

if(isset($metaTags['requesttype'])) $requestType = $metaTags['requesttype'];
if(isset($metaTags['state'])) $state = $metaTags['state'];
if(isset($metaTags['waterway'])) $waterway = $metaTags['waterway'];
if(isset($metaTags['sites'])) $sites = $metaTags['sites'];
if(isset($metaTags['results'])) $results = $metaTags['results'];
if(isset($metaTags['lat'])) $lat = $metaTags['lat'];
if(isset($metaTags['long'])) $long = $metaTags['long'];
if(isset($metaTags['days'])) $days = $metaTags['days'];
if(isset($metaTags['displaytype'])) $displayType = $metaTags['displaytype'];

if(isset($_GET["requestType"])) $requestType = basename(strip_tags(strval($_GET["requestType"])));
else if(!isset($requestType)) die("You must pass a requestType (water, weather, or both) to use the wrapper.");

if(isset($_GET["displayType"])) $displayType = basename(strip_tags(strval($_GET["displayType"])));
else if(!isset($displayType)) $displayType='text';

if($requestType == 'weather')
{
	if(!isset($lat) || !isset($long)) 
die("You must pass latitude and longitude for weather report, with optional days limit!");
	include('WeatherVariables.php');
	include('WeatherData.php');
	include('WeatherOutput.php');
}
else if($requestType == 'water')
{
	include('WaterVariables.php');
	if(!isset($sites) && !isset($state)) die("You must pass a site code or state for water report, with optional waterway, results limit, and displayType!");
	include('WaterData.php');
	include('WaterOutput.php');
}
else if($requestType == 'both')
{
	include('WaterVariables.php');
	if(!isset($sites)) die('requestType "both" can only be used for a specific site code.');
	include('WaterData.php');
//	include('WaterOutput.php');
	if($arrWaterData[0][WATER_LATITUDE] && $arrWaterData[0][WATER_LONGITUDE])
	{
		$lat = $arrWaterData[0][WATER_LATITUDE];
		$long = $arrWaterData[0][WATER_LONGITUDE];
		include('WeatherVariables.php');
		include('WeatherData.php');
		include('WeatherOutput.php');
	}
	else die('Failed to Lookup Weather Information!');
}
else die('You passed an invalid requestType!');

?>
