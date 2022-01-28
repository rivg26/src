<?php


if($_SERVER['REQUEST_METHOD'] == "POST"){
    session_start();
    require_once 'dbh.inc.php';
    if(isset($_POST['lock'])){
        $rowId = $_POST['rowId'];
        $sql = "UPDATE admin_account_table SET acc_lock = '5' WHERE acc_id = '$rowId' ";
        mysqli_query($conn,$sql);
        echo json_encode([
            "status" => true
        ]);
    }
    if(isset($_POST['unlock'])){
        $rowId2 = $_POST['rowId'];
        $sql2 = "UPDATE admin_account_table SET acc_lock = '0' WHERE acc_id = '$rowId2' ";
        mysqli_query($conn,$sql2);
        echo json_encode([
            "status" => true
        ]);
    }
}