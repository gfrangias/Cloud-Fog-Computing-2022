<?php

    include("access_mongo.php");
    include("transform_dates.php");

    $seller_id = $_GET['seller_id'];
    $product_id = $_GET['product_id'];
    $name = $_GET['name'];
    $code = $_GET['code'];
    $price = $_GET['price'];
    $availability = $_GET['availability'];
    $withdrawal = $_GET['withdrawal'];
    $category = $_GET['category'];
    $soldout = $_GET['soldout'];

    // Transform dates to timestamps in order to store in MongoDB
    $withdrawal_obj = date_to_timestamp($withdrawal);
    $availability_obj = date_to_timestamp($availability);

    // Check if the product already exists
    $filter = array('ID' => intval($product_id), 'SELLERID' => strval($seller_id));
    $query = $products->find($filter)->toArray();

    // If it doesn't exist do nothing
    if(is_null($query) || count($query) < 1 ){
        die;

    // If it exists edit it
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