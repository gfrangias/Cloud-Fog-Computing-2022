<?php
    
    include("access_mongo.php");
    $seller_id = $_GET['seller_id'];

    // Find all the products of this seller
    $filter = array('SELLERID' => strval($seller_id));
    $answer = $products->find($filter)->toArray();
    echo json_encode($answer, JSON_PRETTY_PRINT);

    die;
?>