<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (isset($_POST['adminUsername'])) {
        if (!usernameExist($conn, validateData($_POST['adminUsername']))) {

            echo json_encode([
                'status' => false
            ]);

        }
        else{

            echo json_encode([
                'status' => true
            ]);

        }


    }

    if(isset($_POST['btnLogin'])){
 
        if (!usernameExist($conn, validateData($_POST['username']))) {

            echo json_encode([
                'status' => false
            ]);

        }
        else{

            $username = validateData($_POST['username']);
            $password = validateData($_POST['password']);
            $data = usernameExist($conn, validateData($_POST['username']));
            $hashPassword = $data['acc_password'];
            (int)$lock = $data['acc_lock'];
            $checkPassword = password_verify($password,$hashPassword);

            if($lock === 3){

                echo json_encode([
                    'status' => false,
                    'message' => 'accLock'
                ]);

            }
            elseif($checkPassword === false){

                $token = $lock + 1;
                adToken($conn,$username,$token);
                echo json_encode([
                    'status' => false
                ]);

            }
            else{

                adToken($conn,$username,0);
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['otpPhoneNumber'] = $data['emp_phonenumber'];
                $_SESSION['empId'] = $data['emp_id'];
                $_SESSION['accRole'] = $data['acc_role'];
                $_SESSION['redirect'] = 'dashboard.php';
                echo json_encode([
                    'status' => true
                ]);

            }

        }
    }
}


function usernameExist($conn, $username)
{
    $sql = "SELECT * FROM `admin_account_table` JOIN employee_table ON employee_table.emp_id = acc_emp_id WHERE acc_username = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../admin-login.inc.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}


function adToken($conn,$username,$token)
{
    $sql = "UPDATE admin_account_table SET acc_lock = ? WHERE acc_username = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../admin-login.inc.php?error=stmtfailed");
       exit();
    }
    
    mysqli_stmt_bind_param($stmt, "is",$token,$username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
   
}


