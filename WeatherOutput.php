<?php

echo 'Weather Information for '.$strGeographicLocation." ($lat, $long)".endLine();

for($i = 0; $i < $days * 2; $i+=2)
{
	if($i < sizeof($arrWeatherData))
		echo '<img src="'.$strWeatherIconBaseURL.$arrWeatherData[$i][WEATHER_ICON].'"><b>'.$arrWeatherData[$i][WEATHER_PERIOD].':</b> '.$arrWeatherData[$i][WEATHER_TEXT].endLine();
	if(($i + 1) < sizeof($arrWeatherData))
		echo '<img src="'.$strWeatherIconBaseURL.$arrWeatherData[$i+1][WEATHER_ICON].'"><b>'.$arrWeatherData[$i+1][WEATHER_PERIOD].':</b> '.$arrWeatherData[$i+1][WEATHER_TEXT].endLine();
}

?>
