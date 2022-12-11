<?php

include 'php_files/http_parse_headers.php';

$admin_login = array("name"=>"gfrangias@tuc.gr","password"=>"1234");

$curl_session = curl_init();

curl_setopt($curl_session, CURLOPT_URL, "http://keyrock:3005/v1/auth/tokens");
curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl_session, CURLOPT_HEADER, 1);
curl_setopt($curl_session, CURLOPT_POST, TRUE);
curl_setopt($curl_session, CURLOPT_HTTPHEADER, array("Content-Type:application/json"));
curl_setopt($curl_session, CURLOPT_POSTFIELDS, json_encode($admin_login));

$admin_result = curl_exec($curl_session);
$header_size = curl_getinfo($curl_session, CURLINFO_HEADER_SIZE);
$header = substr($admin_result, 0, $header_size);
$parsed_header = http_parse_headers($header);
curl_close($curl_session);

$x_token = $parsed_header['X-Subject-Token'];

echo $x_token;

?>