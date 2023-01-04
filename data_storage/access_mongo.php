<?php

    require 'vendor/autoload.php';

    try{

        $conn = new MongoDB\Client("mongodb://root:1234@mongo_db:27017/");
        $db = $conn->cloud_quest_mongo;

        $products = $db->products;
        $carts = $db->carts;
        $subscriptions = $db->subscriptions;
        $notifications = $db->notifications;
        
    } catch (MongoConnectionException $e){
        var_dump($e);
    }

?>