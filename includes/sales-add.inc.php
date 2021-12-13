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
}
