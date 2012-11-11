<html>
<head>

<meta name="requestType" content="water">
<meta name="displayType" content="map">

<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
<script src="ajaxmenu.js" type="text/javascript"></script>

<!--
Tags:
requestType (water, weather, both) 'both' needs a SINGLE SPECIFIC site code, 'weather' needs LAT/Long and optional days limit
waterway (searching a state for waterways)
state (all waterways in a state or for searching with waterway)
sites (comma seperated list for water requests)
results (number of results for water request)
lat (latitude for weather request)
long (longitude for weather request)
days (number of days for weather request)
displayType (text, map) isnt always needed

sites will take precedence over state and waterway
-->
<title>Waterway Browser

<?php
$output = '';
if(isset($_GET['state'])) $output .= ' - '.$_GET['state'];
if(isset($_GET['waterway'])) $output .= ' - '.$_GET['waterway'];

echo $output;

?>

</title>
</head>

<body>
<center>
<form id="search" method="get" action="">
<select name="state" id="state">
<option value="ALL">ALL</option>
<option value="AL">ALABAMA</option>
<option value="AK">ALASKA</option>
<option value="AZ">ARIZONA</option>
<option value="AR">ARKANSAS</option>
<option value="CA">CALIFORNIA</option>
<option value="CO">COLORADO</option>
<option value="CT">CONNECTICUT</option>
<option value="DE">DELAWARE</option>
<option value="FL">FLORIDA</option>
<option value="GA">GEORGIA</option>
<option value="HI">HAWAII</option>
<option value="ID">IDAHO</option>
<option value="IL">ILLINOIS</option>
<option value="IN">INDIANA</option>
<option value="IA">IOWA</option>
<option value="KS">KANSAS</option>
<option value="KY">KENTUCKY</option>
<option value="LA">LOUISIANA</option>
<option value="ME">MAINE</option>
<option value="MD">MARYLAND</option>
<option value="MA">MASSACHUSETTS</option>
<option value="MI">MICHIGAN</option>
<option value="MN">MINNESOTA</option>
<option value="MS">MISSISSIPPI</option>
<option value="MO">MISSOURI</option>
<option value="MT">MONTANA</option>
<option value="NE">NEBRASKA</option>
<option value="NV">NEVADA</option>
<option value="NH">NEW HAMPSHIRE</option>
<option value="NJ">NEW JERSEY</option>
<option value="NM">NEW MEXICO</option>
<option value="NY">NEW YORK</option>
<option value="NC">NORTH CAROLINA</option>
<option value="ND">NORTH DAKOTA</option>
<option value="OH">OHIO</option>
<option value="OK">OKLAHOMA</option>
<option value="OR">OREGON</option>
<option value="PA">PENNSYLVANIA</option>
<option value="RI">RHODE ISLAND</option>
<option value="SC">SOUTH CAROLINA</option>
<option value="SD">SOUTH DAKOTA</option>
<option value="TN">TENNESSEE</option>
<option value="TX">TEXAS</option>
<option value="UT">UTAH</option>
<option value="VT">VERMONT</option>
<option value="VA">VIRGINIA</option>
<option value="WA">WASHINGTON</option>
<option value="WV">WEST VIRGINIA</option>
<option value="WI">WISCONSIN</option>
<option value="WY">WYOMING</option>
</select>
<input type="text" name="waterway" id="waterway"></input>
<input type="submit">
</form>

<div id="map" style="width: 900px; height: 500px;"></div>
<div id="weather" style="text-align: left; width: 900px; height: 400px;"></div></center>
<?php

include('WaterWeatherWrapper.php');

?>
</center>
</body>
</html>
