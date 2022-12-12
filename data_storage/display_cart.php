<?php

include("access_mongo.php");

$user_id = $_GET['user_id'];
$filter = array('USERID' => strval($user_id));
$answer = $carts->find($filter)->toArray();
$find_products = array();

foreach($answer as $row){
    $products_filter = array('ID'=>intval($row['PRODUCTID']));
    $products_aggr = ['projection' => ['ID'=>1, 'SELLERNAME'=>1, 'NAME'=>1, 'PRICE'=>1, 'CATEGORY'=>1]];
    $one_product = $products->find($products_filter,$products_aggr)->toArray();
    $one_product = trim(json_encode($one_product, JSON_PRETTY_PRINT),'[]');
    $one_product = json_decode($one_product,true);
    $insertion_date = json_decode($row['DATEOFINSERTION'],true);
    $insertion_date = $insertion_date / 1000;
    $insertion_date = date( "Y-m-d H:i:s", $insertion_date);
    $one_product['DATEOFINSERTION'] = $insertion_date;
    array_push($find_products, $one_product);
}

echo json_encode($find_products, JSON_PRETTY_PRINT);

die;

?>