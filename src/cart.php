<?php

    include 'php_files/db_connect.php';

    session_start();
    
    if(!$_SESSION){

        header("Location: not_connected.php");
        exit();

    }elseif(!($_SESSION['role'] === "USER")){
        
        header("Location: no_access.php");
        exit();

    }

    $conn = OpenCon();

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
</div><br>

<button onclick="location.href='welcome.php'" class="btn home_button"><i class="fa fa-home" aria-hidden="true"></i> Home</button>
<button onclick="location.href='products.php'" class="btn products_button_right"><i class="fa fa-shopping-bag" aria-hidden="true"></i> Products</button>

<div class="cart_head">
    <b>Your Cart</b>
</div>
<div class="container">
<?php

    $conn = OpenCon();  

    $url = "http://data_storage:80/display_cart.php?user_id=".$_SESSION['id'];   
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $enc_result = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($enc_result,true);
    $id = $_SESSION['id'];

    if(count($result) < 1 || is_null($result)){
      echo "<div class=\"no_cart_head\">
              <b>No cart items yet. Add from products page:</b>
            </div> 
            <button onclick=\"location.href='products.php'\" class=\"btn products_button\"><i class=\"fa fa-shopping-bag\" aria-hidden=\"true\"></i> Products</button><br>";
    }else{

    echo"<table>";
    echo"<tr><th>Name</th><th>Price</th><th>Withdrawal</th><th>Seller</th><th>Category</th><th></th></tr>\n";
    foreach($result as $row) { ?>
        <tr id="remove<?php echo $row['ID']?>">
        <?php 
        $withdrawal = $row['DATEOFWITHDRAWAL'];
        $withdrawal = $withdrawal['$date'];
        $withdrawal = $withdrawal['$numberLong'] / 1000;
        $withdrawal = date( "Y-m-d H:i:s", $withdrawal);
        $price = $row['PRICE'];
        $price = $price['$numberDecimal'];
        echo "<td data-input=\"name\">{$row['NAME']}</td>
        <td data-input=\"price\">{$price}€</td>
        <td data-input=\"withdrawal\">{$withdrawal}</td>
        <td data-input=\"seller\">{$row['SELLERNAME']}</td>
        <td data-input=\"category\">{$row['CATEGORY']}</td>"?>
        <td>
            <input type="checkbox" onclick="remove_cart_item(
                <?php echo $row['ID'];  ?>)" checked id = "heart(<?php echo $row['ID'];  ?> )"/>
                <label for="heart(<?php echo $row['ID'];  ?> )"></label>
        </td>
          
          <?php echo "</td>
        </tr>\n";
    } 
    
    echo "</table>";
  }
?>

<script type="text/javascript">
	 
	 function remove_cart_item(id){

         $.ajax({
              type:'post',
              url:'php_files/remove_cart_item.php',
              data:{remove_id:id},
              success:function(data){
                   $('#remove'+id).hide(1300);
              }
         });
	 }

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</table>
</body>
</html>
