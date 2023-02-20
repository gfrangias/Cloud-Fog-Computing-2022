<?php
    
    include("access_mongo.php");

    $product_id = $_GET['product_id'];

    // Get this product's info
    $filter = array('ID' => intval($product_id));
    $answer = $products->find($filter)->toArray();
    echo json_encode($answer, JSON_PRETTY_PRINT);

    die;
?>