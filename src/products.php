<?php
    
    include 'php_files/db_connect.php';
    include 'php_files/http_parse_headers.php';
    include 'php_files/transform_dates.php';

    session_start();

    // If there is no active session
    if(!$_SESSION){

      header("Location: redirections/not_connected.php");
      exit();

    // If the role isn't USER
    }elseif(!($_SESSION['role'] === "USER")){
      
      header("Location: redirections/no_access.php");
      exit();

  }

  $conn = OpenCon();

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
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="css_styles/products.css?<?php echo time(); ?>">

</head>

<link rel="icon" href="images/logos/logo.png">

<title>Cloud Quest | Products</title>

<body style="background-color: white;">

<div class="imgcontainer">
  <a href="welcome.php"> 
    <img src="images/logos/logo+name.png" alt="logo" class="logo">
  </a>
</div>

<div class="user_name">
    <b><i class="fa fa-user" aria-hidden="true"></i> <?php printf("%s\n", $_SESSION['name']);?></b>    
</div>

<form action="products.php" method="post">
<button class="button button_logout" type="submit" name="logout_user"><i class="fa fa-sign-out" aria-hidden="true"></i><b> Log out</b></button></br>
</form><br>

<button onclick="location.href='welcome.php'" class="btn home_button"><i class="fa fa-home" aria-hidden="true"></i> Home</button>
<button onclick="location.href='cart.php'" class="btn cart_button_right"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Your Cart</button>

<div class="container">

<div class="wrapper">
  
<div class="products_head">
  <b><i class="fa fa-filter" aria-hidden="true"></i> Filters</b>
</div>
<div class="search_container">
  <label class = "search_label"><b>Product Name</b></label><br>
  <input type="text" id="name" class="search-key" placeholder="Product Name" >
</div>

<div class="search_container">
  <label class = "search_label"><b>Price</b></label><br>
  <input type="text" id="price" class="search-key" placeholder="Price" >
</div>

<div class="search_container">
  <label class = "search_label"><b>Availability Date</b></label><br>
  <input type="text" id="availability" class="search-key" placeholder="Availability Date" >
</div>

<div class="search_container">
  <label class = "search_label"><b>Withdrawal Date</b></label><br>
  <input type="text" id="withdrawal" class="search-key" placeholder="Withdrawal Date" >
</div>

<div class="search_container">
  <label class = "search_label"><b>Seller Name</b></label><br>
  <input type="text" id="seller" class="search-key" placeholder="Seller Name" >
</div>

<div class="search_container">
  <label class = "search_label"><b>Category</b></label><br>
  <input type="text" id="category" class="search-key" placeholder="Category" >
</div>
</div>

<?php

  // Get all products
  $url = "http://wilma_data_storage:1027/display_products.php";   
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$_SESSION['oauth_token']));
  $enc_result = curl_exec($ch);
  curl_close($ch);
  $result = json_decode($enc_result,true);

  // Get cart items
  $url = "http://wilma_data_storage:1027/get_cart_items.php?user_id=".$_SESSION['id'];   
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$_SESSION['oauth_token']));
  $enc_result = curl_exec($ch);
  curl_close($ch);
  $cart_items = json_decode($enc_result,true);

  // Get subscription items
  $url = "http://wilma_data_storage:1027/get_subscription_items.php?user_id=".$_SESSION['id'];   
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$_SESSION['oauth_token']));
  $enc_result = curl_exec($ch);
  curl_close($ch);
  $subscription_items = json_decode($enc_result,true);

  echo"<table id=\"products_search\" >";
  echo"<tr><th>Name</th><th>Price</th><th>Available</th><th>Withdrawal</th><th>Seller</th><th style=\"border-top-right-radius: 12px;\">Category</th><th style=\"background: white; border: none;\"></th></tr>\n";
  foreach($result as $row) {
    $product_id = $row['ID'];
    $user_id = $_SESSION['id'];

    // If the item is in the cart
    if (in_array($product_id, $cart_items)){
      $cart = 1;
    }else{
      $cart = 0;
    }

    // If there is a subscription to the product
    if (in_array($product_id, $subscription_items)){
      $subscription = 1;
    }else{
      $subscription = 0;
    }

    // Transform dates to YYYY-MM-DD HH:MM:SS
    $availability = timestamp_to_date($row['DATEOFAVAILABILITY']['$date']['$numberLong']);
    $withdrawal = timestamp_to_date($row['DATEOFWITHDRAWAL']['$date']['$numberLong']);
    $price = $row['PRICE']['$numberDecimal'];?>
    <tr>
    <?php 
    echo "<td data-input=\"name\">{$row['NAME']}</td>
          <td data-input=\"price\">{$price}€</td>
          <td data-input=\"availability\">{$availability}</td>
          <td data-input=\"withdrawal\">{$withdrawal}</td>
          <td data-input=\"seller\">{$row['SELLERNAME']}</td>
          <td data-input=\"category\">{$row['CATEGORY']}</td>"?>
          <td style="background:white; border:none;">
            <?php 
            if($row['SOLDOUT'] == true){
              $sold_out = '1'; 
            ?>
              <div class="container_sold_out">SOLD OUT</div>
            <?php
            }else{
              $sold_out = '0'; 
            ?>
              <div class="container_available">AVAILABLE</div>
            <?php
            }
            ?>  
            <input type="checkbox" class="cart" onclick="edit_cart(<?php echo $row['ID'];  ?>)" 
              <?php echo ($cart == '1' ? 'checked' : '');?> id = "cart(<?php echo $row['ID'];  ?> )"/>
            <label for="cart(<?php echo $row['ID'];  ?> )"></label>
            <input type="checkbox" class="subscription" onclick='edit_subscription(<?php echo $row["ID"];  ?>)'
              <?php echo ($subscription == '1' ? 'checked' : '');?> id = "subscription(<?php echo $row['ID'];  ?> )"/>
            <label for="subscription(<?php echo $row['ID'];  ?> )"></label>
          </td>
        <?php echo "</tr>\n";
      } 
    echo "</table><br /><br />";
?>

</div>

<script type="text/javascript">
	 
	 function edit_cart(id){
      
      $.ajax({

        type:'post',
        url:'php_files/edit_cart.php',
        data:{product_id:id}

      });
	 }

	function edit_subscription(product_id){

        $.ajax({
        
          type:'post',
          url:'php_files/edit_subscription.php',
          data:{product_id:product_id}
   
        });

  }

</script>

<script type="text/javascript">
window.onload = function(){
 var $filterableRows = $('#products_search').find('tr').not(':first'),
		$inputs = $('.search-key');

  $inputs.on('input', function() {

    $filterableRows.hide().filter(function() {
      return $(this).find('td').not(':nth-child(7)').filter(function() {
        
        var tdText = $(this).text().toLowerCase(),
            inputValue = $('#' + $(this).data('input')).val().toLowerCase();
      
        return tdText.indexOf(inputValue) != -1;
      
      }).length == $(this).find('td').length -1;
    }).show();

  }); 
}
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</table>
</body>
</html>