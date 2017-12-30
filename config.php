<?php

header('Content-Type: text/html; charset=utf-8');
set_time_limit(0);
date_default_timezone_set('UTC');
require __DIR__.'/vendor/autoload.php';
\InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;

$username = "YOUR_USERNAME";
$password = "YOUR_PASS";
$debug = false;
$truncatedDebug = false;

$showStoryUsername = "fenerbahce";

?>
