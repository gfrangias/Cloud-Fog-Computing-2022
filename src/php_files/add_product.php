<?php

    include 'db_connect.php';

    session_start();
    
    if(!($_SESSION['role'] === "PRODUCTSELLER")){
        
        header("Location: no_access.php");
        exit();
    }

    $conn = OpenCon();

    $name = $_POST['name'];
    $code = $_POST['code'];
    $price = $_POST['price'];
    $withdrawal= $_POST['withdrawal'];
    $category = $_POST['category']; 
    $seller_id = $_SESSION['id'];
    $seller_name = $_SESSION['name']." ".$_SESSION['surname'];

    $check_max_id = mysqli_query($conn, "SELECT products.ID FROM products ORDER BY products.ID DESC LIMIT 1");

    $row = $check_max_id->fetch_assoc();
    $id = (int) $row['ID'] + 1;

    mysqli_query($conn, "INSERT INTO products (ID, NAME, PRODUCTCODE, PRICE, DATEOFWITHDRAWAL, SELLERNAME, SELLERID, CATEGORY) 
    VALUES ('$id','$name','$code','$price','$withdrawal','$seller_name','$seller_id','$category')");

location.replace("../seller.php")
?>