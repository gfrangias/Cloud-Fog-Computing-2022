<?php
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="../css_styles/no_access.css?<?php echo time(); ?>">

</head>

<link rel="icon" href="../images/logos/logo_w.png" />
<title>Cloud Quest | No access</title>

<body style="background-color: white;">

<body>
<div class="container">
    <div class="message">
        <b>You don't have permission to access this page.</b>
    </div>

<div class="imgcontainer">
    <img src="../images/lock.png" alt="lock" class="lock">
  </div>

  <label style="color: #e5a600"></label><br>
  <button class="button button_signup" onclick="redirect_to()"><b><i class="fa fa-chevron-left" aria-hidden="true"></i><b> Go back</b></b></button>
</div>

<script>
function redirect_to() {
  location.replace("../welcome.php")
}
</script>

</body>
</html>