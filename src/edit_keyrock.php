<?php

$sname = "sql_db";
$uname = "root";
$psw = "root";
$db_name = "idm";
$conn = new mysqli($sname, $uname, $psw, $db_name) or die("Connection failed: %s\n". $conn -> error);

mysqli_query($conn, "UPDATE user SET enabled = 0");

return $conn;


?>