<?php
header('Content-Type: application/json');
error_reporting(0);

//Variables...
$username = 'michael@ignition-innovations.com';
$password = 'Mths3969!';
$api_key = 'TgWhRTuJ9lEw0bbJ6thXB667';
$project_key = $_REQUEST['project'];

// create curl resource
$ch = curl_init();

// set url
$q = 'project=' . $project_key . '+AND+status+NOT+IN+(Done,Closed,Resolved)';
$url = 'https://ignition-innovations.atlassian.net/rest/api/2/search?jql=' . $q;//Search via JQL...



curl_setopt($ch, CURLOPT_URL, $url);

//return the transfer as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

//Create cURL Headers.
$headers = array(
    'Content-Type: application/json',
    'Authorization: Basic '. base64_encode("$username:$api_key")
);
//Set the headers that we want our cURL client to use.
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// $output contains the output string
$output = curl_exec($ch);

$r = json_decode($output);
$x = json_encode($r, JSON_PRETTY_PRINT);
echo $x;

// close curl resource to free up system resources
curl_close($ch);