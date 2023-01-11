<?php
    session_start();
    include 'db_connect.php';
    include 'http_parse_headers.php';

    session_start();
    
    if(!($_SESSION['role'] === "USER")){
        
        header("Location: ../redirections/no_access.php");
        exit();
    }

    $user_id = $_SESSION['id'];
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $notification_url = "http://172.16.0.8:1027/add_subscription_notification.php";

    $url = "http://wilma_data_storage:1027/check_subscription.php?product_id=".$product_id."&user_id=".$user_id;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$_SESSION['oauth_token']));
    $result = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($result,true);
    print_r($result);

    // If there is no subscription create one
    if(count($result) < 1 || is_null($result)){

        $id = $product_id;
        $id = preg_replace('/\s+/', '', $id);
    
        $curl = curl_init();
        // set the POST request body and parameters
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'http://orion:1026/v2/subscriptions/', // use orion-proxy (PEP Proxy for Orion CB) IP address and port instead of Orion CB's 
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_POST => true,
          CURLOPT_HEADER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
          "description": "User '.$user_id.' subscribed to product '.$product_id.'.",
          "subject": {
              "entities": [
                  {
                      "id": "'.$id.'",
                      "type": "Product"
                  }
              ],
              "condition": {
                  "attrs": [
                      "availability",
                      "withdrawal",
                      "sold_out",
                      "change_flag"
                  ]
              }
           },
           "notification": {
              "http": {
                  "url": "'.$notification_url.'"
              }, 
              "attrs": [
                "availability",
                "withdrawal",
                "sold_out",
                "change_flag"
            ]
           },
          "expires": "2030-01-01T14:00:00.00Z",
          "throttling": 3
          }',
          
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer '.$_SESSION['oauth_token'].'',
            'Accept: application/json'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        print_r($response);
        
        // Source https://blog.devgenius.io/how-to-get-the-response-headers-with-curl-in-php-2173b10d4fc5
        $headerSize = curl_getinfo( $curl , CURLINFO_HEADER_SIZE );
        $headerStr = substr( $response , 0 , $headerSize );
        $bodyStr = substr( $response , $headerSize );
        $header = http_parse_headers($headerStr);
        $subscription_id = ltrim($header['Location'],"/v2/subscriptions/");

        // Create a subscription in Data Storage
        $url = "http://wilma_data_storage:1027/add_subscription.php?product_id=".$product_id."&user_id=".
        $user_id."&subscription_id=".$subscription_id;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$_SESSION['oauth_token']));
        $result = curl_exec($ch);
        curl_close($ch);

    // If subscription exists delete it
    }else{

        $subscription_id = $result[0]["ID"];
        
        // Delete it from Orion
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://wilma_orion:1028/v2/subscriptions/'.$subscription_id.'', // use orion-proxy (PEP Proxy for Orion CB) IP address and port instead of Orion CB's 
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "DELETE", 
            CURLOPT_HTTPHEADER => array( 'Authorization: Bearer '.$_SESSION['oauth_token'].'') ,
          ));
          
        $response = curl_exec($curl);
          
        curl_close($curl);

        //Delete it from Data Storage
        $url = "http://wilma_data_storage:1027/remove_subscription.php?product_id=".$product_id."&user_id=".
        $user_id."&user_id=".$user_id;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$_SESSION['oauth_token']));
        $result = curl_exec($ch);
        curl_close($ch);

    }

?>