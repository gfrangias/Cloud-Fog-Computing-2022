<?php

    include 'php_files/db_connect.php';
    include 'php_files/transform_dates.php';

    session_start();

    // If there is no active session
    if(!$_SESSION){

        header("Location: redirections/not_connected.php");
        exit();

    // If the role isn't PRODUCTSELLER
    }elseif(!($_SESSION['role'] === "PRODUCTSELLER")){
        
        header("Location: redirections/no_access.php");
        exit();

    }

    // If the expiration time of the OAuth token has passed
    if(time() >= $_SESSION['expiration']){
        session_destroy();
        header("Location: redirections/session_expired.php");
        exit();
    }

    $conn = OpenCon();

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
<link rel="stylesheet" type="text/css" href="css_styles/seller.css?<?php echo time(); ?>">


</head>

<link rel="icon" href="images/logos/logo.png">

<title>Cloud Quest | My products</title>

<body style="background-color: white;">

<div class="imgcontainer">
    <a href="welcome.php"> 
        <img src="images/logos/logo+name.png" alt="logo" class="logo">
    </a>
</div>

<div class="user_name">
    <b><i class="fa fa-user" aria-hidden="true"></i> <?php printf("%s\n", $_SESSION['name']);?></b>    
</div>

<form action="seller.php" method="post">
<button class="button button_logout" type="submit" name="logout_user"><i class="fa fa-sign-out" aria-hidden="true"></i><b> Log out</b></button></br>
</form><br>

<button onclick="location.href='welcome.php'" class="btn home_button"><i class="fa fa-home" aria-hidden="true"></i> Home</button>

<div class="products_head">
    <b>Your Products</b>
</div><br>

<div class="container">

<?php

    // Get all the products of this seller
    $url = "http://wilma_data_storage:1027/display_seller.php?seller_id=".$_SESSION['id'];   
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$_SESSION['oauth_token']));
    $enc_result = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($enc_result,true);

    // If the seller has no products yet
    if(count($result) < 1){
      echo "<div class=\"no_products_head\">
              <b>No products yet.</b>
            </div> ";
    }

    echo"<table id=\"table\">";
    echo"<tr><th>Name</th><th>Code</th><th>Price</th><th>Available on</th><th>Withdrawal on</th><th>Category</th><th>Sold Out</th><th></th><th></th></tr>\n";
    $ind = 0;
    foreach($result as $row) {
        $ind = $ind + 1;

        // Transform dates to YYYY-MM-DD HH:MM:SS
        $availability = timestamp_to_date($row['DATEOFAVAILABILITY']['$date']['$numberLong']);
        $withdrawal = timestamp_to_date($row['DATEOFWITHDRAWAL']['$date']['$numberLong']);
        $product_id = $row['ID'];
        $price = $row['PRICE']['$numberDecimal'];
        $soldout = $row['SOLDOUT'];

        ?>
        <tr id="remove<?php echo $ind?>">
            <td><input type = "text" id="edit_name<?php echo $ind; ?>" value ="<?php echo $row['NAME']; ?>"></input></td>
            <td><input type = "text" id="edit_code<?php echo $ind; ?>" value ="<?php echo $row['PRODUCTCODE']; ?>"></input></td>
            <td><input type = "text" id="edit_price<?php echo $ind; ?>" value = "<?php echo $price; ?>"></input></td>
            <td><input type = "text" id="edit_availability<?php echo $ind; ?>" value = "<?php echo $availability; ?>"></input></td>
            <td><input type = "text" id="edit_withdrawal<?php echo $ind; ?>" value = "<?php echo $withdrawal; ?>"></input></td>
            <td><input type = "text" id="edit_category<?php echo $ind; ?>" value = "<?php echo $row['CATEGORY']; ?>"></input></td>
            <td>
            <label class="toggle">
                <input class="toggle-checkbox" type="checkbox" id="edit_soldout<?php echo $ind; ?>" value="1" <?php echo ($soldout ? 'checked' : '');?> />
                <div class="toggle-switch"></div>
            </label>                
            </td>
            <td><button onclick="edit_product(<?php echo $ind;  ?>, <?php echo $product_id;  ?>)"  class="btn button_edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i><b>Edit</b></button></td>
            <td><button onclick="remove_product(<?php echo $ind;  ?>, <?php echo $product_id;  ?>)"  class="btn button_remove"><i class="fa fa-minus-circle" aria-hidden="true"></i><b>Remove</b></button></td>
            <?php echo "</td>
        </tr>\n";
    } 
    ?>
