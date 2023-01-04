<?php
    
    include("access_mongo.php");

    $user_id = $_GET['user_id'];
    $product_id = $_GET['product_id'];
    $filter = array('PRODUCTID' => intval($product_id), 'USERID' => strval($user_id));
    $answer = $subscriptions->find($filter)->toArray();
    echo json_encode($answer, JSON_PRETTY_PRINT);

    die;
?>