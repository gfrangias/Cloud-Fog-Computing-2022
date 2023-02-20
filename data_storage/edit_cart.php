<?php
    
    include("access_mongo.php");
    $user_id = $_GET['user_id'];
    $product_id = $_GET['product_id'];

    // Check if this product is in the cart for this user
    $filter = array('PRODUCTID' => intval($product_id), 'USERID' => strval($user_id));
    $query = $carts->find($filter)->toArray();

    // If it isn't found add it to the cart
    if(is_null($query) || count($query) < 1 ){
        $id_filter = [];
        $id_options = ['projection' => ['ID'=>1], 'sort'=>['$natural'=>-1], 'limit'=>1];
        $greater_id = $carts->find($id_filter,$id_options)->toArray();
        $new_id = $greater_id[0]['ID']+1;
        
        $now = time();
        $now = $now * 1000;
        $insert_filter = array('ID'=>intval($new_id), 'PRODUCTID'=>intval($product_id), 'USERID'=>strval($user_id), 
        'DATEOFINSERTION'=>new MongoDB\BSON\UTCDateTime($now));
        $akn = $carts->insertOne($insert_filter);
        echo $akn;
        die;
    // If it is in the cart remove it
    }else{

        $delete_filter = array('PRODUCTID' => intval($product_id), 'USERID' => strval($user_id));
        $answer = $carts->deleteOne($delete_filter);
        echo json_encode($answer);
        die;
    }
?>