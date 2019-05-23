<?php
include_once("./class/config.php");

date_default_timezone_set('Asia/Colombo');


$date = new DateTime();
$timestamp = $date->getTimestamp();
$integer_date = idate('w', $timestamp);
$current_date = date("Y-m-d");


$current_time = date("H:i");

// Get cURL resource
$curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $serverUrl."schedule-summary?type=bus",
]);
// Send the request & save response to $resp
$resp = curl_exec($curl);
// Close request to clear up some resources
curl_close($curl);

$result_schedule=json_decode($resp,true);