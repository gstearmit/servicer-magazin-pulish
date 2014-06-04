<?php
$ch = curl_init(); // Initialize Curl
$url="https://build.phonegap.com/api/v1/me"; //API url to view applications.

$username = 'gstearmitphuca4@gmail.com';
$password = "ngoc8750phuca4";

$data = array("title"=>"testtting phuc","package"=>"com.alatca.vn","version"=>"0.1.0","create_method"=>"file");

$jsdata = json_encode($data);
$token ='ASTRINGTOKEN' ;
// Set CURL options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_USERPWD,"$username:$password");
curl_setopt($ch, CURLOPT_URL, 'https://build.phonegap.com/api/v1/me?auth_token='.$token); //got this token already, so using that here .
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, array('data' => $jsdata, 'file'=>'@E:/xampp/htdocs/alastca-tester-vn/build_v3/appmagazine.zip'));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//echo curl_exec($ch); 
$output = curl_exec($ch); // execute the curl
//$obj = json_decode($output);

if(curl_exec($ch) === false){
	echo 'Curl error: ' . curl_error($ch);
	print_r(error_get_last());
} else {
	var_dump(curl_exec($ch));
	echo curl_exec($ch);
	echo 'Operation completed without any errors';
}
curl_close($ch); // close the curl
?>