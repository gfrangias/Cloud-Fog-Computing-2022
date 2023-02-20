<?php

include 'php_files/http_parse_headers.php';
include 'php_files/keyrock_connect.php';

$conn = OpenCon();

$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql) or die("Bad query: $sql");

$admin_login = array("name"=>"gfrangias@tuc.gr","password"=>"1234");

$curl_session = curl_init();

curl_setopt($curl_session, CURLOPT_URL, "http://keyrock:3005/v1/auth/tokens");
curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl_session, CURLOPT_HEADER, 1);
curl_setopt($curl_session, CURLOPT_POST, TRUE);
curl_setopt($curl_session, CURLOPT_HTTPHEADER, array("Content-Type:application/json"));
curl_setopt($curl_session, CURLOPT_POSTFIELDS, json_encode($admin_login));

$admin_result = curl_exec($curl_session);
$header_size = curl_getinfo($curl_session, CURLINFO_HEADER_SIZE);
$header = substr($admin_result, 0, $header_size);
$parsed_header = http_parse_headers($header);
curl_close($curl_session);

$admin_token = $parsed_header['X-Subject-Token'];

echo $admin_token;

$keyrock_conn = OpenKeyrock();

while($row = mysqli_fetch_assoc($result)) {
    $description = $row['NAME']." ".$row['SURNAME'];
    echo $description;
    $email = $row['EMAIL'];
    $enabled = $row['CONFIRMED'];
    echo " ".$enabled; 
    $website = $row['ROLE'];
    $username = $row['USERNAME'];
    if($row['ROLE']==='ADMIN'){
        $admin = '1';
    }else{
        $admin = '0';
    }
    echo " ".$admin?>
    <br>

<?php
    $password = $row['PASSWORD'];

    if(isset($admin_token)){
        $curl_session = curl_init();
      
        $new_user_info = array("user"=>array("description"=>"$description", "username"=> "$username", 
        "password"=>"$password", "email"=>"$email", "website"=>"$website"));

        curl_setopt($curl_session, CURLOPT_URL, "http://keyrock:3005/v1/users");
        curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl_session, CURLOPT_HEADER, FALSE);
        curl_setopt($curl_session, CURLOPT_POST, TRUE);
        curl_setopt($curl_session, CURLOPT_POSTFIELDS, json_encode($new_user_info));
        curl_setopt($curl_session, CURLOPT_HTTPHEADER, array("Content-Type:application/json","X-Auth-token:".$admin_token));
        curl_exec($curl_session);
        curl_close($curl_session);

        if($enabled == '0'){
            mysqli_query($keyrock_conn, "UPDATE user SET enabled = 0 WHERE username= '$username'");
        }

        if($admin == '1'){
            mysqli_query($keyrock_conn, "UPDATE user SET admin = 1 WHERE username = '$username'");
        }
    }
}

CloseKeyrock($keyrock_conn);
CloseCon($conn);
?>
