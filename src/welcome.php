<?php 

  include 'php_files/db_connect.php';
  include 'php_files/transform_dates.php';

  session_start();

  // If there is no active session
  if(!$_SESSION){

        header("Location: redirections/not_connected.php");
        exit();

  }

  // If the expiration time of the OAuth token has passed
  if(time() >= $_SESSION['expiration']){
    session_destroy();
    header("Location: redirections/session_expired.php");
    exit();
  }
  
  // If log out button is pressed
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
    <b><i class="fa fa-user" aria-hidden="true"></i> <?php printf("%s\n", $_SESSION['name']);?></b>    
</div>

<form action="welcome.php" method="post">
<button class="button button_logout" type="submit" name="logout_user"><i class="fa fa-sign-out" aria-hidden="true"></i><b> Log out</b></button></br>
</form>
<?php
// If the role is USER
if ($_SESSION['role'] === "USER"){

  // Get all the notifications for this user
  $url = "http://wilma_data_storage:1027/display_notifications.php?user_id=".$_SESSION['id'];   
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$_SESSION['oauth_token']));
  $enc_result = curl_exec($ch);
  curl_close($ch);
  $result = json_decode($enc_result,true);

  if(count($result) < 1 || is_null($result)){ ?>
    <div class="scroll">
      No notifications yet...
    </div>
<?php
  }else{ ?>
    <div class="scroll">
      Notifications
      <hr class="notifications">
      <div class="gap">
      </div>
      <?php
      foreach($result as $row) { 
        $creation = timestamp_to_date($row['CREATION']['$date']['$numberLong']);
        $product_name = $row['PRODUCTNAME'];
        $message = $row['MESSAGE'];
        ?>
        <div class="notification">
          <div class="creation">
            <?php echo $creation;?>
          </div>
          <div class="gap">
          </div>
          <div class="product_name">
            <?php echo "Product name: ".$product_name;?>
          </div>
          <div class="gap">
          </div>
          <div class="notification_message">
          <?php echo $message;?>
          </div>
        </div>
        <hr class="inbetween">
        <?php
      } ?>
    </div>
  <?php
  }

  
}
?>

<div class="dropdown">
  <button class="dropdownbutton"><b>Menu <i class="fa fa-chevron-circle-down" aria-hidden="true"></i></b></button>
  <div class="dropdown-content">
  <?php if ($_SESSION['role'] === "USER"){?>
    <a href="products.php"><i class="fa fa-shopping-bag" aria-hidden="true"></i><b> Products</b></a>
    <a href="cart.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i><b> Cart</b></a>
    <data><i class="fa fa-users" aria-hidden="true"></i><b> Seller</b></a></data>
    <data><i class="fa fa-lock" aria-hidden="true"></i><b> Administration</b></a></data>
  </div>
  <?php }elseif($_SESSION['role'] === "PRODUCTSELLER"){?>
    <data><i class="fa fa-shopping-bag" aria-hidden="true"></i><b> Products</b></a></data>
    <data><i class="fa fa-shopping-cart" aria-hidden="true"></i><b> Cart</b></a></data>
    <a href="seller.php"><i class="fa fa-users" aria-hidden="true"></i><b> Seller</b></a>
    <data><i class="fa fa-lock" aria-hidden="true"></i><b> Administration</b></a></data>
  <?php }elseif($_SESSION['role'] === "ADMIN"){?>
    <data><i class="fa fa-shopping-bag" aria-hidden="true"></i><b> Products</b></a></data>
    <data><i class="fa fa-shopping-cart" aria-hidden="true"></i><b> Cart</b></a></data>
    <data><i class="fa fa-users" aria-hidden="true"></i><b> Seller</b></a></data>
    <a href="administration.php"><i class="fa fa-lock" aria-hidden="true"></i><b> Administration</b></a>
  <?php }?>
</div></br>

</body>
</html>