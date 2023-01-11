<?php

    include("access_mongo.php");

    $id_filter = [];

    // Get the new products id by finding the greatest already existing ID
    $id_options = ['projection' => ['ID'=>1], 'sort'=>['$natural'=>-1], 'limit'=>1];
    $greater_id = $products->find($id_filter,$id_options)->toArray();
    $new_id = $greater_id[0]['ID'];

    echo json_encode($new_id, JSON_PRETTY_PRINT);

?>