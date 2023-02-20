<?php

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
<link rel="stylesheet" type="text/css" href="css_styles/cart.css?<?php echo time(); ?>">
</script>

</head>

<link rel="icon" href="images/logos/logo.png">

<title>Cloud Quest | Cart</title>

<body style="background-color: white;">

<div class="imgcontainer">
    <a href="welcome.php"> 
        <img src="images/logos/logo+name.png" alt="logo" class="logo">
    </a>
</div>

<div class="user_name">
    <b><i class="fa fa-user" aria-hidden="true"></i> <?php printf("%s\n", $_SESSION['name']);?></b>    
</div>

<form action="cart.php" method="post">
<button class="button button_logout" type="submit" name="logout_user"><i class="fa fa-sign-out" aria-hidden="true"></i><b> Log out</b></button></br>
</form><br>

<button onclick="location.href='welcome.php'" class="btn home_button"><i class="fa fa-home" aria-hidden="true"></i> Home</button>
<button onclick="location.href='products.php'" class="btn products_button_right"><i class="fa fa-shopping-bag" aria-hidden="true"></i> Products</button>

<div class="cart_head">
    <b>Your Cart</b>
</div>
<div class="container">
<?php

    // Get the cart of this user
    $url = "http://wilma_data_storage:1027/display_cart.php?user_id=".$_SESSION['id'];   
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$_SESSION['oauth_token']));
    $enc_result = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($enc_result,true);
    $id = $_SESSION['id'];
    $ind = 0;
    $total = 0;
    
    // If the cart is empty
    if(count($result) < 1 || is_null($result)){
      echo "<div class=\"no_cart_head\">
              <b>No cart items yet. Add from products page:</b>
            </div> 
            <button onclick=\"location.href='products.php'\" class=\"btn products_button\"><i class=\"fa fa-shopping-bag\" aria-hidden=\"true\"></i> Products</button><br>";
    
    // If the cart is not empty
    }else{

    echo"<table>";
    echo"<tr><th>Name</th><th>Price</th><th>Added at</th><th>Seller</th><th>Category</th><th></th></tr>\n";
    foreach($result as $row) { 
        $ind = $ind+1;
        ?>
        <tr id="remove<?php echo $ind?>">
        <?php
        //print_r($row);
        $price = $row['PRICE'];
        $price = $price['$numberDecimal'];?>
        <td data-input="name"><?php echo $row['NAME']?></td>
        <td> <input type = "text" id="price<?php echo $ind; ?>" value =" <?php echo $price; ?>€" disabled></input></td>
        <td data-input="withdrawal"><?php echo $row['DATEOFINSERTION']?></td>
        <td data-input="seller"><?php echo $row['SELLERNAME']?></td>
        <td data-input="category"><?php echo $row['CATEGORY']?></td>
        <td>
            <input type="checkbox" onclick="remove_cart_item(
                <?php echo $ind;  ?> , <?php echo $row['ID'];  ?>)" checked id = "heart(<?php echo $ind;  ?> )"/>
                <label for="heart(<?php echo $ind;  ?> )"></label>
        </td>
          
          <?php echo "</td>
        </tr>\n";
        $total += floatval($price); // Calculate the total price of all the items
    } ?>
    
    </table>
    <br><br><br><br>
    <div class="total">
        <b>Total:</b><br>
        <input type = "text" id="total" value="<?php echo $total;  ?>€" disabled/>
    </div>
<?php
  }?>


<script type="text/javascript">
	 
	 function remove_cart_item(ind,id){

         $.ajax({
              type:'post',
              url:'php_files/remove_cart_item.php',
              data:{remove_id:id},
              success:function(data){
                   $('#remove'+ind).hide(1300);
                   var total = document.getElementById('total').value;
                   total = total.substring(0, total.length - 1);                        // Remove Euro sign
                   var subtract = document.getElementById('price'+ind).value;           // Get the removed item's price
                   subtract = subtract.substring(0, subtract.length - 1);               // Remove the Euro sign
                   var result = (parseFloat(total) - parseFloat(subtract)).toFixed(2);  // Subtract the removed item's price from the total
                   document.getElementById('total').value = result+'€';                 // New total
              }
         });
	 }

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</table>
</body>
</html>
