<?php

    include("access_mongo.php");

    $user_id = $_GET['user_id'];
    $product_id = $_GET['product_id'];
    $subscription_id = $_GET['subscription_id'];
    
    // Add subscription to MongoDB
    $insert_filter = array('ID'=>strval($subscription_id), 'PRODUCTID'=>intval($product_id), 'USERID'=>strval($user_id));
    $akn = $subscriptions->insertOne($insert_filter);
    die;

?>