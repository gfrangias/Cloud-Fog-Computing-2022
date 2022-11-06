<?php

    include 'db_connect.php';

    session_start();
    
    if(!($_SESSION['role'] === "PRODUCTSELLER")){
        
        header("Location: no_access.php");
        exit();
    }

    

location.replace("../seller.php")
?>