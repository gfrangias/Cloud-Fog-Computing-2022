<?php

    include 'db_connect.php';

    session_start();
    
    if(!($_SESSION['role'] === "USER")){
        
        header("Location: no_access.php");
        exit();
    }

    $conn = OpenCon();

    $id = $_POST['remove_id'];
    mysqli_query($conn, "DELETE FROM carts where carts.ID = '$id'");
   ?>