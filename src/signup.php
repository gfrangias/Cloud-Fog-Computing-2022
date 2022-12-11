<?php

include 'php_files/db_connect.php';
include 'php_files/http_parse_headers.php';
include 'php_files/keyrock_connect.php';

$id = $name = $surname = $username = $password = $repassword = $email = $role = "";
$username_error = $email_error = $password_error = false;

if (isset($_POST['signup_user'])) {
#echo "OK";
$name = $_POST['name'];
$surname = $_POST['surname'];
$username = $_POST['username'];
$password = $_POST['password'];
$repassword = $_POST['repassword'];
$email = $_POST['email'];
$role = $_POST['role'];

  if($password === $repassword){

    $admin_login = array("name"=>"gfrangias@tuc.gr","password"=>"1234");

    $curl_session = curl_init();

    curl_setopt($curl_session, CURLOPT_URL, "http://keyrock:3005/v1/auth/tokens");
    curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl_session, CURLOPT_HEADER, 1);
    curl_setopt($curl_session, CURLOPT_POST, TRUE);
    curl_setopt($curl_session, CURLOPT_POSTFIELDS, json_encode($admin_login));
    curl_setopt($curl_session, CURLOPT_HTTPHEADER, array("Content-Type:application/json"));

    $result = curl_exec($curl_session);
    $header_size = curl_getinfo($curl_session, CURLINFO_HEADER_SIZE);
    $header = substr($result, 0, $header_size);
    $parsed_header = http_parse_headers($header);
    curl_close($curl_session);

    $admin_token = $parsed_header['X-Subject-Token'];

    if(isset($admin_token)){
      //echo $admin_token;

      $curl_session = curl_init();

      curl_setopt($curl_session, CURLOPT_URL, "http://keyrock:3005/v1/users");
      curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($curl_session, CURLOPT_HEADER, FALSE);
      curl_setopt($curl_session, CURLOPT_HTTPHEADER, array("X-Auth-token: ".$admin_token));
      
      $result = curl_exec($curl_session);
      $users_json = json_decode($result, true);
      curl_close($curl_session);
      
      foreach($users_json as $row){
        foreach($row as $user){
          if($user['email'] == $email){
            $email_error = true;
          }elseif($user['username'] == $username){
            $username_error = true;
          }
        }
      }
    }

    if(isset($admin_token) && $email_error == false && $username_error == false){
      $curl_session = curl_init();
    
      $new_user_info = array("user"=>array("description"=>"$name"." "."$surname", "username"=> $username, 
      "password"=>"$password", "email"=>"$email", "website"=>"$role"));

      curl_setopt($curl_session, CURLOPT_URL, "http://keyrock:3005/v1/users");
      curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($curl_session, CURLOPT_HEADER, FALSE);
      curl_setopt($curl_session, CURLOPT_POST, TRUE);
      curl_setopt($curl_session, CURLOPT_POSTFIELDS, json_encode($new_user_info));
      curl_setopt($curl_session, CURLOPT_HTTPHEADER, array("Content-Type:application/json","X-Auth-token:".$admin_token));
      $result = curl_exec($curl_session);
      curl_close($curl_session);

      $keyrock_conn = OpenKeyrock();

      mysqli_query($keyrock_conn, "UPDATE user SET enabled = 0 WHERE username= '$username'");

      if($role === "ADMIN"){
        
        mysqli_query($keyrock_conn, "UPDATE user SET admin = 1 WHERE username= '$username'");

      }

      CloseKeyrock($keyrock_conn);

      header("Location: signed_up.php");

    }else{

    $token_error = true;

    }

  }else{

    $password_error = true;

  }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="css_styles/signup.css?<?php echo time(); ?>">

</head>

<link rel="icon" href="images/logos/logo.png" />
<title>Cloud Quest | Sign up</title>

<body style="background-color: #fff;">

<div class="imgcontainer">
    <img src="images/logos/logo+name.png" alt="logo" class="logo">
  </div>

<div class="signup_head">
    <b>Sign up</b>
</div>

<div class="signup_message">
<label>Fill in your personal data to sign up.</label><br>
</div>
<form action="signup.php" method="post">

  <div class="container">
    <label style="color:#3194d6" for="name"><b>Name</b></label><br>
    <input type="text" placeholder="Enter Name" name="name" value="<?php echo isset($_POST["name"]) ? $_POST["name"] : ''; ?>" required><br>

    <label style="color:#3194d6" for="surname"><b>Surname </b></label><br>
    <input type="text" placeholder="Enter Surname" name="surname" value="<?php echo isset($_POST["surname"]) ? $_POST["surname"] : ''; ?>" required><br>
    <?php if($email_error){

      echo '<br><b class="error">This email address is already being used.</b><br><br>';

    }?>
    <label style="color:#3194d6" for="email"><b>Email </b></label><br>
    <input type="email" placeholder="Enter Email" name="email" value="<?php echo isset($_POST["email"]) ? $_POST["email"] : ''; ?>" required><br>

    <label style="color:#3194d6" for="role"><b>Role</b></label></br>
    <div>
        <select id="role" name="role" required>
            <option value="" disabled selected hidden>Choose Role</option>
            <option value="ADMIN" <?php echo (isset($_POST['role']) && $_POST['role'] == 'ADMIN') ? 'selected' : ''; ?>>Admin</option>
            <option value="PRODUCTSELLER" <?php echo (isset($_POST['role']) && $_POST['role'] == 'PRODUCTSELLER') ? 'selected' : ''; ?>>Product Seller</option>
            <option value="USER"<?php echo (isset($_POST['role']) && $_POST['role'] == 'USER') ? 'selected' : ''; ?>>User</option>
        </select>
    </div></br>
    <?php if($username_error){

      echo '<b class="error">This username is already being used.</b><br><br>';

    }?>
    <label style="color:#3194d6" for="username"><b>Username</b></label><br>
    <input type="text" placeholder="Enter Username" name="username" value="<?php echo isset($_POST["username"]) ? $_POST["username"] : ''; ?>" required><br>
    <?php if($password_error){

      echo '<br><b class="error">The two passwords don\'t match.</b><br><br>';

    }?>
    <label style="color:#3194d6" for="password"><b>Password</b></label><br>
    <input type="password" placeholder="Enter Password" name="password" value="<?php echo isset($_POST["password"]) ? $_POST["password"] : ''; ?>" required><br>

    <label style="color:#3194d6" for="repassword"><b>Repeat password</b></label><br>
    <input type="password" placeholder="Enter Password again" name="repassword" value="<?php echo isset($_POST["repassword"]) ? $_POST["repassword"] : ''; ?>" required><br>

    <button class="button button_signup" type="submit" name="signup_user"><b>Sign up</b></button><br><br>

  </div>
</form>
<div class="container2">

<label style="color:#007ebe"><i>Already a member?</i></label><br>

<button class="button button_login" onclick="redirect_to()"><b>Log In</b></button>

<br><br><br>
</div>

<script>
function redirect_to() {
  location.replace("index.php")
}
</script>

</body>
</html>