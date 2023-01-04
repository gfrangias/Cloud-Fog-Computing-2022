<?php

//session_start();
//$oath2token = $_SESSION["oauth_token"]; // get oauth2token from session variable

// get data coming from an HTML form
$oath2token = $_POST['oauth_token'];  
$product_id = $_POST['product_id'];
$availability = $_POST['availability'];
$sold_out = $_POST['sold_out'];

$curl = curl_init();

// set the POST request body and parameters
curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://orion:1026/v2/entities', // use orion-proxy (PEP Proxy for Orion CB) IP address and port instead of Orion CB's 
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "id": "'.$product_id.'",
    "type": "Product",
    "product": 
    "availability": {
        "value": "'.$availability.'",
        "type": "Date"
    },
    "withdrawal": {
        "value": "'.$withdrawal.'",
        "type": "Date"
    },
    "sold_out": {
        "value": "'.$sold_out.'",
        "type": "Boolean"
    }  
  }',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'X-Auth-Token: '.$oath2token.'',
    'Accept: application/json'
  ),
));

$response = curl_exec($curl); // send request and get response 

curl_close($curl);
echo $response; 

?>