</table>
<br>
<br>
<!-- INPUT TABLE -->
<table id="table2">
<tr>
    <td><input type = "text" id="add_name" placeholder="Insert name"></input></td>
    <td><input type = "text" id="add_code" placeholder="Insert code"></input></td>
    <td><input type = "text" id="add_price" placeholder="Insert price"></input></td>
    <td><input type = "text" id="add_availability" placeholder="Insert availability date"></input></td>
    <td><input type = "text" id="add_withdrawal" placeholder="Insert withdrawal date"></input></td>
    <td><input type = "text" id="add_category" placeholder="Insert category"></input></td>
    <td colspan="2"&nbsp;><button onclick="add_product(<?php echo $ind;  ?>)"  class="btn add_button"><i class="fa fa-plus-square-o" aria-hidden="true"></i><b> Add new product</b></button></td>
</table>

</div>

<script type="text/javascript">
	 
	 function remove_product(ind, id){
        var name=document.getElementById('edit_name'+ind).value;

        if(confirm('Are you sure you want to remove product?')){
            
            $.ajax({

                type:'post',
                url:'php_files/remove_product.php',
                data:{remove_id:id, product_name:name},
                success:function(data){
                    $('#remove'+ind).hide('slow');
                }
            });
        }
	 }

     function edit_product(ind, id){

        if(isValidDate($('#edit_withdrawal'+ind).val()) && isValidDate($('#edit_availability'+ind).val())){
            if(compareDates($('#edit_availability'+ind).val(), $('#edit_withdrawal'+ind).val())) {
                if(isValidPrice($('#edit_price'+ind).val())){
                    if(confirm('Are you sure you want to edit product?')){
                        
                        // Check soldout toggle
                        if($('#edit_soldout'+ind).is(":checked")){
                            var $soldout = '1';
                        }else{
                            var $soldout = '0';
                        }
                    
                        $.ajax({

                            type:'post',
                            url:'php_files/edit_product.php',
                            data:{id:id, name:$('#edit_name'+ind).val(), code:$('#edit_code'+ind).val(), price:$('#edit_price'+ind).val(),
                            availability:$('#edit_availability'+ind).val(), withdrawal:$('#edit_withdrawal'+ind).val(),
                            soldout:$soldout, category:$('#edit_category'+ind).val()}
                        });
                    }
                }else{

                    alert("Invalid price!");

                } 
            }else{

                alert("You can't have availability date after withdrawal!");

            } 
        }else{

            alert("Invalid date or date format! Please use YYYY-MM-DD HH:MM:SS.");

        }
     }


    function add_product(ind){
        if(isValidDate($('#add_withdrawal').val()) && isValidDate($('#add_availability').val())){
            if(isValidPrice($('#add_price').val())){
                if(confirm('Are you sure you want to add product?')){
                    $.ajax({

                        type:'post',
                        url:'php_files/add_product.php',
                        data:{name:$('#add_name').val(), code:$('#add_code').val(), price:$('#add_price').val(),
                        availability:$('#add_availability').val(), withdrawal:$('#add_withdrawal').val(), category:$('#add_category').val()}
                    });

                    // Find the new products ID
                    $.ajax({
                        url: 'php_files/new_id.php',
                        type: 'get',
                        dataType: 'json',
                        success: function(res) {
                            var table = document.getElementById('table');
                            var ind = table.rows.length;
                            var row = table.insertRow();
                            
                            // Get all the inputed data
                            var name=document.getElementById('add_name').value;
                            var code=document.getElementById('add_code').value;
                            var price=document.getElementById('add_price').value;
                            var availability=document.getElementById('add_availability').value;
                            var withdrawal=document.getElementById('add_withdrawal').value;
                            var category=document.getElementById('add_category').value;
                            var id = res;   //New ID
                            row.id = 'remove'+ind;  //New table index

                            //New table row cells
                            var cell1 = row.insertCell(0);  
                            var cell2 = row.insertCell(1);
                            var cell3 = row.insertCell(2);
                            var cell4 = row.insertCell(3);
                            var cell5 = row.insertCell(4);
                            var cell6 = row.insertCell(5);
                            var cell7 = row.insertCell(6);
                            var cell8 = row.insertCell(7);
                            var cell9 = row.insertCell(8);

                            // Stuff the new row's cells
                            cell1.innerHTML = '<td><input type = \"text\" id=\"edit_name'+ind+'\" value =\"'+name+'\"></input></td>';
                            cell2.innerHTML = '<td><input type = \"text\" id=\"edit_code'+ind+'\" value =\"'+code+'\"></input></td>';
                            cell3.innerHTML = '<td><input type = \"text\" id=\"edit_price'+ind+'\" value =\"'+price+'\"></input></td>';
                            cell4.innerHTML = '<td><input type = \"text\" id=\"edit_availability'+ind+'\" value =\"'+availability+'\"></input></td>';
                            cell5.innerHTML = '<td><input type = \"text\" id=\"edit_withdrawal'+ind+'\" value =\"'+withdrawal+'\"></input></td>';
                            cell6.innerHTML = '<td><input type = \"text\" id=\"edit_category'+ind+'\" value =\"'+category+'\"></input></td>';
                            cell7.innerHTML = '<td> <label class=\"toggle\"><input class=\"toggle-checkbox\" type="checkbox" id=\"edit_soldout'+ind+'\"value=\"1\"/><div class=\"toggle-switch\"></div></label></td>'
                            cell8.innerHTML = '<td><button onclick=\"edit_product('+ind+','+id+')\"  class=\"btn button_edit\"><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i><b>Edit</b></button></td>';
                            cell9.innerHTML = '<td><button onclick=\"remove_product('+ind+','+id+')\"  class=\"btn button_remove\"><i class=\"fa fa-minus-circle\" aria-hidden=\"true\"></i><b>Remove</b></button></td>';

                            // Empty the input table
                            document.getElementById('add_name').value = "";
                            document.getElementById('add_code').value = "";
                            document.getElementById('add_price').value = "";
                            document.getElementById('add_availability').value = "";
                            document.getElementById('add_withdrawal').value = "";
                            document.getElementById('add_category').value = "";
                        }
                    });
            }   
            }else{

                alert("Invalid price!");

            }  
        }else{

            alert("Invalid date or date format! Please use YYYY-MM-DD HH:MM:SS.");

        }
    }

    // Check validity of the date string added/edited
    function isValidDate(dateString) {
        var regEx = /(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/i;
        if(!dateString.match(regEx)) return false;  // Invalid format
        var d = new Date(dateString);
        var dNum = d.getTime();
        if(!dNum && dNum !== 0) return false; // NaN value, Invalid date
        return d;
    }

    // Compare two dates
    // Availability date should be prior to withdrawal date
    function compareDates(availability, withdrawal) {

        // convert the strings to Date objects
        const availabilityObj = new Date(availability);
        const withdrawalObj = new Date(withdrawal);

        // compare the dates
        if (availabilityObj < withdrawalObj) {
            return true;
        } else {
            return false;
        }
    }

    // Check the validity of the price added/edited
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
