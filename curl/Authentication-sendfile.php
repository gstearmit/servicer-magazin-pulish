<?php
$ch = curl_init(); 
//$url="https://build.phonegap.com/api/v1/me";
$url="https://build.phonegap.com/api/v1/apps/933115";

$username = 'gstearmitphuca4@gmail.com';
$password = 'ngoc8750phuca4';
$dir = dirname(__FILE__).'AppAlatcaEn.zip';
$data = array("title"=>"testtting phuc","package"=>"com.alatca.vn","version"=>"0.1.0","create_method"=>"file");
$jsdata = json_encode($data);

// Set CURL options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_USERPWD,"$username:$password");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_PUT, 1);
//curl_setopt($ch, CURLOPT_POST, true);
// curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1000);
// curl_setopt($ch, CURLOPT_TIMEOUT, 10000 );
curl_setopt(
		$ch,
		CURLOPT_POSTFIELDS,
		array(
		'data' => $jsdata,
		'file' =>'@'. $dir,
		'filename'=>"AppAlatcaEn"
		));

// echo 'Hoang Phuc';
// var_dump($ch);



$output = curl_exec($ch); // execute the curl
$obj = json_decode($output);
if (curl_error($ch))
{
	print curl_error($ch);
}
else
{
	print 'ret: ' .$output;
}

curl_close($ch); // close the curl 
































// echo '</br> Uploadfile ';
// // var_dump($obj) ;
// // echo "</br>";


// $request = curl_init('https://build.phonegap.com/api/v1/apps/933115');

// // send a file
// curl_setopt($request, CURLOPT_URL, $url);
// curl_setopt($request,CURLOPT_USERPWD,"$username:$password");
// curl_setopt($request, CURLOPT_PUT, 1);
// //curl_setopt($request, CURLOPT_POST, true);
// // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1000);
// // curl_setopt($ch, CURLOPT_TIMEOUT, 10000 );
// curl_setopt(
// 		$request,
// 		CURLOPT_POSTFIELDS,
// 		array(
// 		'data' => $jsdata,
// 		'file' =>
// 		'@'            . $dir
// 		. ';filename=' . "appmagazine"
// 		));


// curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
// 		// output the response
// curl_setopt($request, CURLOPT_RETURNTRANSFER, true);

// $returned = curl_exec($request);

// // $obj344 = json_decode($returned);

// // var_dump($obj344);

// if (curl_error($request))
// 		{
// 			print curl_error($request);
// 		}
// else
// 		{
// 			print 'json: ' .$returned;
// 		}

// 		// close the session
// curl_close($request);




?>