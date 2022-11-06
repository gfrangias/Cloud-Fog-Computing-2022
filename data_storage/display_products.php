<?php
    
    include("access_mongo.php");
    $answer = $products->find()->toArray();
    echo json_encode($answer, JSON_PRETTY_PRINT);

    die;
?>