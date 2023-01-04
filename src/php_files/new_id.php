<?php
        include 'http_parse_headers.php';

        session_start();

        $url = "http://wilma_data_storage:1027/new_product_id.php";  
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$_POST['oauth_token']));
        $enc_result = curl_exec($ch);
        curl_close($ch);
        $new_id = json_decode($enc_result,true);
        echo json_encode($new_id);

?>