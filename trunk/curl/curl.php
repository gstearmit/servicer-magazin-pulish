<?php
    $url= "https://build.phonegap.com/api/v1/apps/933115";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_USERPWD,"gstearmitphuca4@gmail.com:ngoc8750phuca4");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
   // curl_setopt($ch, CURLOPT_URL, _VIRUS_SCAN_URL);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POST, true);
    $post = array(
        "file"=>"@E:/xampp/htdocs/alastca-tester-vn/build_v3/appmagazine.zip",
    );
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // bo chung thuc
    $response = curl_exec($ch);
    if(curl_exec($ch) === false){
    	echo 'Curl error: ' . curl_error($ch);
    	print_r(error_get_last());
    } else {
    	echo 'Operation completed without any errors';
    }
    curl_close($ch);
 //   $response = json_decode($reply, true);
?>