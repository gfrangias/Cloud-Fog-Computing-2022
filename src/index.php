<?php 

include 'php_files/db_connect.php';
include 'php_files/http_parse_headers.php';
include 'php_files/keyrock_connect.php';

session_start();

ob_start();

$conn = OpenCon();
#echo "Connected Successfully";

$email = $password = "";
$login_err = $confirm_err = $user_found = false;

function validate($data){

  $data = trim($data);

  $data = stripslashes($data);

  $data = htmlspecialchars($data);

  return $data;

}

// Search for the user in keyrock database
if (isset($_POST['login_user'])) {

  $email = $_POST['email'];

  $password = $_POST['password'];

  $user_login = array("name"=>$email,"password"=>$password);

  $curl_session = curl_init();

  curl_setopt($curl_session, CURLOPT_URL, "http://keyrock:3005/v1/auth/tokens");
  curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($curl_session, CURLOPT_HEADER, 1);
  curl_setopt($curl_session, CURLOPT_POST, TRUE);
  curl_setopt($curl_session, CURLOPT_POSTFIELDS, json_encode($user_login));
  curl_setopt($curl_session, CURLOPT_HTTPHEADER, array("Content-Type:application/json"));

  $result = curl_exec($curl_session);
  $header_size = curl_getinfo($curl_session, CURLINFO_HEADER_SIZE);
  $header = substr($result, 0, $header_size);
  $parsed_header = http_parse_headers($header);
  curl_close($curl_session);

  // If the user exists in the database
  if(isset($parsed_header['X-Subject-Token'])){

    $user_token = $parsed_header['X-Subject-Token'];
    //echo $user_token;

    // Administator login to get X-Auth-Token
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
    $parsed_header_admin = http_parse_headers($header);
    curl_close($curl_session);
  }else{

    $login_err = true;
  
  }
  if(isset($parsed_header_admin['X-Subject-Token'])){
        
    $admin_token = $parsed_header_admin['X-Subject-Token'];

    // IDs acquired from Keyrock Application
    $client_id = '258c4571-aeaa-4194-9984-b22e73c7f869';
    $client_secret  = '7f8a86a9-2da8-4f52-a1dc-e8918cd88887';

    $authorization = base64_encode(''.$client_id.':'.$client_secret.'');

    $curl_session = curl_init();
    // Keyrock authorization token creation
    curl_setopt_array($curl_session, array(
      CURLOPT_URL => 'http://keyrock:3005/oauth2/token',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'grant_type=password&username='.$email.'&password='.$password.'',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded',
        # base64 (client_id:client_secret)
        'Authorization: Basic '.$authorization.''
      ),
    ));

    $result = curl_exec($curl_session);
    curl_close($curl_session);
    $result = json_decode($result);

    $oauth_token = $result->access_token; // OAuth token
    $expiration = time()+3599;            // Time when OAuthntoken will expire

    // Get all Keyrock users
    $curl_session = curl_init();

    curl_setopt($curl_session, CURLOPT_URL, "http://keyrock:3005/v1/users");
    curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl_session, CURLOPT_HEADER, FALSE);
    curl_setopt($curl_session, CURLOPT_HTTPHEADER, array("X-Auth-token: ".$admin_token));
    
    $result = curl_exec($curl_session);
    $users_json = json_decode($result, true);
    curl_close($curl_session);

    // Find the user with this email and create $_SESSION array
    foreach($users_json as $row){
      foreach($row as $user){
        if($user['email'] == $email){
          $user_found = true;
          $_SESSION['id'] = $user['id'];
          $_SESSION['email'] = $user['email'];
          $_SESSION['username'] = $user['username'];
          $_SESSION['role'] = $user['website'];
          $_SESSION['name'] = $user['description'];
          $_SESSION['enabled'] = $user['enabled'];
          $_SESSION['oauth_token'] = $oauth_token;
          $_SESSION['expiration'] = $expiration;
        }
      }
    }
    
    // If no user is found error occured
    if(!$user_found){
      session_unset();
      $login_err = true;
    // If user found move to welcome page
    }else{
      header("Location: welcome.php");
    }
  }
}else{
  $admin_token="";
  $login_err = false;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="css_styles/index.css?<?php echo time(); ?>">

</head>

<link rel="icon" href="images/logos/logo.png" />
<title>Cloud Quest | Log in</title>

<body style="background-color:#fff">

<div class="imgcontainer">
    <img src="images/logos/logo+name.png" alt="logo" class="logo">
</div>

<div class="login_head">
    <b>Log in</b>
</div>

<form action="index.php" method="post">
  
  <div class="imgcontainer">
    <img src="images/shopping_cart.jpg" alt="shopping_cart" class="cart">
  </div>

  <div class="container">
  <label style="color:#3194d6" for="email"><b>Email </b></label><br>
    <input type="text" placeholder="Enter Email" name="email" value="<?php echo isset($_POST["email"]) ? $_POST["email"] : ''; ?>" required><br>

    <label style="color:#3194d6" for="password"><b>Password</b></label><br>
    <input type="password" placeholder="Enter Password" name="password" value="<?php echo isset($_POST["password"]) ? $_POST["password"] : ''; ?>" required><br>

    <button class="button button_login" type="submit" name="login_user"><b>Log in</b></button><br><br>

    <?php
    if($login_err){

      echo '<b class="error">Wrong email or password. Try again.</b><br><br>';
      echo '<b class="error">If you\'ve recently signed up, your sign up form is being reviewed by our admins. Please try again later.</b>';

    }
    ?>
  </div>
</form>
<div class="container">
<label style="color:#007ebe"><i>Not a member of Cloud Quest yet?</i></label><br>

<button class="button button_signup" onclick="redirect_to()"><b>Sign up</b></button>
  </div>

<script>
function redirect_to() {
  location.replace("signup.php")
}
</script>

</body>
</html>