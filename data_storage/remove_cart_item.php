<?php
    
    include("access_mongo.php");

    $user_id = $_GET['user_id'];
    $product_id = $_GET['product_id'];

    // Check if the cart item exists
    $filter = array('PRODUCTID' => intval($product_id), 'USERID' => strval($user_id));
    $query = $carts->find($filter)->toArray();

    //  If it doesn't exist do nothing
    if(is_null($query) || count($query) < 1 ){
        die;
    
    // If it exists remove it
    }else{

        $delete_filter = array('PRODUCTID' => intval($product_id), 'USERID' => strval($user_id));
        $answer = $carts->deleteOne($delete_filter);
        echo json_encode($answer);
        die;
    }
?>