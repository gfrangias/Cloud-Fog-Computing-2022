<?php
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="css_styles/signed_up.css?<?php echo time(); ?>">

</head>

<link rel="icon" href="images/logos/logo.png" />
<title>Cloud Quest | Signed Up</title>

<body style="background-color: white;">

<body>
<div class="container">

<div class="logocontainer">
    <img src="images/logos/logo+name.png" alt="logo" class="logo">
</div>

    <div class="message">
        <b>Welcome to the family of Cloud Quest!</b>
    </div>

    <div class="message2">
        <b>Keep in mind that it will take some time for our administrators to accept your sign up application.</b>
    </div>

    <div class="message2">
        <b>Click the button below to get to the login page.</b>
    </div>

  <label style="color: #e5a600"></label><br>
  <button class="button button_signup" onclick="redirect_to()"><b><b> Log In</b></b></button>
</div>

<script>
function redirect_to() {
  location.replace("index.php")
}
</script>

</body>
</html>