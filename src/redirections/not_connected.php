<?php
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="../css_styles/not_connected.css?<?php echo time(); ?>">

</head>

<link rel="icon" href="../images/logos/logo_w.png" />
<title>Cloud Quest | Not connected</title>

<body style="background-color: white;">

<body>
<div class="container">
    <div class="message">
        <b>You have to log in first to access this page.</b>
    </div>

<div class="imgcontainer">
    <img src="../images/logo_flash.png" alt="logo_flash" class="logo_flash">
  </div>

  <label style="color: #e5a600"></label><br>
  <button class="button button_signup" onclick="redirect_to()"><b><i class="fa fa-chevron-left" aria-hidden="true"></i><b> Log in</b></b></button>
</div>

<script>
function redirect_to() {
  location.replace("../index.php")
}
</script>

</body>
</html>