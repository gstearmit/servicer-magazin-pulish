<?php
$ch = curl_init(); // Initialize Curl
$url="https://build.phonegap.com/api/v1/me"; //API url to view applications.

$username = 'gstearmitphuca4@gmail.com';
$password = 'ngoc8750phuca4';

// Set CURL options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_USERPWD,"$username:$password");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$output = curl_exec($ch); // execute the curl
$obj = json_decode($output);

// //iterate over applications to get app names
// foreach($obj->apps->all as $app){
// 	echo '<pre>'.$app->title.'</pre>';
// }

curl_close($ch); // close the curl 

var_dump($obj) ;
?>