<?php
function OpenCon()
 {
 $sname = "localhost";
 $uname = "root";
 $psw = "";
 $db_name = "cloud_quest_db";
 $conn = new mysqli($sname, $uname, $psw,$db_name) or die("Connection failed: %s\n". $conn -> error);
 
 return $conn;
 }
 
function CloseCon($conn)
 {
 $conn -> close();
 }
   
?>