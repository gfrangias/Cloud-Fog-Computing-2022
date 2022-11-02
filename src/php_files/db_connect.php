<?php
function OpenCon()
 {
 $sname = "database";
 $uname = "db_user";
 $psw = "1234";
 $db_name = "cloud_quest_db";
 $conn = new mysqli($sname, $uname, $psw,$db_name) or die("Connection failed: %s\n". $conn -> error);
 
 return $conn;
 }
 
function CloseCon($conn)
 {
 $conn -> close();
 }
   
?>