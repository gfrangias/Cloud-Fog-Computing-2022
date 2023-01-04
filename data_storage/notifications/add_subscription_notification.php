<?php

    include("../access_mongo.php");

    //$json = json_decode(file_get_contents("php://input"),true);

    //$json_string = print_r($json);
    $now = time();
    $now = $now * 1000;
    echo "OK";
    $type = "new_sub";
    $message = "You have just subscribed to a product!";

    $insert_filter = array('TYPE'=>strval($type), 'TIMEOFDISPLAY'=>new MongoDB\BSON\UTCDateTime($now), 'MESSAGE'=>strval($message));

    $subscriptions->insertOne($insert_filter);
?>