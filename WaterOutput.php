<?php

if($displayType == 'map')
{
	$avgLat = 0;
	$avgLong = 0;
	$output = '';
	$resultsReturned = 0;

	if($standAlone)
	{
		echo '<html><head><script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script><script src="ajaxmenu.js" type="text/javascript"></script></head><body><div id="map" style="width: 700px; height: 400px;"></div><div id="weather" style="width: 700px; height: 200px;"></div>';
	}

	echo '<script type="text/javascript">var locations = [[';
	for($i = 0; $i < sizeof($arrWaterData)-1 && $resultsReturned < $resultsRequested; $i++)
	{
		if(preg_match("/$waterway/i",$arrWaterData[$i][WATER_SITENAME]) || ($sites != 'nosites'))
		{
//			$output .= '\''.'USGS-'.$arrWaterData[$i][WATER_SITEID].' <br> '.$arrWaterData[$i][WATER_SITENAME].' <br> GageHeight: '.$arrWaterData[$i][WATER_GAGEHEIGHT].' ft. <br> Temperature: '.($arrWaterData[$i][WATER_TEMPERATURE]=='UNKNOWN'?'UNKNOWN':$arrWaterData[$i][WATER_TEMPERATURE].' &#176;F').' <br> <a href="javascript:void(0);" onclick="getdata(\\\'WaterWeatherWrapper.php?requestType=both&sites='.$arrWaterData[$i][WATER_SITEID].'\\\',\\\'weather\\\');">Weather Report</a>'.'\','.$arrWaterData[$i][WATER_LATITUDE].','.$arrWaterData[$i][WATER_LONGITUDE].'],[';
			$output .= '\' <p align="center"> '.$arrWaterData[$i][WATER_SITENAME].($arrWaterData[$i][WATER_GAGEHEIGHT]=='UNKNOWN'?'':' <br> Gage Height: '.$arrWaterData[$i][WATER_GAGEHEIGHT].' ft. ').($arrWaterData[$i][WATER_TEMPERATURE]=='UNKNOWN'?'':'<br>Water Temperature: '.$arrWaterData[$i][WATER_TEMPERATURE].' &#176;F').' <br> <a href="javascript:void(0);" onclick="getdata(\\\'WaterWeatherWrapper.php?requestType=both&sites='.$arrWaterData[$i][WATER_SITEID].'\\\',\\\'weather\\\');">Weather Report</a>'.'\','.$arrWaterData[$i][WATER_LATITUDE].','.$arrWaterData[$i][WATER_LONGITUDE].'],[';
			$avgLat += $arrWaterData[$i][WATER_LATITUDE];
			$avgLong += $arrWaterData[$i][WATER_LONGITUDE];
			$resultsReturned++;
		}
	}
	$output = rtrim($output,',[]');

	if($resultsReturned == 0) die("</script>No Results Found!");

	$avgLat = $avgLat / $resultsReturned;
	$avgLong = $avgLong / $resultsReturned;

	echo $output;
	echo ']];';
	echo 'var map = new google.maps.Map(document.getElementById(\'map\'), {	zoom: 7, center: new google.maps.LatLng('.$avgLat.', '.$avgLong.'), mapTypeId: google.maps.MapTypeId.ROADMAP }); var infowindow = new google.maps.InfoWindow(); var marker, i; for (i = 0; i < locations.length; i++) { marker = new google.maps.Marker( { position: new google.maps.LatLng(locations[i][1], locations[i][2]), map: map }); google.maps.event.addListener(marker, \'click\', (function(marker, i) { return function() { infowindow.setContent(locations[i][0]); infowindow.open(map, marker); } })(marker, i)); }';
	echo '</script>';

	if($standAlone) echo '</body></html>';
}
else if($sites != 'nosites' || $displayType == 'text')
{
	$resultsReturned = 0;
	for($i = 0; $i < sizeof($arrWaterData) && $resultsReturned < $resultsRequested; $i++)
	{
		echo 'RESULT: '.$resultsReturned++.endLine();
		echo 'SITENAME: '.$arrWaterData[$i][WATER_SITENAME].endLine();
		echo 'SITEID: '.$arrWaterData[$i][WATER_SITEID].endLine();
		echo 'LATITUDE: '.$arrWaterData[$i][WATER_LATITUDE].endLine();
		echo 'LONGITUDE: '.$arrWaterData[$i][WATER_LONGITUDE].endLine();
		echo 'GAGEHEIGHT: '.$arrWaterData[$i][WATER_GAGEHEIGHT].endLine();
		echo 'TEMPERATURE: '.$arrWaterData[$i][WATER_TEMPERATURE].endLine();
	}
}

?>
