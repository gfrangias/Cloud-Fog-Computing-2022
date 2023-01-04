<?php
    session_start();
    include 'db_connect.php';

    session_start();
    
    if(!($_SESSION['role'] === "USER")){
        
        header("Location: no_access.php");
        exit();
    }
    $url = "http://wilma_data_storage:1027/edit_subscription.php?product_id=".$_POST['product_id']."&user_id=".$_SESSION['id'].
    "&availability=".$_POST['availability']."&withdrawal=".$_POST['withdrawal']."&sold_out=".$_POST['sold_out'];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$_SESSION['oauth_token']));
    $result = curl_exec($ch);
    curl_close($ch);

?>