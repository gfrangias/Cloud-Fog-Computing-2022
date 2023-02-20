<?php


    $url = "http://wilma_data_storage:1027/display_products.php";   
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$_POST['oauth_token']));
    $enc_result = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($enc_result,true);
    //print_r($result);

    foreach($result as $row) {

        $availability = $row['DATEOFAVAILABILITY']['$date']['$numberLong'];
        $withdrawal = $row['DATEOFWITHDRAWAL']['$date']['$numberLong'];
        if($row['SOLDOUT'] == true){
            $sold_out = '1'; 
          }else{
            $sold_out = '0';
        }
        
        $product_id = $row['ID'];
        $name = $row['NAME'];

        $change_flag = "0";

        $id = $product_id;
        $id = preg_replace('/\s+/', '', $id);
        $sold_out = "0";
        
        $curl = curl_init();
        
        // set the POST request body and parameters
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'http://wilma_orion:1028/v2/entities', // use orion-proxy (PEP Proxy for Orion CB) IP address and port instead of Orion CB's 
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "id": "'.$id.'",
            "type": "Product",
            "availability": {
                "value": "'.$availability.'",
                "type": "Date"
            },
            "withdrawal": {
                "value": "'.$withdrawal.'",
                "type": "Date"
            },
            "sold_out": {
                "value": "'.$sold_out.'",
                "type": "Boolean"
            },
            "change_flag": {
                "value": "'.$change_flag.'",
                "type": "Number"
            }
          }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'X-Auth-Token: '.$_POST['oauth_token'].'',
            'Accept: application/json'
          ),
        ));
        
        $response = curl_exec($curl); // send request and get response 
        
        curl_close($curl);
        echo $response; 

    }


?>