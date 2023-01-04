<?php

    include 'php_files/db_connect.php';

    session_start();
    
    if(!$_SESSION){

        header("Location: not_connected.php");
        exit();

    }elseif(!($_SESSION['role'] === "PRODUCTSELLER")){
        
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
    $url = "http://wilma_data_storage:1027/display_seller.php?seller_id=".$_SESSION['id'];   
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$_SESSION['oauth_token']));
    $enc_result = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($enc_result,true);

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
        $product_id = $row['ID'];
        $withdrawal = $row['DATEOFWITHDRAWAL'];
        $availability = $row['DATEOFAVAILABILITY'];
        $withdrawal = $withdrawal['$date'];
        $availability = $availability['$date'];
        $withdrawal = $withdrawal['$numberLong'] / 1000;
        $availability = $availability['$numberLong'] / 1000;
        $withdrawal = date( "Y-m-d H:i:s", $withdrawal);
        $availability = date( "Y-m-d H:i:s", $availability);
        $price = $row['PRICE'];
        $price = $price['$numberDecimal'];
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

       if(confirm('Are you sure you want to remove product?')){
         
         $.ajax({

              type:'post',
              url:'php_files/remove_product.php',
              data:{remove_id:id},
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

                    $.ajax({
                        url: 'php_files/new_id.php',
                        type: 'get',
                        dataType: 'json',
                        success: function(res) {
                            var table = document.getElementById('table');
                            var ind = table.rows.length;
                            var row = table.insertRow();
                            var name=document.getElementById('add_name').value;
                            var code=document.getElementById('add_code').value;
                            var price=document.getElementById('add_price').value;
                            var availability=document.getElementById('add_availability').value;
                            var withdrawal=document.getElementById('add_withdrawal').value;
                            var category=document.getElementById('add_category').value;
                            var id = res-1;
                            row.id = 'remove'+ind;
                            var cell1 = row.insertCell(0);
                            var cell2 = row.insertCell(1);
                            var cell3 = row.insertCell(2);
                            var cell4 = row.insertCell(3);
                            var cell5 = row.insertCell(4);
                            var cell6 = row.insertCell(5);
                            var cell7 = row.insertCell(6);
                            var cell8 = row.insertCell(7);
                            var cell9 = row.insertCell(8);


                            cell1.innerHTML = '<td><input type = \"text\" id=\"edit_name'+ind+'\" value =\"'+name+'\"></input></td>';
                            cell2.innerHTML = '<td><input type = \"text\" id=\"edit_code'+ind+'\" value =\"'+code+'\"></input></td>';
                            cell3.innerHTML = '<td><input type = \"text\" id=\"edit_price'+ind+'\" value =\"'+price+'\"></input></td>';
                            cell4.innerHTML = '<td><input type = \"text\" id=\"edit_availability'+ind+'\" value =\"'+availability+'\"></input></td>';
                            cell5.innerHTML = '<td><input type = \"text\" id=\"edit_withdrawal'+ind+'\" value =\"'+withdrawal+'\"></input></td>';
                            cell6.innerHTML = '<td><input type = \"text\" id=\"edit_category'+ind+'\" value =\"'+category+'\"></input></td>';
                            cell7.innerHTML = '<td> <label class=\"toggle\"><input class=\"toggle-checkbox\" type="checkbox" id=\"edit_soldout'+ind+'\"value=\"1\"/><div class=\"toggle-switch\"></div></label></td>'
                            cell8.innerHTML = '<td><button onclick=\"edit_product('+ind+','+id+')\"  class=\"btn button_edit\"><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i><b>Edit</b></button></td>';
                            cell9.innerHTML = '<td><button onclick=\"remove_product('+ind+','+id+')\"  class=\"btn button_remove\"><i class=\"fa fa-minus-circle\" aria-hidden=\"true\"></i><b>Remove</b></button></td>';

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


    function isValidDate(dateString) {
        var regEx = /(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/i;
        if(!dateString.match(regEx)) return false;  // Invalid format
        var d = new Date(dateString);
        var dNum = d.getTime();
        if(!dNum && dNum !== 0) return false; // NaN value, Invalid date
        return d;
    }

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
