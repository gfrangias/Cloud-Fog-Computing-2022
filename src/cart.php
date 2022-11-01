<?php

    include 'php_files/db_connect.php';

    session_start();
    
    if(!($_SESSION['role'] === "USER")){
        
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

    $id = $_SESSION['id'];
    $sql = "SELECT c.ID, p.NAME, p.PRICE, p.DATEOFWITHDRAWAL, p.SELLERNAME, p.CATEGORY 
    FROM products p 
    INNER JOIN (SELECT carts.* FROM carts WHERE carts.USERID = '$id') c ON p.ID = c.PRODUCTID;";
    $result = mysqli_query($conn, $sql) or die("Bad query: $sql");

    if(mysqli_num_rows($result) == 0){
      echo "<div class=\"no_cart_head\">
              <b>No cart items yet. Add from products page:</b>
            </div> 
            <button onclick=\"location.href='products.php'\" class=\"btn products_button\"><i class=\"fa fa-shopping-bag\" aria-hidden=\"true\"></i> Products</button><br>";
    }else{

    echo"<table>";
    echo"<tr><th>Name</th><th>Price</th><th>Withdrawal</th><th>Seller</th><th>Category</th><th></th></tr>\n";
    while($row = mysqli_fetch_assoc($result)) { ?>
        <tr id="remove<?php echo $row['ID']?>">
        <?php 
        echo "<td data-input=\"name\">{$row['NAME']}</td>
        <td data-input=\"price\">{$row['PRICE']}€</td>
        <td data-input=\"withdrawal\">{$row['DATEOFWITHDRAWAL']}</td>
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
