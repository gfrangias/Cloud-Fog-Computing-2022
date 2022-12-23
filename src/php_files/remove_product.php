<?php

    include 'db_connect.php';

    //$_SESSION['id'] = 12;
    //$_SESSION['role'] = "PRODUCTSELLER";
    session_start();
    
    if(!($_SESSION['role'] === "PRODUCTSELLER")){
        
        header("Location: no_access.php");
        exit();
    }


    $seller_id = $_SESSION['id'];
    $product_id = $_POST['remove_id'];
    
    $url = "http://wilma_data_storage:1027/remove_product.php?seller_id=".$seller_id."&product_id=".$product_id;

    echo $url;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$_SESSION['oauth_token']));
    $result = curl_exec($ch);
    curl_close($ch);

?>