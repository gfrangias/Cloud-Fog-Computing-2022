var name=document.getElementById('add_name').value;
                var code=document.getElementById('add_code').value;
                var price=document.getElementById('add_price').value;
                var withdrawal=document.getElementById('add_withdrawal').value;
                var category=document.getElementById('add_category').value;
                var ind = ind+1;
                var html="";
                var html= "<tr id=\"remove\<?php echo "+ind+"?>\"> \
          <td><input type = \"text\" id=\"edit_name\<?php echo "+ind+"; ?>\" value =\"\<?php echo "+name+"; ?>\"></input></td> \
          <td><input type = \"text\" id=\"edit_code\<?php echo "+ind+"; ?>\" value =\" \<?php echo "+code+"; ?>\"></input></td> \
          <td><input type = \"text\" id=\"edit_price\<?php echo "+ind+"; ?>\" value = \"\<?php echo "+price+"; ?>\"></input></td> \
          <td><input type = \"text\" id=\"edit_withdrawal\<?php echo "+ind+"; ?>\" value = \"\<?php echo "+withdrawal+"; ?>\"></input></td> \
          <td><input type = \"text\" id=\"edit_category\<?php echo "+ind+"; ?>\" value = \"\<?php echo "+category+"; ?>\"></input></td> \
          <td></td> \
          <td></td>"