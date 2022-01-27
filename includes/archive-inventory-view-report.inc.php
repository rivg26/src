<?php


if($_SERVER['REQUEST_METHOD'] == "POST"){
    session_start();
    require_once 'dbh.inc.php';
    if(isset($_POST['inventoryArchive'])){
        $rowId = $_POST['rowId'];
        $sql = "SELECT * FROM inventory_table WHERE inv_control_number = '$rowId' ";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $sql2 = "INSERT INTO archive_inventory_table (a_inv_control_number, a_inv_date, a_inv_name, a_inv_weight, a_inv_quantity, a_inv_metric_tons, a_inv_plant_price, a_inv_total_price, a_inv_plant_value, a_inv_total_value, a_inv_type, a_inv_emp_id) VALUES ('$row[inv_control_number]', '$row[inv_date]', '$row[inv_name]', '$row[inv_weight]', '$row[inv_quantity]', '$row[inv_metric_tons]', '$row[inv_plant_price]', '$row[inv_total_price]', '$row[inv_plant_value]', '$row[inv_total_value]', '$row[inv_type]', '$row[inv_emp_id]')";
            mysqli_query($conn,$sql2);
        }

        $sql3 = "DELETE FROM inventory_table WHERE inv_control_number = '$rowId'";
        mysqli_query($conn,$sql3);
        mysqli_close($conn);


        echo json_encode([
            "status" => true
        ]);
    }
    if(isset($_POST['inventoryRestore'])){
        $deleteRowId = $_POST['deleteRowId'];

        $sql4 = "SELECT * FROM archive_inventory_table WHERE a_inv_control_number = '$deleteRowId'";
        $result2 = mysqli_query($conn,$sql4);
        while($row2 = mysqli_fetch_assoc($result2)){
            $sql5 = "INSERT INTO inventory_table (inv_control_number, inv_date, inv_name, inv_weight, inv_quantity, inv_metric_tons, inv_plant_price, inv_total_price, inv_plant_value, inv_total_value, inv_type, inv_emp_id) VALUES ('$row2[a_inv_control_number]', '$row2[a_inv_date]', '$row2[a_inv_name]', '$row2[a_inv_weight]', '$row2[a_inv_quantity]', '$row2[a_inv_metric_tons]', '$row2[a_inv_plant_price]', '$row2[a_inv_total_price]', '$row2[a_inv_plant_value]', '$row2[a_inv_total_value]', '$row2[a_inv_type]', '$row2[a_inv_emp_id]')";
            mysqli_query($conn,$sql5);
        }
        $sql6 = "DELETE FROM archive_inventory_table WHERE a_inv_control_number = '$deleteRowId'";
        mysqli_query($conn,$sql6);
        mysqli_close($conn);

        echo json_encode([
            "status" => true
        ]);

    }

    if(isset($_POST['inventoryDelete'])){
        $deleteRowIds = $_POST['deleteRowId'];
        $sql7 = "DELETE FROM archive_inventory_table WHERE a_inv_control_number = '$deleteRowIds'";
        mysqli_query($conn,$sql7);
        mysqli_close($conn);

        echo json_encode([
            "status" => true
        ]);
    }
}