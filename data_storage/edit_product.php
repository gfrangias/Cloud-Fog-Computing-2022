<?php

    include("access_mongo.php");

    $seller_id = $_GET['seller_id'];
    $product_id = $_GET['product_id'];
    $name = $_GET['name'];
    $code = $_GET['code'];
    $price = $_GET['price'];
    $availability = $_GET['availability'];
    $withdrawal = $_GET['withdrawal'];
    $category = $_GET['category'];
    $soldout = $_GET['soldout'];

    $withdrawal_obj = DateTime::createFromFormat('Y-m-d H:i:s', $withdrawal);
    $withdrawal_obj = $withdrawal_obj->getTimestamp()*1000;
    $availability_obj = DateTime::createFromFormat('Y-m-d H:i:s', $availability);
    $availability_obj = $availability_obj->getTimestamp()*1000;

    $filter = array('ID' => intval($product_id), 'SELLERID' => strval($seller_id));
    $query = $products->find($filter)->toArray();
    if(is_null($query) || count($query) < 1 ){
        die;
    }else{

        $options = array('$set' => array('NAME'=>strval($name), 'PRODUCTCODE'=>strval($code), 
        'PRICE'=>new MongoDB\BSON\Decimal128($price), 'DATEOFAVAILABILITY'=>new MongoDB\BSON\UTCDateTime($availability_obj),
        'DATEOFWITHDRAWAL'=>new MongoDB\BSON\UTCDateTime($withdrawal_obj), 'SOLDOUT'=>boolval($soldout), 'CATEGORY'=>strval($category)));
        
        $edit_filter = array('ID' => intval($product_id), 'SELLERID' => strval($seller_id));

        $answer = $products->updateOne($edit_filter,$options);
        echo json_encode($answer);
        die;
    }


?>