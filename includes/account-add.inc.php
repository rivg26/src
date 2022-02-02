<?php

if($_SERVER['REQUEST_METHOD'] == "POST"){
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if(isset($_POST['checkEmp'])){
        $empId = $_POST['accEmployee'];
        if(getAccountEmp($conn,$empId)){
            echo json_encode([
                "status" => false
            ]);
        }
        else{
            $data = getAccountEmpData($conn,$empId);
            echo json_encode([
                "status" => true,
                "phoneNumber" => $data['emp_phonenumber']
            ]);
        }
    }

    if(isset($_POST['checkUsername'])){
        $username = validateData($_POST['accUsername']);
        if(checkAccountUsername($conn,$username)){
            echo json_encode([
                "status" => false
            ]);
        }
        else{
            $password = substr(str_shuffle(MD5(microtime())), 0, 10);
            echo json_encode([
                "status" => true,
                "pass" => $password
            ]);
        }
    }

    if(isset($_POST['btnAccSubmit'])){
        $accEmployee = $_POST['accEmployee'];
        $accRole = $_POST['accRole'];
        $accUsername = validateData($_POST['accUsername']);
        $accPassword = $_POST['accPassword'];
        $accPhoneNumber = $_POST['accPhoneNumber'];
        $accLock = 0;
        date_default_timezone_set('Asia/Hong_Kong');
        $accDate = date('Y-m-d');
        $hashedPwd = password_hash($accPassword, PASSWORD_DEFAULT);
        $apicode = "ST-RONIV102938_YZMCN";
        $passwd = "l$3ap3176e";
        $message = "Paredes Petron User Account | Username: ". $accUsername . " Password: ". $accPassword;
        itexmo($accPhoneNumber, $message, $apicode, $passwd);
        insertAccountData($conn,$accEmployee,$accRole,$accUsername,$hashedPwd,$accDate,$accLock);

        echo json_encode([
            "status" => true
        ]);
    }
}
function insertAccountData($conn,$accEmployee,$accRole,$accUsername,$accPassword,$accDate,$accLock)
{
    $sql = "INSERT INTO `admin_account_table` (acc_emp_id,acc_role,acc_username,acc_password,acc_date_creation,acc_lock) VALUES (?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../account-add.inc.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "issssi",$accEmployee,$accRole,$accUsername,$accPassword,$accDate,$accLock);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

function getAccountEmpData($conn,$empId)
{
    $sql = "SELECT emp_phonenumber FROM `employee_table` WHERE emp_id = ? ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../account-add.inc.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "i", $empId);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } 
    else{
        return false;
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
function getAccountEmp($conn,$empId)
{
    $sql = "SELECT * FROM `admin_account_table` WHERE acc_emp_id = ? ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../account-add.inc.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "i", $empId);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } 
    else{
        return false;
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
function checkAccountUsername($conn,$username)
{
    $sql = "SELECT * FROM `admin_account_table` WHERE acc_username = ? ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../account-add.inc.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } 
    else{
        return false;
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>