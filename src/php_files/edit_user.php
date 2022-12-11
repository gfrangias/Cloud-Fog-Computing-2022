<?php

    include 'http_parse_headers.php';
    include 'keyrock_connect.php';
    
    session_start();
    
    if(!($_SESSION['role'] === "ADMIN")){
        
        header("Location: no_access.php");
        exit();
    }

    $user_id = $_POST['id'];
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $confirmed = $_POST['confirmed'];

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

    $curl_session = curl_init();

    curl_setopt($curl_session, CURLOPT_URL, "http://keyrock:3005/v1/users/".$user_id);
    curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl_session, CURLOPT_HEADER, FALSE);
    curl_setopt($curl_session, CURLOPT_HTTPHEADER, array("Content-Type:application/json",
    "X-Auth-Token: ".$admin_token));

    curl_setopt($curl_session, CURLOPT_CUSTOMREQUEST, "PATCH");

    curl_setopt($curl_session, CURLOPT_POSTFIELDS, "{
        \"user\": {
            \"description\": \"$name\",
            \"username\": \"$username\",
            \"email\": \"$email\",
            \"website\": \"$role\"
        }
      }");

    $result = curl_exec($curl_session);
    curl_close($curl_session);

    $keyrock_conn = OpenKeyrock();

    if($confirmed==='1'){

        mysqli_query($keyrock_conn, "UPDATE user SET enabled = 1 WHERE id= '$user_id'");

    }else{

        mysqli_query($keyrock_conn, "UPDATE user SET enabled = 0 WHERE id= '$user_id'");

    }

    if($role === 'ADMIN'){

        mysqli_query($keyrock_conn, "UPDATE user SET admin = 1 WHERE id= '$user_id'");

    }else{

        mysqli_query($keyrock_conn, "UPDATE user SET admin = 0 WHERE id= '$user_id'");

    }

    CloseKeyrock($keyrock_conn);
?>