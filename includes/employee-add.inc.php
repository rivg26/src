<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (isset($_POST['validatePhone'])) {
        $success = false;
        $pattern = "/((\+[0-9]{2})|0)[.\- ]?9[0-9]{2}[.\- ]?[0-9]{3}[.\- ]?[0-9]{4}/";
        $number = '0' . $_POST['empPhoneNumber'];
        if (!preg_match($pattern, $number)) {
            echo json_encode([
                'status' => false,
                'message'=> "invalid"
            ]);
        } 
        elseif(getEmployeeData($conn, 'emp_phonenumber', $number)){
            echo json_encode([
                "status" => false,
                "message" => "duplicate"
            ]);
        }
        else {
            echo json_encode([
                'status' => true
            ]);
        }

    }
    if(isset($_POST['validateEmail'])){
        $email = validateData($_POST['empEmail']);

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            echo json_encode([
                "status" => false,
                "message" => "invalid"
            ]);
        }
        elseif(getEmployeeData($conn, 'emp_email', $email)){
            echo json_encode([
                "status" => false,
                "message" => "duplicate"
            ]);
        }
        else{
            echo json_encode([
                "status" => true
            ]);
        }
        
    }

    if(isset($_POST['btnSubmit'])){
        $picPath = $_POST['empPicPath'];
        
        $picPath = "../" .  $picPath;
    
        if(file_exists($picPath)){
            $pic_filename = explode('../assets/temp/', $picPath)[1];
            rename($picPath, '../assets/uploads/' . $pic_filename);
            $itemPicPath2 = 'assets/uploads/' . $pic_filename;

            echo json_encode([
                "status" => true,
                'message' => $itemPicPath2
            ]);
        }
        // echo json_encode([
        //     "status" => true,
        //     'message' => $picPath
        // ]);
        
    }



}

function getEmployeeData($conn, $column, $data)
{
    $sql = "SELECT * FROM `employee_table` WHERE $column = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../price-update-add.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $data);
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
