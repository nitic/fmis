<?php
// PSU-Passport Restful Version 2

function psu_restful_authenticate($username,$password){
    $data = array(
            'Username' => $username,
            'Password' => $password,
            'Type' => 'json'
    );
    $data_string = json_encode($data);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://xxxx/passport/restfulV2.php");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $curl_response = curl_exec($ch);

    // curl error
    if ($curl_response === false) {
          $info = curl_getinfo($ch);
          curl_close($ch);
          die('error occured during curl exec. Additioanl info: ' . var_export($info));
    }
    // curl OK
    curl_close($ch);
    $decoded = json_decode($curl_response);
    // output
    if(isset($decoded->status) && $decoded->status == '200'){
      	// successful.. get ldap user info
        return $decoded->data;
    }else{
        // fail..
        return false;
    }

}
