<?php
$url= "https://build.phonegap.com/api/v1/apps/933115"; 
$ch= curl_init(); 
$path_to_file ="E:\xampp\htdocs\alastca-tester-vn\build_v3\appmagazine.zip";
// ... curl setup lines .... 
//$data="{\"title\":\"API V1 App\",\"package\":\"com.alunny.apiv1\",\"version":\"0.1.0\",\"create_method\":\"file\"}";
//$data="{"title":"API V1 App","package":"com.alunny.apiv1","version":"0.1.0","create_method":"file"}";

curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt($ch,CURLOPT_USERPWD,"gstearmitphuca4@gmail.com:ngoc8750phuca4");
//curl_setopt($data, CURLOPT_HTTPHEADER,
 //           array(
 //             "Authorization: Basic " . base64_encode($username . ":" . $password)
//));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); 
curl_setopt($ch, CURLOPT_POSTFIELDS, array( 
"file" => "@". $path_to_file, 
)); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
$reply= curl_exec($ch); 
var_dump($ch);

//curl_close($ch); 

if(curl_exec($ch) === false){
      echo 'Curl error: ' . curl_error($ch);
      print_r(error_get_last());
} else {
      echo 'Operation completed without any errors';
	  }
curl_close($ch);
$response = json_decode($reply, true); 

?>