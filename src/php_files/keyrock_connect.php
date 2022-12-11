<?php

function OpenKeyrock(){
    $sname = "sql_db";
    $uname = "root";
    $psw = "root";
    $db_name = "idm";
    $conn = new mysqli($sname, $uname, $psw, $db_name) or die("Connection failed: %s\n". $conn -> error);

    return $conn;
}

function CloseKeyrock($conn){
    $conn -> close();
}


?>