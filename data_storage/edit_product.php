<?php

    include("access_mongo.php");

    $seller_id = $_GET['seller_id'];
    $product_id = $_GET['product_id'];
    $name = $_GET['name'];
    $code = $_GET['code'];
    $price = $_GET['price'];
    $withdrawal = $_GET['withdrawal'];
    $category = $_GET['category'];

    echo $seller_id;
    $timestamp = DateTime::createFromFormat('Y-m-d H:i:s', $withdrawal);
    $timestamp = $timestamp->getTimestamp()*1000;

    echo $timestamp;

    $filter = array('ID' => intval($product_id), 'SELLERID' => strval($seller_id));
    $query = $products->find($filter)->toArray();
    if(is_null($query) || count($query) < 1 ){
        die;
    }else{

        $options = array('$set' => array('NAME'=>strval($name), 'PRODUCTCODE'=>strval($code), 
        'PRICE'=>new MongoDB\BSON\Decimal128($price), 'DATEOFWITHDRAWAL'=>new MongoDB\BSON\UTCDateTime($timestamp), 'CATEGORY'=>strval($category)));
        
        $edit_filter = array('ID' => intval($product_id), 'SELLERID' => strval($seller_id));

        $answer = $products->updateOne($edit_filter,$options);
        echo json_encode($answer);
        die;
    }


?>