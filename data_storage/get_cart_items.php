<?php

    include("access_mongo.php");

    $user_id = $_GET['user_id'];

    // Find all the cart items that belong to this user
    $filter = array('USERID' => strval($user_id));
    $options = array('projection' => ['PRODUCTID'=>1]);
    $answer = $carts->find($filter, $options)->toArray();

    $products_in_cart = [];
    foreach($answer as $row){
        $product_id = $row['PRODUCTID'];
        array_push($products_in_cart, $product_id);
    }
    echo json_encode($products_in_cart, JSON_PRETTY_PRINT);

    die;

?>