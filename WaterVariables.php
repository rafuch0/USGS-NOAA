<?php
if(isset($_GET["state"])) $state = basename(strip_tags(strval($_GET["state"])));
else if(!isset($state)) $state = "nostate";

if(isset($_GET["waterway"])) $waterway = basename(strip_tags(strval($_GET["waterway"])));
else if(!isset($waterway)) $waterway = "";

if(isset($_GET["sites"])) $sites = basename(strip_tags(strval($_GET["sites"])));
else if(!isset($sites)) $sites = "nosites";

if(isset($_GET["results"])) $results = basename(strip_tags(strval($_GET["results"])));
else if(!isset($results)) $results = $maxResults;

if(isset($_GET["displayType"])) $displayType = basename(strip_tags(strval($_GET["displayType"])));
else if(!isset($displayType)) $displayType = 'text';

?>
