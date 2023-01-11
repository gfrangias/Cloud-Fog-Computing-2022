<?php

    include("access_mongo.php");
    include("transform_dates.php");

    $seller_id = $_GET['seller_id'];
    $name = $_GET['name'];
    $code = $_GET['code'];
    $price = $_GET['price'];
    $availability = $_GET['availability'];
    $withdrawal = $_GET['withdrawal'];
    $seller_name = $_GET['seller_name'];
    $category = $_GET['category'];

    // Transform dates to timestamps in order to store in MongoDB
    $withdrawal_obj = date_to_timestamp($withdrawal);
    $availability_obj = date_to_timestamp($availability);

    // Find the greatest ID in the collection to create the new product's ID
    $id_filter = [];
    $id_options = ['projection' => ['ID'=>1], 'sort'=>['$natural'=>-1], 'limit'=>1];
    $greater_id = $products->find($id_filter,$id_options)->toArray();
    $new_id = $greater_id[0]['ID']+1;

    // Insert new product to MongoDB
    $insert_filter = array('ID'=>intval($new_id), 'NAME'=>strval($name), 'PRODUCTCODE'=>strval($code),
    'PRICE'=>new MongoDB\BSON\Decimal128($price), 'DATEOFAVAILABILITY'=>new MongoDB\BSON\UTCDateTime($availability_obj),
    'DATEOFWITHDRAWAL'=>new MongoDB\BSON\UTCDateTime($withdrawal_obj), 'SELLERNAME'=>strval($seller_name),
    'SELLERID'=>strval($seller_id), 'SOLDOUT'=>boolval(0), 'CATEGORY'=>strval($category));

    $products->insertOne($insert_filter);
    echo json_encode($new_id, JSON_PRETTY_PRINT);
    die;

?>