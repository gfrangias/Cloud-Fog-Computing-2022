<?php

    include 'db_connect.php';

    session_start();
    
    if(!($_SESSION['role'] === "PRODUCTSELLER")){
        
        header("Location: no_access.php");
        exit();
    }

    $conn = OpenCon();

    $seller_id = $_SESSION['ID'];
    $id = $_POST['remove_id'];

    $check_product_ownership = mysqli_query($conn, "SELECT count(*) FROM products 
    WHERE products.SELLERID= '$seller_id' AND products.ID = '$id'");

    if($check_product_ownership >=1){
    mysqli_query($conn, "DELETE FROM products where products.ID = '$id'");
    }
    
?>