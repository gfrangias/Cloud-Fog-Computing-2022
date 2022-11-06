<?php

    session_start();
    include 'db_connect.php';

    if(!($_SESSION['role'] === "USER")){
        
        header("Location: no_access.php");
        exit();
    }

    $url = "http://172.23.0.1:27017/remove_cart_item.php?product_id=".$_POST['remove_id']."&user_id=".$_SESSION['id'];   
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $result = curl_exec($ch);
    curl_close($ch);

?>