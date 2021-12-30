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
        $empNumber = $_POST['empNumber'];
        $empFirstName = ucfirst(validateData($_POST['empFirstName']));
        $empMiddleName = ucfirst(validateData($_POST['empMiddleName']));
        $empLastName = ucfirst(validateData($_POST['empLastName']));
        $empBirthday = validateData($_POST['empBirthday']);
        $empGender = validateData($_POST['empGender']);
        $empCivilStatus = validateData($_POST['empCivilStatus']);
        $empEducation = validateData($_POST['empEducation']);
        $empUnit = ucwords(validateData($_POST['empUnit']));
        $empStreet = ucwords(validateData($_POST['empStreet']));
        $empProvince = ucwords(validateData($_POST['empProvince']));
        $empCity = ucwords(validateData($_POST['empCity']));
        $empBarangay = ucwords(validateData($_POST['empBarangay']));
        $empPhoneNumber = "0" . validateData($_POST['empPhoneNumber']);
        $empEmail = validateData($_POST['empEmail']);
        
        $picPath = $_POST['empPicPath'];
        $picPath = "../" .  $picPath;
    
        if(file_exists($picPath)){
            $pic_filename = explode('../assets/temp/', $picPath)[1];
            rename($picPath, '../assets/uploads/' . $pic_filename);
            $newPicPath = 'assets/uploads/' . $pic_filename;
        }
        insertEmployeeData($conn,$empNumber,$empFirstName,$empMiddleName,$empLastName,$empBirthday,$empGender,$empCivilStatus,$empEducation,$empPhoneNumber,$empEmail,$newPicPath);
        insertEmployeeAddressData($conn,$empNumber,$empUnit,$empStreet,$empProvince,$empCity,$empBarangay);

        echo json_encode([
            "status" => true
        ]);
        
    }
    if(isset($_POST['btnUpdate'])){
        $empNumber = $_POST['empNumber'];
        $empFirstName = ucfirst(validateData($_POST['empFirstName']));
        $empMiddleName = ucfirst(validateData($_POST['empMiddleName']));
        $empLastName = ucfirst(validateData($_POST['empLastName']));
        $empBirthday = validateData($_POST['empBirthday']);
        $empGender = validateData($_POST['empGender']);
        $empCivilStatus = validateData($_POST['empCivilStatus']);
        $empEducation = validateData($_POST['empEducation']);
        $empUnit = ucwords(validateData($_POST['empUnit']));
        $empStreet = ucwords(validateData($_POST['empStreet']));
        $empProvince = ucwords(validateData($_POST['empProvince']));
        $empCity = ucwords(validateData($_POST['empCity']));
        $empBarangay = ucwords(validateData($_POST['empBarangay']));
        $empPhoneNumber = "0" . validateData($_POST['empPhoneNumber']);
        $empEmail = validateData($_POST['empEmail']);
        
    
        updateEmployeeData($conn,$empNumber,$empFirstName,$empMiddleName,$empLastName,$empBirthday,$empGender,$empCivilStatus,$empEducation,$empPhoneNumber,$empEmail);
        updateEmployeeAddressData($conn,$empNumber,$empUnit,$empStreet,$empProvince,$empCity,$empBarangay);

        echo json_encode([
            "status" => true
        ]);
        
    }



}


function updateEmployeeData($conn,$empNumber,$empFirstName,$empMiddleName,$empLastName,$empBirthday,$empGender,$empCivilStatus,$empEducation,$empPhoneNumber,$empEmail)
{
    $sql = "UPDATE employee_table SET emp_firstname= ?,emp_middlename= ?, emp_lastname= ?, emp_birthday= ?, emp_gender= ?, emp_civilstatus= ?, emp_education= ?, emp_email= ?, emp_phonenumber= ? WHERE emp_number = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../employee-add.inc.php?error=stmtfailed");
       exit();
    }
    
    mysqli_stmt_bind_param($stmt, "ssssssssss",$empFirstName,$empMiddleName,$empLastName,$empBirthday,$empGender,$empCivilStatus,$empEducation, $empEmail, $empPhoneNumber,$empNumber);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}


function insertEmployeeData($conn,$empNumber,$empFirstName,$empMiddleName,$empLastName,$empBirthday,$empGender,$empCivilStatus,$empEducation,$empPhoneNumber,$empEmail,$newPicPath)
{
    $sql = "INSERT INTO employee_table (emp_number, emp_firstname,emp_middlename, emp_lastname, emp_birthday, emp_gender, emp_civilstatus, emp_education, emp_email, emp_phonenumber, emp_picpath) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../employee-add.inc.php?error=stmtfailed");
       exit();
    }
    
    mysqli_stmt_bind_param($stmt, "sssssssssss", $empNumber,$empFirstName,$empMiddleName,$empLastName,$empBirthday,$empGender,$empCivilStatus,$empEducation, $empEmail, $empPhoneNumber,$newPicPath);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function updateEmployeeAddressData($conn,$empNumber,$empUnit,$empStreet,$empProvince,$empCity,$empBarangay)
{
    $sql = "UPDATE emp_address_table SET address_unit = ?, address_street = ?, address_barangay = ?, address_city = ?, address_province = ? WHERE address_emp_number = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../employee-add.inc.php?error=stmtfailed");
       exit();
    }
    
    mysqli_stmt_bind_param($stmt, "ssssss",$empUnit,$empStreet,$empBarangay,$empCity,$empProvince,$empNumber);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function insertEmployeeAddressData($conn,$empNumber,$empUnit,$empStreet,$empProvince,$empCity,$empBarangay)
{
    $sql = "INSERT INTO emp_address_table (address_emp_number, address_unit, address_street, address_barangay, address_city, address_province) VALUES (?,?,?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../employee-add.inc.php?error=stmtfailed");
       exit();
    }
    
    mysqli_stmt_bind_param($stmt, "ssssss", $empNumber,$empUnit,$empStreet,$empBarangay,$empCity,$empProvince);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function getEmployeeData($conn, $column, $data)
{
    $sql = "SELECT * FROM `employee_table` WHERE $column = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../employee-add.inc.php?error=stmtfailed");
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
}
