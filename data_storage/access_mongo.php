<?php

    require 'vendor/autoload.php';

    try{

        // Establish connection to MongoDB
        $conn = new MongoDB\Client("mongodb://root:1234@mongo_db:27017/");
        $db = $conn->cloud_quest_mongo;

        // Get all the collections
        $products = $db->products;
        $carts = $db->carts;
        $subscriptions = $db->subscriptions;
        $notifications = $db->notifications;
        
    // Check for exceptions
    } catch (MongoConnectionException $e){
        var_dump($e);
    }

?>