<?php
    
    include("access_mongo.php");

    $user_id = $_GET['user_id'];

    // Get all the notifications of this user in reverse chronological order
    $filter = array('USERID'=>strval($user_id));
    $options = ['sort'=>['CREATION'=>-1]];
    $answer = $notifications->find($filter,$options)->toArray();
    echo json_encode($answer, JSON_PRETTY_PRINT);

    die;
?>