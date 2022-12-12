<?php
        include 'http_parse_headers.php';

        $url = "http://data_storage:80/new_product_id.php";  
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $enc_result = curl_exec($ch);
        curl_close($ch);
        $new_id = json_decode($enc_result,true);
        echo $new_id

?>