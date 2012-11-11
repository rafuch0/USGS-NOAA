<?php
function removeWeatherXMLCruft($entry)
{
	return(preg_match("/<image>/", $entry) || preg_match("/text/", $entry) || preg_match("/valid/", $entry));
}

function getWeatherData($strURL, $strCacheFile, $intLimitHours, &$strGeographicLocation)
{
	if(!file_exists($strCacheFile) || (filemtime($strCacheFile)+(60*60*$intLimitHours) < time()))
	{
		$arrCacheData = file($strURL);
		if(!$arrCacheData) die('Problem Retrieving NOAA Data!  Please try your request again.');

		$arrGeographicLocation = explode('"', $arrCacheData[1], 3);
		$strGeographicLocation = str_replace('"','',$arrGeographicLocation[1]);
		$arrCacheData = array_filter($arrCacheData, "removeWeatherXMLCruft");
		$arrCacheData = array_merge($arrCacheData);

		$fdCacheFile = fopen($strCacheFile, "w");
		fputs($fdCacheFile, $strGeographicLocation."\n");
		for($i = 0; $i < sizeof($arrCacheData); $i++)
		{
			fputs($fdCacheFile, $arrCacheData[$i]);
		}
		fclose($fdCacheFile);
	}
	
	$arrCacheData = array();

	$fdCacheFile = fopen($strCacheFile, "r");
	$strGeographicLocation = stream_get_line($fdCacheFile, 4096, "\n");
	while(!feof($fdCacheFile))
	{
		$arrCacheData[] = stream_get_line($fdCacheFile, 4096, "\n");
	}
	fclose($fdCacheFile);

	$strWeatherData = implode("\r\n",$arrCacheData);
	$strWeatherData = strip_tags(str_replace(array(',',"\r\n"),array('',','),$strWeatherData));
	$arrCacheData = str_getcsv($strWeatherData);

	return array_chunk($arrCacheData, 3);
}

?>
<?php
date_default_timezone_set('EST');

$strWeatherDataBaseURL = 'http://forecast.weather.gov/MapClick.php?TextType=3';
$strWeatherIconBaseURL ='http://mobile.wrh.noaa.gov/weather/images/fcicons/';

if(DEBUG) header('content-type: text/plain');
else header('content-type: text/html');

if(!defined('WRAPPER_ACTIVE'))
{
	include('WaterWeatherDefines.php');
	include('WeatherVariables.php');
}

if(($lat != "nolat") && ($long != "nolong"))
{
	$strWeatherDataURL = $strWeatherDataBaseURL.'&textField1='.$lat.'&textField2='.$long;
	$strCacheFile = $strCacheBase.'NOAA-'.md5($lat.$long);
	$timeLimit = $timeLimitWeather;

	$strGeographicLocation = '';
	$arrWeatherData = getWeatherData($strWeatherDataURL, $strCacheFile, $timeLimit, $strGeographicLocation);

	if(!defined('WRAPPER_ACTIVE'))
	{
		include('WeatherOutput.php');
	}
}

?>
