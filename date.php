<?php
// var myTableArray = [];
// $("#customerTable tr").each(function() {
//     var arrayOfThisRow = [];
//     var secondArray = [];
//     var tableData = $(this).find('td:not(:nth-child(2)):not(:last-child):not(:first-child)');
//     if (tableData.length > 0) {
//         tableData.each(function() {
//             // if($(this).text() === "DPR-13asdad"){
//             //     $(this).val() === "hello";
//             // }

//             arrayOfThisRow.push($(this).text());

//         });
//         myTableArray.push(arrayOfThisRow);
//     }

//     for (let x = 0; x < myTableArray.length; x++) {
//         for (let y = 0; y < 3; y++) {
//             if (myTableArray[x][y] === 'PETRON GASUL 7 KILOS Compact-Valve Type ("de salpak")') {
//                 myTableArray[x][y] = "hello";
//             }
//         }
//     }
// });


// var myTableArray = [];
// $("#customerTable tbody tr").each(function() {
//     var arrayOfThisRow = [];
//     var secondArray = [];
//     var tableData = $(this).find('td:not(:nth-child(2)):not(:last-child)');
//     if (tableData.length > 0) {
//         tableData.each(function() {
//             arrayOfThisRow.push($(this).text());
//         });
//         myTableArray.push(arrayOfThisRow);
//     }
//     // for (let x = 0; x < myTableArray.length; x++) {
//     //     for (let y = 0; y < 5; y++) {
//     //         if (myTableArray[x][y] === 'PETRON GASUL 50 KILOS') {
//     //             myTableArray[x][y] = "1";
//     //         }
//     //         if (myTableArray[x][y] === 'PETRON GASUL 22 KILOS') {
//     //             myTableArray[x][y] = "2";
//     //         }
//     //         if (myTableArray[x][y] === 'PETRON GASUL 11 KILOS Compact-Valve Type ("de salpak")') {
//     //             myTableArray[x][y] = "3";
//     //         }
//     //         if (myTableArray[x][y] === 'PETRON GASUL 11 KILOS POL Type ("de roskas")') {
//     //             myTableArray[x][y] = "4";
//     //         }
//     //         if (myTableArray[x][y] === 'PETRON GASUL 7 KILOS Compact-Valve Type ("de salpak")') {
//     //             myTableArray[x][y] = "5";
//     //         }
//     //         if (myTableArray[x][y] === 'PETRON GASUL 7 KILOS POL Type ("de roskas")') {
//     //             myTableArray[x][y] = "6";
//     //         }
//     //         if (myTableArray[x][y] === 'PETRON GASUL 2.7 KILOS Compact-Valve Type ("de salpak")') {
//     //             myTableArray[x][y] = "7";
//     //         }
//     //         if (myTableArray[x][y] === 'PETRON GASUL 2.7 KILOS POL Type ("de roskas")') {
//     //             myTableArray[x][y] = "8";
//     //         }
//     //     }
//     // }
// });

// date_default_timezone_set('Asia/Hong_Kong');
// // echo date('d M Y', strtotime(date('Y-m-d'))); 
// // echo date('Y-m-d');
// $today = date('d M Y', strtotime(date('Y-m-d')));
// echo $today;

// Dateee Format

// $pwd = "admin123";
// $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
// echo $hashedPwd;

// session_start();
// echo $_SESSION['otpPhoneNumber'] . '<br>';
// echo $_SESSION['otp'] . '<br>';
// echo $_SESSION['otpExpiration'] . '<br>';
// echo $_SESSION['username'] . '<br>';
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

// function getCustomerName($conn)
// {
//     $sql = "SELECT * FROM `customer_table`";
//     $stmt = mysqli_stmt_init($conn);
//     if (!mysqli_stmt_prepare($stmt, $sql)) {
//         header("location: ../price-update-add.php?error=stmtfailed");
//         exit();
//     }
//     // mysqli_stmt_bind_param($stmt,);
//     mysqli_stmt_execute($stmt);

//     $resultData = mysqli_stmt_get_result($stmt);

//     while ($row = mysqli_fetch_assoc($resultData)) {
//          $rows [] = $row;
//     } 
//     return $rows;

//     mysqli_stmt_close($stmt);
//     mysqli_close($conn);
// }

// var_dump(  getPriceSaleData($conn));


// $data = getPriceUpdateData($conn, 'PUN-AfwgC42x');

// echo $data[0]['price_final_price'];

// echo json_encode(GenerateKey($conn, 'SELECT * FROM price_table;', 'PUN-', 'price_pun') );
// var_dump(getPunInbound($conn)) ;
// echo GenerateKey($conn, 'SELECT * FROM price_table;', 'PUN-', 'price_pun');
// var_dump(getCustomerId($conn,"09264102938")) ;
// $data = getCustomerId($conn, "09264102938");
// echo $data['customer_id'];
// function getCustomerId($conn, $phoneNumber)
// {
//     $sql = "SELECT customer_id FROM `customer_table` WHERE customer_phone_number = ?";
//     $stmt = mysqli_stmt_init($conn);
//     if (!mysqli_stmt_prepare($stmt, $sql)) {
//         header("location: ../sales-add.inc.php?error=stmtfailed");
//         exit();
//     }
//     mysqli_stmt_bind_param($stmt, "s", $phoneNumber);
//     mysqli_stmt_execute($stmt);

//     $resultData = mysqli_stmt_get_result($stmt);

//     if ($row = mysqli_fetch_assoc($resultData)) {
//         return $row;
//     } else {
//         $result = false;
//         return $result;
//     }

//     mysqli_stmt_close($stmt);
//     mysqli_close($conn);
// }
// ['SINV-QFJcEeRx', '6', 'REFILL', '1', '606']


