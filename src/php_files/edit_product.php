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
    $withdrawal = $_POST['withdrawal'];
    $category = $_POST['category'];
    $seller_id = $_SESSION['id'];

    $url = "http://data_storage:80/edit_product.php?seller_id=".$seller_id."&product_id=".$product_id."&name=".$name."&code=".$code.
    "&price=".$price."&withdrawal=".$withdrawal."&category=".$category;
    $url = str_replace(' ','%20',$url);

    echo $url;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
?>