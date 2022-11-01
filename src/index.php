<?php 

include 'php_files/db_connect.php';

session_start();

ob_start();

$conn = OpenCon();
#echo "Connected Successfully";

$username = $password = "";
$login_err = $confirm_err = false;

function validate($data){

  $data = trim($data);

  $data = stripslashes($data);

  $data = htmlspecialchars($data);

  return $data;

}
if (isset($_POST['login_user'])) {
  $username = validate($_POST['username']);

  $password = validate($_POST['password']);


  $sql = mysqli_query($conn, "SELECT * FROM users WHERE USERNAME='$username' AND PASSWORD='$password'");

  if (mysqli_num_rows($sql) === 1) {

      $row = mysqli_fetch_assoc($sql);

      if ($row['USERNAME'] === $username && $row['PASSWORD'] === $password && $row['CONFIRMED'] == TRUE) {

          echo "Logged in!";
          $_SESSION['name'] = $row['NAME'];
          $_SESSION['surname'] = $row['SURNAME'];
          $_SESSION['username'] = $row['USERNAME'];
          $_SESSION['password'] = $row['PASSWORD'];
          $_SESSION['id'] = $row['ID'];
          $_SESSION['role'] = $row['ROLE'];
          $_SESSION['loggedin'] = true;

          header("Location: welcome.php");
      }else{
        $confirm_err = true;
      }
  }else{
    $login_err = true;
    }
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
  <label style="color:#3194d6" for="username"><b>Username </b></label><br>
    <input type="text" placeholder="Enter Username" name="username" value="<?php echo isset($_POST["username"]) ? $_POST["username"] : ''; ?>" required><br>

    <label style="color:#3194d6" for="password"><b>Password</b></label><br>
    <input type="password" placeholder="Enter Password" name="password" value="<?php echo isset($_POST["password"]) ? $_POST["password"] : ''; ?>" required><br>

    <button class="button button_login" type="submit" name="login_user"><b>Log in</b></button><br><br>

    <?php
    if($login_err){

      echo '<p class="error">Wrong username or password. Try again.</p>';

    }elseif($confirm_err){

      echo '<p class="error">If you\'ve recently signed up, your sign up form is being reviewed by our admins. Please try again later.</p>';

    }
    ?>
  </div>
</form>
<div class="container">
<label style="color:#007ebe">Not a member of Cloud Quest yet?</label><br>

<button class="button button_signup" onclick="redirect_to()"><b>Sign up</b></button>
  </div>

<script>
function redirect_to() {
  location.replace("signup.php")
}
</script>

</body>
</html>