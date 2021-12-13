<?php


// date_default_timezone_set('Asia/Hong_Kong');
// echo date('d M Y', strtotime(date('Y-m-d'))); 
// echo date('Y-m-d');

// Dateee Format

// $pwd = "admin123";
// $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
// echo $hashedPwd;

// session_start();
// echo $_SESSION['otpPhoneNumber'] .'<br>';
// echo $_SESSION['otp'].'<br>';
// echo $_SESSION['otpExpiration'].'<br>';
// echo $_SESSION['username'].'<br>';
// echo $_SESSION['forgotUsername'];

// echo !pwdvalidate('!Gregorio0226');

// function pwdvalidate($pwd){
// 	$pattern = "/[`'\"~!@# $*()<>,:;{}\|]/";
// 	if (strlen($pwd) <= 8) {
//         $pwdErr = true;
//     }
//     elseif(!preg_match("#[0-9]+#",$pwd)) {
//         $pwdErr = true;
//     }
//     elseif(!preg_match("#[A-Z]+#",$pwd)) {
//         $pwdErr = true;
//     }
//     elseif(!preg_match("#[a-z]+#",$pwd)) {
//         $pwdErr = true;
//     }
// 	elseif(!preg_match($pattern,$pwd)){
// 		$pwdErr = true;
// 	}
// 	else{
// 		$pwdErr = false;
// 	}
// 	return $pwdErr;
// }

require_once 'includes/functions.inc.php';
require_once 'includes/dbh.inc.php';

// echo insertCustomerAddress($conn,"cus-123","asd","asd","asd","asd","asd","asd");
// function insertCustomerAddress($conn,$customerNumber,$customerUnit,$customerStreet,$customerBarangay,$customerCity,$customerProvince,$customerLandmark)
// {
//     $sql = "INSERT INTO customer_address_table (cus_customer_number, cus_address_unit, cus_address_street, cus_address_barangay, cus_address_city, cus_address_province, cus_address_landmark ) VALUES (?,?,?,?,?,?,?)";
//     $stmt = mysqli_stmt_init($conn);
//     if (!mysqli_stmt_prepare($stmt, $sql)) {
//         header("location: ../customer-view.inc.php?error=stmtfailed");
//        exit();
//     }
    
//     mysqli_stmt_bind_param($stmt, "sssssss",$customerNumber,$customerUnit,$customerStreet,$customerBarangay,$customerCity,$customerProvince,$customerLandmark);
//     mysqli_stmt_execute($stmt);
//     mysqli_stmt_close($stmt);
// }

function getCustomerName($conn)
{
    $sql = "SELECT * FROM `customer_table`";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../price-update-add.php?error=stmtfailed");
        exit();
    }
    // mysqli_stmt_bind_param($stmt,);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    
    while ($row = mysqli_fetch_assoc($resultData)) {
         $rows [] = $row;
    } 
    return $rows;

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

var_dump( getCustomerName($conn));


// $data = getPriceUpdateData($conn, 'PUN-AfwgC42x');

// echo $data[0]['price_final_price'];

// echo json_encode(GenerateKey($conn, 'SELECT * FROM price_table;', 'PUN-', 'price_pun') );
// var_dump(getPunInbound($conn)) ;
// echo GenerateKey($conn, 'SELECT * FROM price_table;', 'PUN-', 'price_pun');
?>