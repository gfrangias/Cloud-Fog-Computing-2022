<?php

    include 'php_files/http_parse_headers.php';

    session_start();

    // If there is no active session
    if(!$_SESSION){

        header("Location: redirections/not_connected.php");
        exit();
    
    // If the role isn't ADMIN
    }elseif(!($_SESSION['role'] === "ADMIN")){
        
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
<link rel="stylesheet" type="text/css" href="css_styles/administration.css?<?php echo time(); ?>">

</head>

<link rel="icon" href="images/logos/logo.png">

<title>Cloud Quest | Administration</title>

<body style="background-color: white;">

<div class="imgcontainer">
    <a href="welcome.php"> 
        <img src="images/logos/logo+name.png" alt="logo" class="logo">
    </a>
</div>

<div class="user_name">
    <b><i class="fa fa-user" aria-hidden="true"></i> <?php printf("%s\n", $_SESSION['name']);?></b>    
</div>

<form action="administration.php" method="post">
<button class="button button_logout" type="submit" name="logout_user"><i class="fa fa-sign-out" aria-hidden="true"></i><b> Log out</b></button></br>
</form><br>

<button onclick="location.href='welcome.php'" class="btn home_button"><i class="fa fa-home" aria-hidden="true"></i> Home</button>

<div class="users_head">
    <b>Users</b>
</div><br>

<div class="container">

<?php

    // Administator login to get X-Auth-Token
    $admin_login = array("name"=>"gfrangias@tuc.gr","password"=>"1234");

    $curl_session = curl_init();
    
    curl_setopt($curl_session, CURLOPT_URL, "http://keyrock:3005/v1/auth/tokens");
    curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl_session, CURLOPT_HEADER, 1);
    curl_setopt($curl_session, CURLOPT_POST, TRUE);
    curl_setopt($curl_session, CURLOPT_POSTFIELDS, json_encode($admin_login));
    curl_setopt($curl_session, CURLOPT_HTTPHEADER, array("Content-Type:application/json"));
    
    $result = curl_exec($curl_session);
    $header_size = curl_getinfo($curl_session, CURLINFO_HEADER_SIZE);
    $header = substr($result, 0, $header_size);
    $parsed_header_admin = http_parse_headers($header);
    curl_close($curl_session);

    $admin_token = $parsed_header_admin['X-Subject-Token'];
    //echo $admin_token;

    // Get all users
    $curl_session = curl_init();

    curl_setopt($curl_session, CURLOPT_URL, "http://keyrock:3005/v1/users");
    curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl_session, CURLOPT_HEADER, FALSE);

    curl_setopt($curl_session, CURLOPT_HTTPHEADER, array(
    "X-Auth-token:".$admin_token
    ));

    $result = curl_exec($curl_session);
    $users_json = json_decode($result, true);
    curl_close($curl_session);
    //print_r($users_json);
    $ind = 0;
    echo"<table>";
    echo"<tr><th>Name & Surname</th><th>Username</th><th>Email</th><th>Role</th><th>Confirmed</th><th></th><th></th></tr>\n";
    foreach($users_json as $row){ 
        foreach($row as $user){ 
            if (!(is_null($user['description']))){
            $ind=$ind+1;?>
        <tr id="remove<?php echo $ind?>">
        
        <td><input type = "text" id="edit_name<?php echo $ind; ?>" value ="<?php echo $user['description']; ?>"></input></td>
        <td><input type = "text" id="edit_username<?php echo $ind; ?>" value = "<?php echo $user['username']; ?>"></input></td>
        <td><input type = "email" id="edit_email<?php echo $ind; ?>" value = "<?php echo $user['email']; ?>"></input></td>
        <td>
        <div>
            <select id="edit_role<?php echo $ind; ?>">
                <?php if($user['website'] === "ADMIN"){ ?>
                    <option value="ADMIN" selected >Admin</option>
                    <option value="PRODUCTSELLER" >Product Seller</option>
                    <option value="USER" >User</option>                   
                <?php }elseif($user['website'] === "PRODUCTSELLER"){ ?>
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
            <input class="toggle-checkbox" type="checkbox" id="edit_confirmed<?php echo $ind; ?>" value="1" <?php echo ($user['enabled']== '1' ? 'checked' : '');?> />
            <div class="toggle-switch"></div>
        </label>
            
        </td>

        <td><button onclick="edit_user(<?php echo $ind;  ?>, '<?php echo $user['id'];?>')"  class="btn button_edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i><b>Edit</b></button></td>
        <td><button onclick="remove_user(<?php echo $ind;  ?>, '<?php echo $user['id'];?>')"  class="btn button_remove"><i class="fa fa-minus-circle" aria-hidden="true"></i><b>Remove</b></button></td>
        </td>
        </tr>
        <?php
                }
        } 
    }
    ?>

</table>

</div>

<script type="text/javascript">
	 
	 function remove_user(ind,id){

       if(confirm('Are you sure you want to remove user?')){
         
         $.ajax({

              type:'post',
              url:'php_files/remove_user.php',
              data:{remove_id:id},
              success:function(data){
                   $('#remove'+ind).hide('slow');
              }
         });
       }
	 }

     function edit_user(ind,id){

            if(confirm('Are you sure you want to edit user?')){
            
            // Get the confirmed input
            if($('#edit_confirmed'+ind).is(":checked")){
                var $confirmed = '1';
            }else{
                var $confirmed = '0';
            }

                $.ajax({

                    type:'post',
                    url:'php_files/edit_user.php',
                    data:{id:id, name:$('#edit_name'+ind).val(), username:$('#edit_username'+ind).val(),
                    email:$('#edit_email'+ind).val(), role:$('#edit_role'+ind).val(), confirmed:$confirmed}
                });
            }
     }
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</table>
</body>
</html>