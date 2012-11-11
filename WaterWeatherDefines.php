<?php

define("DEBUG", false);

define("WATER_SITENAME", 0);
define("WATER_SITEID", 1);
define("WATER_LATITUDE", 2);
define("WATER_LONGITUDE", 3);
define("WATER_GAGEHEIGHT", 4);
define("WATER_TEMPERATURE", 5);

define("WEATHER_PERIOD", 0);
define("WEATHER_ICON", 1);
define("WEATHER_TEXT", 2);

$timeLimitWeather = 0.25;
$timeLimitWaterSite = 0.25;
$timeLimitWaterState = 365.0;

$maxResults = 999999999;
$defaultDays = 7;

$strCacheBase = 'cache/';

function endLine()
{
	if(DEBUG) return "\n";
	else return '<br>';
}

?>
