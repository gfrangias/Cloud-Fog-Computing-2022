<?php

    include 'php_files/db_connect.php';

    session_start();
    
    if(!($_SESSION['role'] === "PRODUCTSELLER")){
        
        header("Location: no_access.php");
        exit();
    }

    $conn = OpenCon();

?>

<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="css_styles/seller.css?<?php echo time(); ?>">


</head>

<link rel="icon" href="images/logos/logo.png">

<title>Cloud Quest | My products</title>

<body style="background-color: white;">

<div class="imgcontainer">
    <a href="welcome.php"> 
        <img src="images/logos/logo+name.png" alt="logo" class="logo">
    </a>
</div><br>

<button onclick="location.href='welcome.php'" class="btn home_button"><i class="fa fa-home" aria-hidden="true"></i> Home</button>

<div class="products_head">
    <b>Your Products</b>
</div><br>

<div class="container">

<?php

    $conn = OpenCon();

    $id = $_SESSION['id'];
    $sql = "SELECT products.* FROM products WHERE products.SELLERID = '$id'";
    $result = mysqli_query($conn, $sql) or die("Bad query: $sql");

    if(mysqli_num_rows($result) == 0){
      echo "<div class=\"no_products_head\">
              <b>No products yet.</b>
            </div> ";
    }
    echo"<table>";
    echo"<tr><th>Name</th><th>Code</th><th>Price</th><th>Withdrawal</th><th>Category</th><th></th><th></th></tr>\n";
    while($row = mysqli_fetch_assoc($result)) {
        $product_id = $row['ID'];?>
        <tr id="remove<?php echo $row['ID']?>">
         
          <td><input type = "text" id="edit_name<?php echo $row['ID']; ?>" value =" <?php echo $row['NAME']; ?>"></input></td>
          <td><input type = "text" id="edit_code<?php echo $row['ID']; ?>" value =" <?php echo $row['PRODUCTCODE']; ?>"></input></td>
          <td><input type = "text" id="edit_price<?php echo $row['ID']; ?>" value = "<?php echo $row['PRICE']; ?>"></input></td>
          <td><input type = "text" id="edit_withdrawal<?php echo $row['ID']; ?>" value = "<?php echo $row['DATEOFWITHDRAWAL']; ?>"></input></td>
          <td><input type = "text" id="edit_category<?php echo $row['ID']; ?>" value = "<?php echo $row['CATEGORY']; ?>"></input></td>
          <td><button onclick="edit_product(<?php echo $row['ID'];  ?>)"  class="btn button_edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i><b>Edit</b></button></td>
          <td><button onclick="remove_product(<?php echo $row['ID'];  ?>)"  class="btn button_remove"><i class="fa fa-minus-circle" aria-hidden="true"></i><b>Remove</b></button></td>
          <?php echo "</td>
        </tr>\n";
    } 
    ?>
    <tr>
    <td><input type = "text" id="add_name" placeholder="Insert name"></input></td>
    <td><input type = "text" id="add_code" placeholder="Insert code"></input></td>
    <td><input type = "text" id="add_price" placeholder="Insert price"></input></td>
    <td><input type = "text" id="add_withdrawal" placeholder="Insert withdrawal date"></input></td>
    <td><input type = "text" id="add_category" placeholder="Insert category"></input></td>
    <td colspan="2"&nbsp;><button onclick="add_product()"  class="btn add_button"><i class="fa fa-plus-square-o" aria-hidden="true"></i><b> Add new product</b></button></td>

</table>
</div>

<script type="text/javascript">
	 
	 function remove_product(id){

       if(confirm('Are you sure you want to remove product?')){
         
         $.ajax({

              type:'post',
              url:'php_files/remove_product.php',
              data:{remove_id:id},
              success:function(data){
                   $('#remove'+id).hide('slow');
              }
         });
       }
	 }

     function edit_product(id){

        if(isValidDate($('#edit_withdrawal'+id).val())){
            if(isValidPrice($('#edit_price'+id).val())){
                if(confirm('Are you sure you want to edit product?')){
                
                    $.ajax({

                        type:'post',
                        url:'php_files/edit_product.php',
                        data:{id:id, name:$('#edit_name'+id).val(), code:$('#edit_code'+id).val(), price:$('#edit_price'+id).val(),
                        withdrawal:$('#edit_withdrawal'+id).val(), category:$('#edit_category'+id).val()}
                    });
                }
            }else{

                alert("Invalid price!");

            }  
        }else{

            alert("Invalid date or date format! Please use YYYY-MM-DD HH:MM:SS.");

        }
     }


    function add_product(){
        if(isValidDate($('#add_withdrawal').val())){
            if(isValidPrice($('#add_price').val())){
                if(confirm('Are you sure you want to add product?')){
                    $.ajax({

                        type:'post',
                        url:'php_files/add_product.php',
                        data:{name:$('#add_name').val(), code:$('#add_code').val(), price:$('#add_price').val(),
                        withdrawal:$('#add_withdrawal').val(), category:$('#add_category').val()}
                });
                location.reload();      
            }
            }else{

                alert("Invalid price!");

            }  
        }else{

            alert("Invalid date or date format! Please use YYYY-MM-DD HH:MM:SS.");

        }
    }


    function isValidDate(dateString) {
        var regEx = /(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/i;
        if(!dateString.match(regEx)) return false;  // Invalid format
        var d = new Date(dateString);
        var dNum = d.getTime();
        if(!dNum && dNum !== 0) return false; // NaN value, Invalid date
        return d;
    }

    function isValidPrice(priceString) {
        var regEx = /^\d+(?:[.,]\d{1,2})*$/gm;
        if(!priceString.match(regEx)) return false; // Invalid price
        return true;
    }
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</table>
</body>
</html>
