<?php

if($_SERVER['REQUEST_METHOD'] == "POST"){
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
    session_start();
    if(isset($_POST['btnSubmit'])){

        $expDate = $_POST['expDate'];
        $expControl = $_POST['expControl'];
        $expName = $_POST['expName'];
        $expAmount = validateData($_POST['expAmount']);
        $expCategory = strtolower(validateData($_POST['expCategory']));
        $expDescription = strtolower(validateData($_POST['expDescription']));
        $encoderId = $_SESSION['empId'];

        insertExpensesData($conn,$expControl,$expName,$encoderId,$expDate,$expAmount,$expCategory,$expDescription);

        echo json_encode([
            "status" => true
        ]);
    }

    if(isset($_POST['btnUpdate'])){
        $expControl = $_POST['expControl'];
        $expName = $_POST['expName'];
        $expAmount = validateData($_POST['expAmount']);
        $expCategory = strtolower(validateData($_POST['expCategory']));
        $expDescription = strtolower(validateData($_POST['expDescription']));
        $encoderId = $_SESSION['empId'];
        updateExpensesData($conn,$expControl,$expName,$encoderId,$expAmount,$expCategory,$expDescription);
        echo json_encode([
            "status" => true
        ]);
    }
}

function updateExpensesData($conn,$expControl,$expName,$encoderId,$expAmount,$expCategory,$expDescription)
{
    $sql = "UPDATE `expenses_table` SET expenses_employee_id = ?,expenses_emp_encoder_id = ?,expenses_amount = ?,expenses_category = ?,expenses_description = ? WHERE expenses_invoice = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../expenses-add.inc.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "iidsss",$expName,$encoderId,$expAmount,$expCategory,$expDescription,$expControl);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
function insertExpensesData($conn,$expControl,$expName,$encoderId,$expDate,$expAmount,$expCategory,$expDescription)
{
    $sql = "INSERT INTO `expenses_table` (expenses_invoice,expenses_employee_id,expenses_emp_encoder_id,expenses_date,expenses_amount,expenses_category,expenses_description) VALUES (?,?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../expenses-add.inc.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "siisdss", $expControl,$expName,$encoderId,$expDate,$expAmount,$expCategory,$expDescription);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}