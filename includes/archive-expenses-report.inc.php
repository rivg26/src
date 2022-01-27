<?php

if($_SERVER['REQUEST_METHOD'] == "POST"){
    session_start();
    require_once 'dbh.inc.php';
    if(isset($_POST['expensesArchive'])){
        $rowId = $_POST['rowId'];
        $sql = "SELECT * FROM expenses_table WHERE expenses_id = '$rowId' ";
        $result = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_assoc($result)){
            $sql2 = "INSERT INTO archive_expenses_table(a_expenses_invoice, a_expenses_employee_id, a_expenses_emp_encoder_id, a_expenses_date, a_expenses_amount, a_expenses_category,a_expenses_description) VALUES ('$row[expenses_invoice]', '$row[expenses_employee_id]' , '$row[expenses_emp_encoder_id]', '$row[expenses_date]', '$row[expenses_amount]','$row[expenses_category]','$row[expenses_description]')";
            mysqli_query($conn,$sql2);
        }
        $sql3 = "DELETE FROM expenses_table WHERE expenses_id = '$rowId' ";
        mysqli_query($conn,$sql3);
        mysqli_close($conn);
        echo json_encode([
            "status" => true
        ]);
    }

    if(isset($_POST['expensesDelete'])){
        $deleteRowId = $_POST['deleteRowId'];
        $sql4 = "DELETE FROM archive_expenses_table WHERE a_expenses_id = '$deleteRowId' ";
        mysqli_query($conn,$sql4);
        mysqli_close($conn);
        echo json_encode([
            "status" => true
        ]);
    }
}