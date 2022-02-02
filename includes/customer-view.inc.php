<?php

if($_SERVER['REQUEST_METHOD'] == "POST"){
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
    session_start();
    if(isset($_POST['sendPhoneNumber'])){
       
        $pattern = "/((\+[0-9]{2})|0)[.\- ]?9[0-9]{2}[.\- ]?[0-9]{3}[.\- ]?[0-9]{4}/";
        $phoneNumber = "0" . validateData($_POST['phoneNumber']);
        if(preg_match($pattern, $phoneNumber)){

            if(checkPhoneNumber($conn,$phoneNumber)){
                echo json_encode([
                    'status' => false,
                    'message' => "exist"
                ]);
            }
            else{
                echo json_encode([
                    'status' => true
                ]);
            }  
        }
        else{
            echo json_encode([
                'status' => false
            ]);
        }
    }

    if(isset($_POST['customerSubmit'])){

        $customerFirstName = ucwords(validateData($_POST['customerFirstName']));
        $customerLastName = ucwords(validateData($_POST['customerLastName']));
        $customerMiddleName = ucwords(validateData($_POST['customerMiddleName']));
        $customerPhoneNumber = "0".validateData($_POST['customerPhoneNumber']);
        $customerUnit = ucwords(validateData($_POST['customerUnit']));
        $customerStreet = ucwords(validateData($_POST['customerStreet']));
        $customerBarangay = ucwords(validateData($_POST['customerBarangay']));
        $customerCity = ucwords(validateData($_POST['customerCity']));
        $customerProvince = ucwords(validateData($_POST['customerProvince']));
        $customerLandmark = ucwords(validateData($_POST['customerLandmark']));
        $customerNumber = validateData($_POST['customerNumber']);
        date_default_timezone_set('Asia/Hong_Kong');
        $customerDate = date('Y-m-d');
        $customerEncoderId = $_SESSION['empId'];
        insertCustomer($conn,$customerNumber,$customerEncoderId,$customerFirstName,$customerMiddleName,$customerLastName,$customerPhoneNumber,$customerDate);
        insertCustomerAddress($conn,$customerNumber,$customerUnit,$customerStreet,$customerBarangay,$customerCity,$customerProvince,$customerLandmark);
        echo json_encode([
            'status' => true
        ]);

    }

    if(isset($_POST['customerUpdate'])){
        $customerFirstName = ucwords(validateData($_POST['customerFirstName']));
        $customerLastName = ucwords(validateData($_POST['customerLastName']));
        $customerMiddleName = ucwords(validateData($_POST['customerMiddleName']));
        $customerPhoneNumber = "0".validateData($_POST['customerPhoneNumber']);
        $customerUnit = ucwords(validateData($_POST['customerUnit']));
        $customerStreet = ucwords(validateData($_POST['customerStreet']));
        $customerBarangay = ucwords(validateData($_POST['customerBarangay']));
        $customerCity = ucwords(validateData($_POST['customerCity']));
        $customerProvince = ucwords(validateData($_POST['customerProvince']));
        $customerLandmark = ucwords(validateData($_POST['customerLandmark']));
        $customerNumber = validateData($_POST['customerNumber']);
        date_default_timezone_set('Asia/Hong_Kong');
        $customerDate = date('Y-m-d');
        $customerEncoderId = $_SESSION['empId'];
        updateCustomer($conn,$customerNumber,$customerEncoderId,$customerFirstName,$customerMiddleName,$customerLastName,$customerPhoneNumber);
        updateCustomerAddress($conn,$customerNumber,$customerUnit,$customerStreet,$customerBarangay,$customerCity,$customerProvince,$customerLandmark);
        echo json_encode([
            'status' => true
        ]);
    }





}



function updateCustomer($conn,$customerNumber,$customerEncoderId,$customerFirstName,$customerMiddleName,$customerLastName,$customerPhoneNumber)
{
    $sql = "UPDATE customer_table SET customer_encoder_id = ?, customer_first_name = ?, customer_middle_name = ?, customer_last_name = ?, customer_phone_number = ?  WHERE customer_number = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../customer-view.inc.php?error=stmtfailed");
       exit();
    }
    
    mysqli_stmt_bind_param($stmt, "isssss",$customerEncoderId,$customerFirstName,$customerMiddleName,$customerLastName,$customerPhoneNumber,$customerNumber);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
function updateCustomerAddress($conn,$customerNumber,$customerUnit,$customerStreet,$customerBarangay,$customerCity,$customerProvince,$customerLandmark)
{
    $sql = "UPDATE customer_address_table SET  cus_address_unit = ?, cus_address_street = ?, cus_address_barangay = ?, cus_address_city = ?, cus_address_province = ?, cus_address_landmark = ? WHERE cus_customer_number = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../customer-view.inc.php?error=stmtfailed");
       exit();
    }
    
    mysqli_stmt_bind_param($stmt, "sssssss",$customerUnit,$customerStreet,$customerBarangay,$customerCity,$customerProvince,$customerLandmark,$customerNumber);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function insertCustomer($conn,$customerNumber,$customerEncoderId,$customerFirstName,$customerMiddleName,$customerLastName,$customerPhoneNumber,$customerDate)
{
    $sql = "INSERT INTO customer_table (customer_number, customer_encoder_id, customer_first_name , customer_middle_name , customer_last_name , customer_phone_number , customer_date ) VALUES (?,?,?,?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../customer-view.inc.php?error=stmtfailed");
       exit();
    }
    
    mysqli_stmt_bind_param($stmt, "sisssss",$customerNumber,$customerEncoderId,$customerFirstName,$customerMiddleName,$customerLastName,$customerPhoneNumber,$customerDate);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function insertCustomerAddress($conn,$customerNumber,$customerUnit,$customerStreet,$customerBarangay,$customerCity,$customerProvince,$customerLandmark)
{
    $sql = "INSERT INTO customer_address_table (cus_customer_number, cus_address_unit, cus_address_street, cus_address_barangay, cus_address_city, cus_address_province, cus_address_landmark ) VALUES (?,?,?,?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../customer-view.inc.php?error=stmtfailed");
       exit();
    }
    
    mysqli_stmt_bind_param($stmt, "sssssss",$customerNumber,$customerUnit,$customerStreet,$customerBarangay,$customerCity,$customerProvince,$customerLandmark);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
function checkPhoneNumber($conn,$phoneNumber)
{
    $sql = "SELECT customer_phone_number FROM customer_table WHERE customer_phone_number = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../customer-view.inc.php?error=stmtfailed");
       exit();
    }
    
    mysqli_stmt_bind_param($stmt, "s",$phoneNumber);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } 
    else{
        return false;
    }
    mysqli_stmt_close($stmt);
}


?>