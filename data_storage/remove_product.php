<?php

    include("access_mongo.php");
    $seller_id = $_GET['seller_id'];
    $product_id = $_GET['product_id'];

    // Check if the product exists
    $filter = array('ID' => intval($product_id), 'SELLERID' => strval($seller_id));
    $query = $products->find($filter)->toArray();

    // If it doesn't exist do nothing
    if(is_null($query) || count($query) < 1 ){
        die;

    // If it exists remove it
    }else{

        $delete_filter = array('ID' => intval($product_id), 'SELLERID' => strval($seller_id));                              
        $answer = $products->deleteOne($delete_filter);
        echo json_encode($answer);
        die;
    }

?>