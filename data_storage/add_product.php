<?php

    include("access_mongo.php");

    $seller_id = $_GET['seller_id'];
    $name = $_GET['name'];
    $code = $_GET['code'];
    $price = $_GET['price'];
    $withdrawal = $_GET['withdrawal'];
    $seller_name = $_GET['seller_name'];
    $category = $_GET['category'];

    $timestamp = DateTime::createFromFormat('Y-m-d H:i:s', $withdrawal);
    $timestamp = $timestamp->getTimestamp()*1000;

    $id_filter = [];
    $id_options = ['projection' => ['ID'=>1], 'sort'=>['$natural'=>-1], 'limit'=>1];
    $greater_id = $products->find($id_filter,$id_options)->toArray();
    $new_id = $greater_id[0]['ID']+1;

    $insert_filter = array('ID'=>intval($new_id), 'NAME'=>strval($name), 'PRODUCTCODE'=>strval($code),
    'PRICE'=>new MongoDB\BSON\Decimal128($price), 'DATEOFWITHDRAWAL'=>new MongoDB\BSON\UTCDateTime($timestamp), 'SELLERNAME'=>strval($seller_name),
    'SELLERID'=>intval($seller_id), 'CATEGORY'=>strval($category));

    $products->insertOne($insert_filter);
    die;

?>