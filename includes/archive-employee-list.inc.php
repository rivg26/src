<?php


if($_SERVER['REQUEST_METHOD'] == "POST"){
    session_start();
    require_once 'dbh.inc.php';
    if(isset($_POST['employeeArchive'])){
        $rowId = $_POST['rowId'];

        $sql = "SELECT * FROM admin_account_table WHERE acc_emp_id = '$rowId' ";
        $result = mysqli_query($conn,$sql);
        $sql2 = "SELECT * FROM expenses_table WHERE expenses_employee_id = '$rowId' ";
        $result2 = mysqli_query($conn,$sql2);

        if(mysqli_num_rows($result) > 0 || mysqli_num_rows($result2) > 0 ){
            echo json_encode([
                'status' => false
            ]);
        }
        else{


            $sql3 = "SELECT * FROM employee_table WHERE emp_id = '$rowId' ";
            $result3 = mysqli_query($conn,$sql3);
            while($row = mysqli_fetch_assoc($result3)){
                $sql4 = "INSERT INTO archive_employee_table(a_emp_number, a_emp_firstname, a_emp_middlename, a_emp_lastname, a_emp_birthday, a_emp_gender, a_emp_civilstatus, a_emp_education, a_emp_email, a_emp_phonenumber, a_emp_picpath) VALUES ('$row[emp_number]', '$row[emp_firstname]', '$row[emp_middlename]', '$row[emp_lastname]', '$row[emp_birthday]', '$row[emp_gender]',  '$row[emp_civilstatus]', '$row[emp_education]', '$row[emp_email]', '$row[emp_phonenumber]', '$row[emp_picpath]')";
                mysqli_query($conn,$sql4);
            }

            $sql5 = "DELETE FROM employee_table WHERE emp_id = '$rowId' ";
            mysqli_query($conn,$sql5);
            mysqli_close($conn);

            echo json_encode([
                'status' => true
            ]);
        }
        
    }

    if(isset($_POST['employeeDelete'])){
        $deleteRowId = $_POST['deleteRowId'];
        $sql6 = "DELETE FROM archive_employee_table WHERE a_emp_number = '$deleteRowId' ";
        mysqli_query($conn,$sql6);
        $sql7 = "DELETE FROM emp_address_table WHERE address_emp_number = '$deleteRowId'";
        mysqli_query($conn,$sql7);
        mysqli_close($conn);

        echo json_encode([
            "status" => true
        ]);
    }
}