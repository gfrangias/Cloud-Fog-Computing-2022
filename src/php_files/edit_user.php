<?php

    include 'db_connect.php';
    
    session_start();
    
    if(!($_SESSION['role'] === "ADMIN")){
        
        header("Location: no_access.php");
        exit();
    }

    $conn = OpenCon();

    $id = $_POST['id'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $confirmed = $_POST['confirmed'];
    mysqli_query($conn, "UPDATE users SET NAME = '$name', SURNAME = '$surname', USERNAME = '$username', EMAIL = '$email',
    ROLE = '$role', CONFIRMED = '$confirmed'
    WHERE ID = '$id'");
?>