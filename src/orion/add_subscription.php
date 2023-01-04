<?php

//session_start();
//$oath2token = $_SESSION["oauth_token"]; // get oauth2token from session variable

// get data coming from an HTML form  
$oath2token = $_POST["oauth_token"]; // get oauth2token from session variable
$user_id = $_POST['user_id'];
$product_id = $_POST['product_id'];


$curl = curl_init();
// set the POST request body and parameters
curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://orion:1026/v2/subscriptions/', // use orion-proxy (PEP Proxy for Orion CB) IP address and port instead of Orion CB's 
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_POST => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
  "description": "User '.$user_id.' subscribed to product '.$product_id.'",
  "subject": {
      "entities": [
          {
              "id": "'.$product_id.'",
              "type": "Product"
          }
      ],
      "condition": {
          "attrs": [
              "availability",
              "withdrawal",
              "soldout"
          ]
      }
   },
   "notification": {
      "http": {
          "url": "http://172.16.0.6:80/notifications/add_subscription_notification.php"
      }, 
      "attrs": [
        "availability",
        "withdrawal",
        "soldout"
    ]
   },
  "expires": "2030-01-01T14:00:00.00Z",
  "throttling": 3
  }',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'X-Auth-Token: '.$oath2token.'',
    'Accept: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
?>
