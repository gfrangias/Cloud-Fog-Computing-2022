<?php
    
    include("access_mongo.php");
    $seller_id = $_GET['seller_id'];
    $filter = array('SELLERID' => intval($seller_id));
    $answer = $products->find($filter)->toArray();
    echo json_encode($answer, JSON_PRETTY_PRINT);

    die;
?>