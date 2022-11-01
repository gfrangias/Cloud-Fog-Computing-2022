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
<link rel="stylesheet" type="text/css" href="css_styles/products.css?<?php echo time(); ?>">

</head>

<link rel="icon" href="images/logos/logo.png">

<title>Cloud Quest | Products</title>

<body style="background-color: white;">

<div class="imgcontainer">
  <a href="welcome.php"> 
    <img src="images/logos/logo+name.png" alt="logo" class="logo">
  </a>
</div><br>

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

$conn = OpenCon();  

$id = $_SESSION['id'];
$sql = "SELECT products.*, CASE
WHEN EXISTS (SELECT *
             FROM carts 
             WHERE carts.PRODUCTID = products.ID AND carts.USERID = '$id')
THEN '1'
ELSE '0'
END as CART 
        FROM products";
$result = mysqli_query($conn, $sql) or die("Bad query: $sql");

    echo"<table id=\"products_search\" >";
    echo"<tr><th>Name</th><th>Price</th><th>Withdrawal</th><th>Seller</th><th>Category</th><th></th></tr>\n";
    while($row = mysqli_fetch_assoc($result)) {
        $product_id = $row['ID'];?>
        <tr>
        <?php 
        echo "<td data-input=\"name\">{$row['NAME']}</td>
          <td data-input=\"price\">{$row['PRICE']}€</td>
          <td data-input=\"withdrawal\">{$row['DATEOFWITHDRAWAL']}</td>
          <td data-input=\"seller\">{$row['SELLERNAME']}</td>
          <td data-input=\"category\">{$row['CATEGORY']}</td>"?>
          <td>
                <input type="checkbox" onclick="edit_cart(<?php echo $row['ID'];  ?>)" 
                <?php echo ($row['CART'] == '1' ? 'checked' : '');?> id = "heart(<?php echo $row['ID'];  ?> )"/>
                <label for="heart(<?php echo $row['ID'];  ?> )"></label>
        </td>
          
          <?php echo "</tr>\n";
    } 
    
    echo "</table>";
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

</script>

<script type="text/javascript">
window.onload = function(){
 var $filterableRows = $('#products_search').find('tr').not(':first'),
		$inputs = $('.search-key');

  $inputs.on('input', function() {

    $filterableRows.hide().filter(function() {
      return $(this).find('td').not(':nth-child(6)').filter(function() {
        
        var tdText = $(this).text().toLowerCase(),
            inputValue = $('#' + $(this).data('input')).val().toLowerCase();
      
        return tdText.indexOf(inputValue) != -1;
      
      }).length == $(this).find('td').length -1;
    }).show();

  }); 
}
</script>

<script>

</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</table>
</body>
</html>
