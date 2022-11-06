<?php

  $url = "http://localhost:27017/display_products.php";   
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $enc_result = curl_exec($ch);
  echo $enc_result;
  curl_close($ch);
  $result = json_decode($enc_result,true);

  ?>