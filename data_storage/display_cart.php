<?php

include("access_mongo.php");

$user_id = $_GET['user_id'];
$filter = array('USERID' => intval($user_id));
$answer = $carts->find($filter)->toArray();
$find_products = array();

foreach($answer as $row){
    $products_filter = array('ID'=>intval($row['PRODUCTID']));
    $one_product = $products->find($products_filter)->toArray();
    $one_product = trim(json_encode($one_product, JSON_PRETTY_PRINT),'[]');
    $one_product = json_decode($one_product,true);
    array_push($find_products, $one_product);
}

echo json_encode($find_products, JSON_PRETTY_PRINT);

die;

?>