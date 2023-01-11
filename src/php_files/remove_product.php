<?php

    include 'db_connect.php';

    session_start();
    
     if(!($_SESSION['role'] === "PRODUCTSELLER")){
        
        header("Location: ../redirections/no_access.php");
        exit();
    }


    $seller_id = $_SESSION['id'];
    $product_id = $_POST['remove_id'];
    $product_name = $_POST['product_name'];
    
    // Remove product from database
    $url = "http://wilma_data_storage:1027/remove_product.php?seller_id=".$seller_id."&product_id=".$product_id;

    echo $url;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$_SESSION['oauth_token']));
    $result = curl_exec($ch);
    curl_close($ch);


    // Remove product entity from Orion
    $id = $product_id;
    $type = "Product";

    $url = "http://wilma_orion:1028/v2/entities/".$id."?type=".$type;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$_SESSION['oauth_token']));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    $result = curl_exec($ch);
    curl_close($ch);
?>