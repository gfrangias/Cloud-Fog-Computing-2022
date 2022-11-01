<?php

include 'php_files/db_connect.php';

$id = $name = $surname = $username = $password = $repassword = $email = $role = "";
$username_error = $email_error = $password_error = false;

$conn = OpenCon();
#echo "Connected Successfully";

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

  $check_usernames = mysqli_query($conn, "SELECT * FROM users WHERE USERNAME = '$username'");
  $check_emails = mysqli_query($conn, "SELECT * FROM users WHERE EMAIL = '$email'");
  $check_max_id = mysqli_query($conn, "SELECT users.ID FROM users ORDER BY users.ID DESC LIMIT 1");

  $row = $check_max_id->fetch_assoc();
  $id = (int) $row['ID'] + 1;

  if(mysqli_num_rows($check_usernames)>0){
    $username_error = true;
  }elseif(mysqli_num_rows($check_emails)>0){
    $email_error = true;  
  }else{

    $sql = "INSERT INTO users(ID, NAME, SURNAME, USERNAME, PASSWORD, EMAIL, ROLE, CONFIRMED ) 
    VALUES ('$id','$name', '$surname', '$username', '$password', '$email', '$role', '0')";
    header("Location: index.php");

    if (mysqli_query($conn, $sql)) {
      echo "New record created successfully";
    }else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
    }
  }else{
    $password_error = true;
  }
}

CloseCon($conn);
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

    <label style="color:#3194d6" for="email"><b>Email </b></label><br>
    <input type="email" placeholder="Enter Email" name="email" value="<?php echo isset($_POST["email"]) ? $_POST["email"] : ''; ?>" required><br>

    <label style="color:#3194d6" for="role"><b>Role</b></label></br>
    <div>
        <select id="role" name="role">
            <option value="" disabled selected hidden>Choose Role</option>
            <option value="ADMIN" <?php echo (isset($_POST['role']) && $_POST['role'] == 'ADMIN') ? 'selected' : ''; ?>>Admin</option>
            <option value="PRODUCTSELLER" <?php echo (isset($_POST['role']) && $_POST['role'] == 'PRODUCTSELLER') ? 'selected' : ''; ?>>Product Seller</option>
            <option value="USER"<?php echo (isset($_POST['role']) && $_POST['role'] == 'USER') ? 'selected' : ''; ?>>User</option>
        </select>
    </div></br>

    <label style="color:#3194d6" for="username"><b>Username</b></label><br>
    <input type="text" placeholder="Enter Username" name="username" value="<?php echo isset($_POST["username"]) ? $_POST["username"] : ''; ?>" required><br>

    <label style="color:#3194d6" for="password"><b>Password</b></label><br>
    <input type="password" placeholder="Enter Password" name="password" value="<?php echo isset($_POST["password"]) ? $_POST["password"] : ''; ?>" required><br>

    <label style="color:#3194d6" for="repassword"><b>Repeat password</b></label><br>
    <input type="password" placeholder="Enter Password again" name="repassword" value="<?php echo isset($_POST["repassword"]) ? $_POST["repassword"] : ''; ?>" required><br>

    <button class="button button_signup" type="submit" name="signup_user"><b>Sign up</b></button><br><br>
    <?php
    if($username_error){

      echo '<p class="error">This username is already being used.</p>';

    }elseif($email_error){

      echo '<p class="error">This email address is already being used.</p>';

    }elseif($password_error){

      echo '<p class="error">The two passwords don\'t match.</p>';

    }
    ?>
    <label style="color:#007ebe">Already a member?</label><br>

    <button class="button button_login" onclick="redirect_to()"><b>Cancel</b></button>
  </div>
</form>

<script>
function redirect_to() {
  location.replace("index.php")
}
</script>

</body>
</html>