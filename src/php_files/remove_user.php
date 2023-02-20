<?php

    include 'http_parse_headers.php';

    session_start();
    
    if(!($_SESSION['role'] === "ADMIN")){
        
        header("Location: ../redirections/no_access.php");
        exit();
    }

    $user_id = $_POST['remove_id'];

    // Administator login to get X-Auth-Token
    $admin_login = array("name"=>"gfrangias@tuc.gr","password"=>"1234");

    $curl_session = curl_init();
    
    curl_setopt($curl_session, CURLOPT_URL, "http://keyrock:3005/v1/auth/tokens");
    curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl_session, CURLOPT_HEADER, 1);
    curl_setopt($curl_session, CURLOPT_POST, TRUE);
    curl_setopt($curl_session, CURLOPT_POSTFIELDS, json_encode($admin_login));
    curl_setopt($curl_session, CURLOPT_HTTPHEADER, array("Content-Type:application/json"));
    
    $result = curl_exec($curl_session);
    $header_size = curl_getinfo($curl_session, CURLINFO_HEADER_SIZE);
    $header = substr($result, 0, $header_size);
    $parsed_header_admin = http_parse_headers($header);
    curl_close($curl_session);

    $admin_token = $parsed_header_admin['X-Subject-Token'];
    
    // Remove user using Keyrock request
    $curl_session = curl_init();

    curl_setopt($curl_session, CURLOPT_URL, "http://keyrock:3005/v1/users/".$user_id);
    curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl_session, CURLOPT_HEADER, FALSE);
    curl_setopt($curl_session, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($curl_session, CURLOPT_HTTPHEADER, array("X-Auth-Token: ".$admin_token));


    $result = curl_exec($curl_session);

    curl_close($curl_session);

?>