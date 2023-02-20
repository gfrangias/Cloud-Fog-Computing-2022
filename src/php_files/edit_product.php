<?php

    include 'transform_dates.php';

    session_start();
    
    if(!($_SESSION['role'] === "PRODUCTSELLER")){
        
        header("Location: ../redirections/no_access.php");
        exit();
    }


    $product_id = $_POST['id'];
    $name = $_POST['name'];
    $code = $_POST['code'];
    $price = $_POST['price'];
    $availability = $_POST['availability'];
    $withdrawal = $_POST['withdrawal'];
    $soldout = $_POST['soldout'];
    $sold_out = $soldout;
    $category = $_POST['category'];
    $category = str_replace('&','%26',$category);
    $seller_id = $_SESSION['id'];

    $withdrawal_timestamp = date_to_timestamp($withdrawal);
    $availability_timestamp = date_to_timestamp($availability);

    // Get the old values of this product to find out which fields changes value

    $url = "http://wilma_data_storage:1027/get_product.php?product_id=".$product_id;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$_SESSION['oauth_token']));
    $result = curl_exec($ch);
    curl_close($ch);
    
    $result = json_decode($result,false);
    //print_r($result[0]);

    $old_availability =  $result[0]->DATEOFAVAILABILITY->{'$date'}->{'$numberLong'};
    $old_withdrawal =  $result[0]->DATEOFWITHDRAWAL->{'$date'}->{'$numberLong'};
    $old_sold_out = $result[0]->SOLDOUT;

    $availability_change = False;
    $withdrawal_change = False;
    $sold_out_change = False;

    if($old_availability != $availability_timestamp){
        $availability_change = True;
        echo "Availability changed!";
    }

    if($old_withdrawal != $withdrawal_timestamp){
        $withdrawal_change = True;
        echo "Withdrawal changed!";
    }

    if($old_sold_out != $sold_out){
        $sold_out_change = True;
        echo "Sold out changed!";
    }

    if(!$availability_change && !$withdrawal_change && !$sold_out_change){
        $change_flag = 0;
    }

    if(!$availability_change && $withdrawal_change && !$sold_out_change){
        $change_flag = 1;
    }

    if($availability_change && !$withdrawal_change && !$sold_out_change){
        $change_flag = 2;
    }

    if($availability_change && $withdrawal_change && !$sold_out_change){
        $change_flag = 3;
    }

    if(!$availability_change && !$withdrawal_change && $sold_out_change){
        $change_flag = 4;
    }

    if(!$availability_change && $withdrawal_change && $sold_out_change){
        $change_flag = 5;
    }

    if($availability_change && !$withdrawal_change && $sold_out_change){
        $change_flag = 6;
    }

    if($availability_change && $withdrawal_change && $sold_out_change){
        $change_flag = 7;
    }

    // Change Orion product entity
    $url = "http://wilma_data_storage:1027/edit_product.php?seller_id=".$seller_id."&product_id=".$product_id."&name=".$name."&code=".$code.
    "&price=".$price."&availability=".$availability."&withdrawal=".$withdrawal."&soldout=".$soldout."&category=".$category;
    $url = str_replace(' ','%20',$url);

    echo $url;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$_SESSION['oauth_token']));
    $result = curl_exec($ch);
    curl_close($ch);

    $id = $product_id;
    $id = preg_replace('/\s+/', '', $id);

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => "http://wilma_orion:1028/v2/entities/".$id."/attrs", // use orion-proxy (PEP Proxy for Orion CB) IP address and port instead of Orion CB's 
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'PATCH',
    CURLOPT_POSTFIELDS =>'{
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
        'X-Auth-Token: '.$_SESSION['oauth_token'].''
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;

?>