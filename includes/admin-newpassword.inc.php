<?php


if($_SERVER['REQUEST_METHOD'] == "POST"){
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if(isset($_POST['newPassword'])){

        $newPassword = validateData($_POST['newPassword']);
        if(!pwdvalidate($newPassword)){
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

    if(isset($_POST['newPassword1'])){
        if(validateData($_POST['newPassword1']) !== validateData($_POST['firstPassword'])){
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

    if(isset($_POST['btnSubmitPass'])){
        session_start();
        if(isset($_SESSION['forgotUsername'])){
            $password1 = validateData($_POST['p1']);
            $password2 = validateData($_POST['p2']);
            if($password1 === $password2){
                $hashPassword = password_hash($password1, PASSWORD_DEFAULT);
                updateForgotPassword($conn,$hashPassword,$_SESSION['forgotUsername']);
                session_unset();
                session_destroy();
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
}

function updateForgotPassword($conn,$password,$username)
{
    $sql = "UPDATE admin_account_table SET acc_password = ? WHERE acc_username = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../admin-login.inc.php?error=stmtfailed");
       exit();
    }
    
    mysqli_stmt_bind_param($stmt, "ss",$password,$username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
   
}
function pwdvalidate($pwd){
	$pattern = "/[`'\"~!@# $*()<>,:;{}\|]/";

	if (strlen($pwd) <= 7) {
        $pwdErr = true;
    }
    elseif(!preg_match("#[0-9]+#",$pwd)) {
        $pwdErr = true;
    }
    elseif(!preg_match("#[A-Z]+#",$pwd)) {
        $pwdErr = true;
    }
    elseif(!preg_match("#[a-z]+#",$pwd)) {
        $pwdErr = true;
    }
	elseif(!preg_match($pattern,$pwd)){
		$pwdErr = true;
	}
	else{
		$pwdErr = false;
	}
	return $pwdErr;
}
