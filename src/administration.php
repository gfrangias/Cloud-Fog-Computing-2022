<?php

    include 'php_files/db_connect.php';

    session_start();
    
    if(!($_SESSION['role'] === "ADMIN")){
        
        header("Location: no_access.php");
        exit();
    }

    $conn = OpenCon();

?>

<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="css_styles/administration.css?<?php echo time(); ?>">

</head>

<link rel="icon" href="images/logos/logo.png">

<title>Cloud Quest | Administration</title>

<body style="background-color: white;">

<div class="imgcontainer">
    <a href="welcome.php"> 
        <img src="images/logos/logo+name.png" alt="logo" class="logo">
    </a>
</div><br>

<button onclick="location.href='welcome.php'" class="btn home_button"><i class="fa fa-home" aria-hidden="true"></i> Home</button>

<div class="users_head">
    <b>Users</b>
</div><br>

<div class="container">

<?php

    $conn = OpenCon();

    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql) or die("Bad query: $sql");
    echo"<table>";
    echo"<tr><th>Name</th><th>Surname</th><th>Username</th><th>Email</th><th>Role</th><th>Confirmed</th><th></th><th></th></tr>\n";
    while($row = mysqli_fetch_assoc($result)) {?>
        <tr id="remove<?php echo $row['ID']?>">
         
          <td><input type = "text" id="edit_name<?php echo $row['ID']; ?>" value ="<?php echo $row['NAME']; ?>"></input></td>
          <td><input type = "text" id="edit_surname<?php echo $row['ID']; ?>" value = "<?php echo $row['SURNAME']; ?>"></input></td>
          <td><input type = "text" id="edit_username<?php echo $row['ID']; ?>" value = "<?php echo $row['USERNAME']; ?>"></input></td>
          <td><input type = "text" id="edit_email<?php echo $row['ID']; ?>" value = "<?php echo $row['EMAIL']; ?>"></input></td>
          <td>
          <div>
            <select id="edit_role<?php echo $row['ID']; ?>">
                <?php if($row['ROLE'] === "ADMIN"){ ?>
                    <option value="ADMIN" selected >Admin</option>
                    <option value="PRODUCTSELLER" >Product Seller</option>
                    <option value="USER" >User</option>                   
                <?php }elseif($row['ROLE'] === "PRODUCTSELLER"){ ?>
                    <option value="PRODUCTSELLER" selected >Product Seller</option>
                    <option value="ADMIN" >Admin</option>
                    <option value="USER" >User</option> 
                <?php } else{ ?>
                    <option value="USER" selected >User</option>
                    <option value="ADMIN" >Admin</option>
                    <option value="PRODUCTSELLER" >Product Seller</option>                    
                <?php } ?>
            </select>
          </div>
          </td>
          <td>
        <label class="toggle">
            <input class="toggle-checkbox" type="checkbox" id="edit_confirmed<?php echo $row['ID']; ?>" value="1" <?php echo ($row['CONFIRMED']== '1' ? 'checked' : '');?> />
            <div class="toggle-switch"></div>
        </label>
            
          </td>

          <td><button onclick="edit_user(<?php echo $row['ID'];  ?>)"  class="btn button_edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i><b>Edit</b></button></td>
          <td><button onclick="remove_user(<?php echo $row['ID'];  ?>)"  class="btn button_remove"><i class="fa fa-minus-circle" aria-hidden="true"></i><b>Remove</b></button></td>
          <?php echo "</td>
        </tr>\n";
    } 
    ?>

</table>

</div>

<script type="text/javascript">
	 
	 function remove_user(id){

       if(confirm('Are you sure you want to remove user?')){
         
         $.ajax({

              type:'post',
              url:'php_files/remove_user.php',
              data:{remove_id:id},
              success:function(data){
                   $('#remove'+id).hide('slow');
              }
         });
       }
	 }

     function edit_user(id){

            if(confirm('Are you sure you want to edit user?')){
            
            if($('#edit_confirmed'+id).is(":checked")){
                var $confirmed = '1';
            }else{
                var $confirmed = '0';
            }

                $.ajax({

                    type:'post',
                    url:'php_files/edit_user.php',
                    data:{id:id, name:$('#edit_name'+id).val(), surname:$('#edit_surname'+id).val(),
                    username:$('#edit_username'+id).val(), email:$('#edit_email'+id).val(),
                     role:$('#edit_role'+id).val(), confirmed:$confirmed}
                });
            }
     }
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</table>
</body>
</html>