<?php
    
    include("access_mongo.php");
    $user_id = $_GET['user_id'];
    $product_id = $_GET['product_id'];
    $filter = array('PRODUCTID' => intval($product_id), 'USERID' => strval($user_id));
    $query = $carts->find($filter)->toArray();
    if(is_null($query) || count($query) < 1 ){
        die;
    }else{

        $delete_filter = array('PRODUCTID' => intval($product_id), 'USERID' => strval($user_id));
        $answer = $carts->deleteOne($delete_filter);
        echo json_encode($answer);
        die;
    }
?>