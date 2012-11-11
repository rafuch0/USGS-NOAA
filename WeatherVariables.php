<?php
if(isset($_GET["lat"])) $lat = basename(strip_tags(strval($_GET["lat"])));
else if(!isset($lat)) $lat = "nolat";

if(isset($_GET["long"])) $long = basename(strip_tags(strval($_GET["long"])));
else if(!isset($long)) $long = "nolong";

if(isset($_GET["days"])) $days = basename(strip_tags(strval($_GET["days"])));
else if(!isset($days)) $days = $defaultDays;
$days = ($days > 7)?7:$days;
$days = ($days < 1)?1:$days;
?>
