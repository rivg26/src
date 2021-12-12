<?php


if($_SERVER['REQUEST_METHOD'] == "POST"){
    require_once 'functions.inc.php';
    session_start();
    if(isset($_POST['btnCustomerUpdate'])){
        $phoneNumber = validateData($_POST['customerListPhoneNumber']);
        $text = validateData($_POST['customerText']);
        // $text = $_POST['customerText'];
        $apicode = "ST-RONIV102938_YZMCN";
        $passwd = "}prcryxu((";
        
        
        $result = itexmo($phoneNumber,$text,$apicode,$passwd);
        if ($result == ""){
            echo json_encode([
                'status' => false
            ]);
        }
        else if ($result == 0){
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
