<?php

    include("access_mongo.php");
    $seller_id = $_GET['seller_id'];
    $product_id = $_GET['product_id'];

    $filter = array('ID' => intval($product_id), 'SELLERID' => intval($seller_id));
    $query = $products->find($filter)->toArray();
    if(is_null($query) || count($query) < 1 ){
        die;
    }else{

        $delete_filter = array('ID' => intval($product_id), 'SELLERID' => intval($seller_id));                              
        $answer = $products->deleteOne($delete_filter);
        echo json_encode($answer);
        die;
    }

?>