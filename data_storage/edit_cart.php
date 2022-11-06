<?php
    
    include("access_mongo.php");
    $user_id = $_GET['user_id'];
    $product_id = $_GET['product_id'];
    $filter = array('PRODUCTID' => intval($product_id), 'USERID' => intval($user_id));
    $query = $carts->find($filter)->toArray();
    if(is_null($query) || count($query) < 1 ){
        $id_filter = [];
        $id_options = ['projection' => ['ID'=>1], 'sort'=>['$natural'=>-1], 'limit'=>1];
        $greater_id = $carts->find($id_filter,$id_options)->toArray();
        $new_id = $greater_id[0]['ID']+1;

        $insert_filter = array('ID'=>intval($new_id), 'PRODUCTID'=>intval($product_id), 'USERID'=>intval($user_id));
        $akn = $carts->insertOne($insert_filter);
        echo $akn;
        die;
    }else{

        $delete_filter = array('PRODUCTID' => intval($product_id), 'USERID' => intval($user_id));
        $answer = $carts->deleteOne($delete_filter);
        echo json_encode($answer);
        die;
    }
?>