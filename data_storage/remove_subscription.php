<?php
    
    include("access_mongo.php");
    $user_id = $_GET['user_id'];
    $product_id = $_GET['product_id'];

    // Remove the subscription
    $delete_filter = array('PRODUCTID' => intval($product_id), 'USERID' => strval($user_id));
    $answer = $subscriptions->deleteOne($delete_filter);
    echo json_encode($answer);
    die;
?>