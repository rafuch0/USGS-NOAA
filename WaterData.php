<?php
function getCachedWaterData($strURL, $strCacheFile, $intLimitHours)
{
	if(DEBUG || !file_exists($strCacheFile) || (filemtime($strCacheFile)+(60*60*$intLimitHours) < time()))
	{
		$data = file_get_contents($strURL);

		if (!$data)
		{
 			die('Problem Retrieving USGS Data!  Please try your request again.');
		}

		$data = str_replace('ns1:','', $data);

		$xml_tree = simplexml_load_string($data);
		if ($xml_tree === FALSE)
		{
	 		die('Unable to parse USGS\'s XML Data');
		}

		$arrWaterData = array();

		$lastSite = 'NULL';
		$arrEntryCount = 0;

		foreach ($xml_tree->timeSeries as $site_data)
 		{
			if($lastSite == strval($site_data->sourceInfo->siteCode))
			{
				$arrWaterEntry = array_pop($arrWaterData);
			}
			else
			{
		 		$arrWaterEntry = array();
				$arrWaterEntry[WATER_SITENAME] = trim(strip_tags(str_replace(array(',','\''),'',strval($site_data->sourceInfo->siteName))));
				$arrWaterEntry[WATER_SITEID] = strval($site_data->sourceInfo->siteCode);
				$arrWaterEntry[WATER_LATITUDE] = strval($site_data->sourceInfo->geoLocation->geogLocation->latitude);
				$arrWaterEntry[WATER_LONGITUDE] = strval($site_data->sourceInfo->geoLocation->geogLocation->longitude);
				$arrWaterEntry[WATER_GAGEHEIGHT] = 'UNKNOWN';
				$arrWaterEntry[WATER_TEMPERATURE] = 'UNKNOWN';
			}

 	 		$valueData = strval($site_data->values->value);

			if(strval($site_data->variable->variableCode) == '00065')
			{
				$arrWaterEntry[WATER_GAGEHEIGHT] = $valueData;
				if ($valueData < -1000)
				{
					$arrWaterEntry[WATER_GAGEHEIGHT] = 'UNKNOWN';				
				}
			}
			else if(strval($site_data->variable->variableCode) == '00010')
			{
				$arrWaterEntry[WATER_TEMPERATURE] = ($valueData*9.0/5.0)+32.0;
				if ($valueData < -50)
				{
					$arrWaterEntry[WATER_TEMPERATURE] = 'UNKNOWN';				
				}
			}

			array_push($arrWaterData, $arrWaterEntry);
			$lastSite = strval($site_data->sourceInfo->siteCode);
 		}

		$fdCacheFile = fopen($strCacheFile, "w");
		foreach($arrWaterData as $entry)
		{
			fputs($fdCacheFile, $entry[WATER_SITENAME].',');
			fputs($fdCacheFile, $entry[WATER_SITEID].',');
			fputs($fdCacheFile, $entry[WATER_LATITUDE].',');
			fputs($fdCacheFile, $entry[WATER_LONGITUDE].',');
			fputs($fdCacheFile, $entry[WATER_GAGEHEIGHT].',');
			fputs($fdCacheFile, $entry[WATER_TEMPERATURE]."\n");
		}
		fclose($fdCacheFile);
	}
	else
	{
		$fdCacheFile = fopen($strCacheFile, "r");
		while(!feof($fdCacheFile))
		{
			$arrCacheData[] = stream_get_line($fdCacheFile, 4096, "\n");
		}
		fclose($fdCacheFile);

		$strCacheData = implode("\n",$arrCacheData)."\n";
		$strCacheData = str_replace("\n",',',$strCacheData);
		$arrCacheData = str_getcsv($strCacheData);

		$arrWaterData = array_chunk($arrCacheData, 6);
	}

	return $arrWaterData;
}
?>
<?php
date_default_timezone_set('EST');

$strWaterDataBaseURL = 'http://waterservices.usgs.gov/nwis/iv?format=waterml&parameterCd=00065,00010';

if(!defined('WRAPPER_ACTIVE'))
{
	include('WaterWeatherDefines.php');
	include('WaterVariables.php');
}

if(DEBUG) header('content-type: text/plain');
else header('content-type: text/html');

if($sites != "nosites")
{
	$strWaterDataURL = $strWaterDataBaseURL.'&sites='.$sites;
	$strCacheFile = $strCacheBase.'USGS-'.md5($sites);
	$timeLimit = $timeLimitWaterSite;
	$resultsRequested = sizeof(explode(',',$sites));
}
else if($state != "nostate")
{
	$strWaterDataURL = $strWaterDataBaseURL.'&stateCd='.strtolower($state);
	$strCacheFile = $strCacheBase.'USGS-'.md5(strtolower($state));
	$timeLimit = $timeLimitWaterState;
	$resultsRequested = $maxResults;
}
else die("You Must Specify Site(s) or a State!");

if($state != 'ALL')
{
	$arrWaterData = getCachedWaterData($strWaterDataURL, $strCacheFile, $timeLimit);
}
else
{
	$arrWaterData = getCachedWaterData($strWaterDataURL, $strCacheBase.'USGS-ALL', 99999999999);
}

$resultsRequested = ($resultsRequested > sizeof($arrWaterData))?(sizeof($arrWaterData) - 1):$resultsRequested;

if(!defined('WRAPPER_ACTIVE'))
{
	include('WaterOutput.php');
}

?>
