<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (isset($_POST['gettingCustomerName'])) {

        $sql = "SELECT * FROM `customer_table`";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../price-update-add.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($resultData)) {
            $rows[] = $row;
        }
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        echo json_encode([
            'status' => true,
            'customerInfo' => $rows
        ]);
    }


    if(isset($_POST['gettingCustomerId'])){
        $phoneNumber = validateData($_POST['customerPhone']);
        $data = getCustomerId($conn,$phoneNumber);
        $id = $data['customer_id'];
        echo json_encode([
            "status" => true,
            "message" => $id 
        ]);
    }

    


    
}












function getCustomerId($conn,$phoneNumber)
{
    $sql = "SELECT customer_id, customer_number FROM `customer_table` WHERE customer_phone_number = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../sales-add.inc.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $phoneNumber);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } 

    mysqli_stmt_close($stmt);
}