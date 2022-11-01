<?php

    include 'db_connect.php';

    session_start();
    
    if(!($_SESSION['role'] === "PRODUCTSELLER")){
        
        header("Location: no_access.php");
        exit();
    }

    $conn = OpenCon();

    $seller_id = $_SESSION['ID'];
    $id = $_POST['id'];

    $check_product_ownership = mysqli_query($conn, "SELECT count(*) FROM products 
    WHERE products.SELLERID= '$seller_id' AND products.ID = '$id'");

    if($check_product_ownership >=1){
        
        $name = $_POST['name'];
        $code = $_POST['code'];
        $price = $_POST['price'];
        $withdrawal = $_POST['withdrawal']; 
        $category = $_POST['category'];

        mysqli_query($conn, "UPDATE products SET NAME = '$name', PRODUCTCODE = '$code', PRICE = '$price', 
        DATEOFWITHDRAWAL = '$withdrawal', CATEGORY = '$category' WHERE ID = '$id'");
    
    }
?>