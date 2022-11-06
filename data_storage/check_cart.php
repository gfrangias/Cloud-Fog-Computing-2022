<?php
    
    include("access_mongo.php");

    $user_id = $_GET['user_id'];
    $filter = array('USERID'=>intval($user_id));
    $answer = $carts->find($filter)->toArray();
    echo json_encode($answer, JSON_PRETTY_PRINT);

    die;
?>