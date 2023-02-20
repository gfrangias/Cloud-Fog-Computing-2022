<?php
    
    include("access_mongo.php");

    $user_id = $_GET['user_id'];
    $product_id = $_GET['product_id'];
    $availability = $_GET['availability'];
    $withdrawal = $_GET['withdrawal'];
    $sold_out = $_GET['sold_out'];
    
    // Check if the subscription already exists
    $filter = array('PRODUCTID' => intval($product_id), 'USERID' => strval($user_id));
    $query = $subscriptions->find($filter)->toArray();

    // If it doesn't exist create it
    if(is_null($query) || count($query) < 1 ){     
        $insert_filter = array('PRODUCTID'=>intval($product_id), 'USERID'=>strval($user_id), 
        'DATEOFAVAILABILITY'=>new MongoDB\BSON\UTCDateTime($availability), 
        'DATEOFWITHDRAWAL'=>new MongoDB\BSON\UTCDateTime($withdrawal), 'SOLDOUT'=>boolval($sold_out));
        $akn = $subscriptions->insertOne($insert_filter);
        echo $akn;
        die;

    // If it exists remove it
    }else{
        $delete_filter = array('PRODUCTID' => intval($product_id), 'USERID' => strval($user_id));
        $answer = $subscriptions->deleteOne($delete_filter);
        echo json_encode($answer);
        die;
    }
?>