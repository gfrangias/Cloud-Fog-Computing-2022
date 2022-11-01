<?php

    include 'db_connect.php';
    session_start();
    
    if(!($_SESSION['role'] === "USER")){
        
        header("Location: no_access.php");
        exit();
    }

    $conn = OpenCon();

    $product_id = $_POST['product_id'];
    $user_id = $_SESSION['id'];

    $query = mysqli_query($conn, "SELECT * FROM carts WHERE carts.PRODUCTID = '$product_id' AND carts.USERID = '$user_id'");

    $cart = mysqli_num_rows($query);

    if($cart >= 1){
        echo "oops";
        mysqli_query($conn, "DELETE FROM carts WHERE carts.PRODUCTID = '$product_id' AND carts.USERID = '$user_id'");

    }else{

        $check_max_id = mysqli_query($conn, "SELECT carts.ID FROM carts ORDER BY carts.ID DESC LIMIT 1");

        $row = $check_max_id->fetch_assoc();
        $id = (int) $row['ID'] + 1;
        date_default_timezone_set('Europe/Athens');
        $time = date("Y-m-d H:i:s");

        mysqli_query($conn, "INSERT INTO carts (ID, USERID, PRODUCTID, DATEOFINSERTION) VALUES ('$id', '$user_id', '$product_id', '$time')");

    }
   ?>