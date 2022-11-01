<?php 
session_start();
//print_r($_SESSION);

if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)){
    header("Location: not_connected.php");
    exit();
}

if (isset($_POST['logout_user'])){
  session_destroy();
  header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="css_styles/welcome.css?<?php echo time(); ?>">

</head>

<link rel="icon" href="images/logos/logo.png" />
<title>Cloud Quest | Welcome</title>

<body>

<div class="imgcontainer">
    <img src="images/logos/logo+name.png" alt="logo" class="logo">
</div>

<div class="user_name">
    <b><i class="fa fa-user" aria-hidden="true"></i> <?php printf("%s %s", $_SESSION['name'], $_SESSION['surname']); ?></b>    
</div>

<form action="welcome.php" method="post">
<button class="button button_logout" type="submit" name="logout_user"><i class="fa fa-sign-out" aria-hidden="true"></i><b> Log out</b></button></br>
</form>

<div class="dropdown">
  <button class="dropdownbutton"><b>Menu <i class="fa fa-chevron-circle-down" aria-hidden="true"></i></b></button>
  <div class="dropdown-content">
    <a href="products.php"><i class="fa fa-shopping-bag" aria-hidden="true"></i><b> Products</b></a>
    <a href="cart.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i><b> Cart</b></a>
    <a href="seller.php"><i class="fa fa-users" aria-hidden="true"></i><b> Seller</b></a>
    <a href="administration.php"><i class="fa fa-lock" aria-hidden="true"></i><b> Administration</b></a>
  </div>
</div></br>

</body>
</html>