// $dbitems =[[23],[1],[4]];
// $customerItems = [[24]];



// $quantityCustomer = [['SINV-hj6iTdqG', '1', 'REFILL', '29', '98049'] , ['SINV-hj6iTdqG', '2', 'REFILL', '2', '3266'] , ['SINV-hj6iTdqG', '3', 'REFILL', '4', '3532']];

// for ($x = 0; $x < count($quantityCustomer); $x++) {

//     (int)$quantityDB = getPinQuantity($conn, $quantityCustomer[$x][1]);
    
//     $newQuantity = 0;
//     for ($y = 0; $y < count($quantityDB); $y++) {
//         if ($newQuantity == 0) {
//             $newQuantity = $quantityCustomer[$x][3];
//         }

//         $finalQuantityCustomer = $newQuantity;
//         $result = $quantityDB[$y]["pin_quantity"] - $finalQuantityCustomer;


//         if (0 <= $result) {
//             $resulting = $quantityDB[$y]["pin_quantity"] - $finalQuantityCustomer;

//             echo "Result: " . $resulting . " FinalQuantityCustomer: " . $quantityDB[$y]["pin_invoice"] . "<br>";

//             echo $resulting . " = " . $quantityDB[$y]["pin_quantity"]  . "-" . $finalQuantityCustomer . "<br>";
//             // updatePinSalesQuantity($conn, $resulting, $quantityDB[$y]["pin_invoice"]);
//             $newQuantity = 0;
//             break;
//         } else {

//             $newResult =  $finalQuantityCustomer - $quantityDB[$y]["pin_quantity"];
//             echo $newResult . " = " . $quantityDB[$y]["pin_quantity"] . " - " . $finalQuantityCustomer . "<br>";
//             // updatePinSalesQuantity($conn, 0, $quantityDB[$y]["pin_invoice"]);
//             $newQuantity = $newResult;
//         }

//         echo "y: " . $y . "<br>";
//     }
// }
// header('Content-type: application/json');

// $totalQuantityDB = getAllProductQuantity($conn);

// $allCustomerItems = ['29 ', '3 ', '4 ', '3 ', '6 ', '3 ', '4 ', '4 '];
// // $param = false;

// for($x = 0; $x < count($totalQuantityDB); $x++){
//     if($totalQuantityDB[$x]['quantity'] == $allCustomerItems[$x]){
//         $param = false;
//         continue;
//     }
//     else{
//         $param = true;
//         break;
//     }
// }

// // echo  count($totalQuantityDB);
// if($param){
//     echo "false";
// }
// else{
//     echo "true";
// }
// $totalQuantityDB = getAllProductQuantity($conn);

// // echo json_encode(getAllProductQuantity($conn), JSON_PRETTY_PRINT);
// // $param = false;
// for ($j = 0; $j < count($quantityCustomer); $j++) {
//     for ($k = 0; $k < count($totalQuantityDB); $k++) {
//         if ($quantityCustomer[$j][1] == $totalQuantityDB[$k]['pin_product_id']) {
//             $all = $totalQuantityDB[$k]['quantity'] - $quantityCustomer[$j][3];
//             if ($all < 0) {
//                 $param = false;
//             } else {
//                 $param = true;
                
//             }
//             break;
//         }
//     }
//     if ($param) {
//         continue;
//     } else {
        
//         break;
//     }
// }

// if ($param) {
//     echo json_encode($param); 
   
// } 
// else {
//     for ($x = 0; $x < count($quantityCustomer); $x++) {
//         (int)$quantityDB = getPinQuantity($conn, $quantityCustomer[$x][1]);
//         $newQuantity = 0;
//         for ($y = 0; $y < count($quantityDB); $y++) {
//             if ($newQuantity == 0) {
//                 $newQuantity = $quantityCustomer[$x][3];
//             }
//             $finalQuantityCustomer = $newQuantity;
//             $result = $quantityDB[$y]["pin_quantity"] - $finalQuantityCustomer;
//             if (0 <= $result) {
//                 $resulting = $quantityDB[$y]["pin_quantity"] - $finalQuantityCustomer;
//                 // updatePinSalesQuantity($conn, $resulting, $quantityDB[$y]["pin_invoice"]);
//                 $newQuantity = 0;
//                 break;
//             } else {

//                 $newResult =  $finalQuantityCustomer - $quantityDB[$y]["pin_quantity"];
//                 // updatePinSalesQuantity($conn, 0, $quantityDB[$y]["pin_invoice"]);
//                 $newQuantity = $newResult;
//             }
//         }
//     }

//     echo json_encode($param); 
// }


function getAllProductQuantity($conn)
{
    $sql = "SELECT `pin_product_id` , SUM(`pin_quantity`) AS 'quantity' FROM `product_inbound_table` GROUP BY pin_product_id;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../sales-add.inc.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($resultData)) {
        $rows[] = $row;
    }
    return $rows;
    mysqli_stmt_close($stmt);
}


function updatePinSalesQuantity($conn, $pin_quantity, $pin_invoice)
{
    $sql = "UPDATE `product_inbound_table` SET  pin_quantity = ? WHERE pin_invoice = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../sales-add.inc.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "is", $pin_quantity, $pin_invoice);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function getPinQuantity($conn, $productId)
{
    $sql = "SELECT `pin_invoice`, `pin_quantity` FROM `product_inbound_table` WHERE `pin_product_id` = ? AND `pin_quantity` != 0 ORDER BY `pin_date` ASC;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../sales-add.inc.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "i", $productId);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($resultData)) {
        $rows[] = $row;
    }
    return $rows;
    mysqli_stmt_close($stmt);
}


?>

