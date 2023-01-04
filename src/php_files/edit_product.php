<?php

    include 'db_connect.php';

    session_start();
    
    if(!($_SESSION['role'] === "PRODUCTSELLER")){
        
        header("Location: no_access.php");
        exit();
    }

    $conn = OpenCon();


    $product_id = $_POST['id'];
    $name = $_POST['name'];
    $code = $_POST['code'];
    $price = $_POST['price'];
    $availability = $_POST['availability'];
    $withdrawal = $_POST['withdrawal'];
    $soldout = $_POST['soldout'];
    $category = $_POST['category'];
    $category = str_replace('&','%26',$category);
    $seller_id = $_SESSION['id'];

    $url = "http://wilma_data_storage:1027/edit_product.php?seller_id=".$seller_id."&product_id=".$product_id."&name=".$name."&code=".$code.
    "&price=".$price."&availability=".$availability."&withdrawal=".$withdrawal."&soldout=".$soldout."&category=".$category;
    $url = str_replace(' ','%20',$url);

    echo $url;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$_SESSION['oauth_token']));
    $result = curl_exec($ch);
    curl_close($ch);
?>