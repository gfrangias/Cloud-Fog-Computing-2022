<?php

    include 'transform_dates.php';

    session_start();
    
    if(!($_SESSION['role'] === "PRODUCTSELLER")){
        
        header("Location: ../redirections/no_access.php");
        exit();
    }

    $name = $_POST['name'];
    $code = $_POST['code'];
    $price = $_POST['price'];
    $availability = $_POST['availability'];
    $withdrawal = $_POST['withdrawal'];
    $category = $_POST['category'];
    $category = str_replace('&','%26',$category);
    $id = $_SESSION['id'];

    $user_id = $_SESSION['id'];
    $seller_name = $_SESSION['name'];

    // Add product to MongoDB
    $url = "http://wilma_data_storage:1027/add_product.php?seller_id=".$id."&name=".$name."&code=".$code.
    "&price=".$price."&availability=".$availability."&withdrawal=".$withdrawal."&seller_name=".$seller_name."&category=".$category;
    $url = str_replace(' ','%20',$url);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$_SESSION['oauth_token']));
    $result = curl_exec($ch);
    curl_close($ch);
    $product_id = json_decode($result,true);

    // Create Orion entity for product
    $withdrawal_timestamp = date_to_timestamp($withdrawal);
    $availability_timestamp = date_to_timestamp($availability);

    $change_flag = "0";

    $id = $product_id;
    $id = preg_replace('/\s+/', '', $id);
    $sold_out = "0";
    
    $curl = curl_init();
    
    // set the POST request body and parameters
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'http://wilma_orion:1028/v2/entities', // use orion-proxy (PEP Proxy for Orion CB) IP address and port instead of Orion CB's 
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
        "id": "'.$id.'",
        "type": "Product",
        "availability": {
            "value": "'.$availability_timestamp.'",
            "type": "Date"
        },
        "withdrawal": {
            "value": "'.$withdrawal_timestamp.'",
            "type": "Date"
        },
        "sold_out": {
            "value": "'.$sold_out.'",
            "type": "Boolean"
        },
        "change_flag": {
            "value": "'.$change_flag.'",
            "type": "Number"
        }
      }',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'X-Auth-Token: '.$_SESSION['oauth_token'].'',
        'Accept: application/json'
      ),
    ));
    
    $response = curl_exec($curl); // send request and get response 
    
    curl_close($curl);
    echo $response; 


?>