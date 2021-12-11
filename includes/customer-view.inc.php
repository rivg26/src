<?php

if($_SERVER['REQUEST_METHOD'] == "POST"){
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if(isset($_POST['sendPhoneNumber'])){
       
        $pattern = "/((\+[0-9]{2})|0)[.\- ]?9[0-9]{2}[.\- ]?[0-9]{3}[.\- ]?[0-9]{4}/";
        $phoneNumber = "0" . validateData($_POST['phoneNumber']);
        if(preg_match($pattern, $phoneNumber)){
            echo json_encode([
                'status' => true
            ]);
        }
        else{
            echo json_encode([
                'status' => false
            ]);
        }
    }







}



?>