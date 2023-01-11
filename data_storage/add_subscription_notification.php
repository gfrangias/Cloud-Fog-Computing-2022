<?php

    include("access_mongo.php");
    include("transform_dates.php");

    // Get the input of Orion upon update of product entity
    $orion_result = json_decode(file_get_contents("php://input"),true);
    
    // Extract useful fields of the input
    $availability = $orion_result['data'][0]['availability']['value'];
    $withdrawal = $orion_result['data'][0]['withdrawal']['value'];
    $sold_out = $orion_result['data'][0]['sold_out']['value'];
    $change_flag = $orion_result['data'][0]['change_flag']['value'];
    $subscription_id = $orion_result['subscriptionId'];
    $product_id = $orion_result['data'][0]['id'];

    // Change time format
    $availability = timestamp_to_date($availability);
    $withdrawal = timestamp_to_date($withdrawal);

    // Get the product's name and sold out status
    $filter = array('ID' => intval($product_id));
    $answer = $products->find($filter)->toArray();
    $product_name = $answer[0]['NAME'];
    $sold_out_value = $answer[0]['SOLDOUT'];
    
    // Get the user's id
    $filter = array('ID' => strval($subscription_id));
    $answer = $subscriptions->find($filter)->toArray();
    $user_id = $answer[0]['USERID'];

    // Create the notification message based on the value(s) that changed
    if($change_flag == '1'){
        $message = "New withdrawal time: ".$withdrawal;
    }elseif($change_flag == '2'){
        $message = "New availability time: ".$availability;
    }elseif($change_flag == '3'){
        $message = "New availability time: ".$availability."<br />New withdrawal time: ".$withdrawal;
    }elseif($change_flag == '4'){
        if($sold_out_value){
            $message = "The product is sold out!";
        }else{
            $message = "The product is available again!";
        }
    }elseif($change_flag == '5'){
        if($sold_out_value){
            $message = "The product is sold out!<br />New withdrawal time: ".$withdrawal;
        }else{
            $message = "The product is available again!<br />New withdrawal time: ".$withdrawal;
        }    
    }elseif($change_flag == '6'){
        if($sold_out_value){
            $message = "The product is sold out!<br />New availability time: ".$availability;
        }else{
            $message = "The product is available again!<br />New availability time: ".$availability;
        } 
    }elseif($change_flag == '7'){
        if($sold_out_value){
            $message = "The product is sold out!<br />New availability time: ".$availability."<br />New withdrawal time: ".$withdrawal;
        }else{
            $message = "The product is available again!<br />New availability time: ".$availability."<br />New withdrawal time: ".$withdrawal;
        } 
    }

    if($change_flag !=0){

        $creation = time() * 1000;

        // Create the notification
        $insert_filter = array('USERID'=>strval($user_id), 'PRODUCTNAME'=>strval($product_name), 'MESSAGE'=>strval($message),
        'CREATION'=>new MongoDB\BSON\UTCDateTime($creation));
        $akn = $notifications->insertOne($insert_filter);

    }
?>