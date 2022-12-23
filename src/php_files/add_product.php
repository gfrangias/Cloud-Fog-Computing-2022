<?php

    include 'db_connect.php';

    session_start();
    
    if(!($_SESSION['role'] === "PRODUCTSELLER")){
        
        header("Location: no_access.php");
        exit();
    }

    $name = $_POST['name'];
    $code = $_POST['code'];
    $price = $_POST['price'];
    $withdrawal = $_POST['withdrawal'];
    $category = $_POST['category'];
    $category = str_replace('&','%26',$category);
    $id = $_SESSION['id'];

    $conn = OpenCon();
    $answer = mysqli_query($conn, "SELECT users.NAME, users.SURNAME FROM users WHERE users.ID = '$id'");
    $answer = mysqli_fetch_row($answer);
    echo json_encode($answer, JSON_PRETTY_PRINT);
    CloseCon($conn);
    
    $seller_name = $answer[0]." ".$answer[1];
    echo $seller_name;

    $url = "http://wilma_data_storage:1027/add_product.php?seller_id=".$id."&name=".$name."&code=".$code.
    "&price=".$price."&withdrawal=".$withdrawal."&seller_name=".$seller_name."&category=".$category;
    $url = str_replace(' ','%20',$url);

    echo $url;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$_SESSION['oauth_token']));
    $result = curl_exec($ch);
    curl_close($ch);

?>