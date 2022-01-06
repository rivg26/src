<?php



if($_SERVER['REQUEST_METHOD'] == "POST"){
    require_once 'dbh.inc.php';
    if(isset($_POST['btnInventorySubmit'])){
        // $fromDate = $_POST['fromDate'];
        // $endDate = $_POST['endDate'];

        $sql = "SELECT product_table.product_name, product_table.product_weight ,SUM(`pin_quantity`) AS `rem_quantity`, SUM(`pin_total_quantity`) as `total_quantity` FROM `product_inbound_table` JOIN product_table ON product_table.product_id = pin_product_id WHERE `pin_date` GROUP BY `pin_product_id`;";

        $result = mysqli_query($conn, $sql);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows [] = $row;
        }

        if(is_null($rows)){
            echo json_encode("");
        }   
        else{
            echo json_encode($rows);
        }
        
        
    }
    if(isset($_POST['btnInventoryNext'])){
        $type = $_POST['type'];
        $sql = "SELECT product_table.product_name, price_table.price_plant_price ,price_table.price_final_price, price_table.price_type FROM `price_table` JOIN product_table ON product_table.product_id = price_product_id WHERE price_pun = (SELECT price_pun FROM price_table JOIN employee_table ON employee_table.emp_id = price_table.price_emp_id WHERE price_date IN (SELECT MAX(price_date) FROM price_table ) GROUP BY price_pun) AND `price_type` = '$type';
        ";

        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $rows [] = $row;
        }

        echo json_encode($rows);
    }

    if(isset($_POST['btnInventorySave'])){
        $invControlNumber = $_POST['invInvoice'];
        $invDate = $_POST['invDate'];
        $invType = $_POST['type'];
        $tableData = $_POST['tableData'];
        session_start();
        for($x = 0; $x < 8; $x++){

            insertInventory($conn, $invControlNumber, $invDate, $tableData[$x][0], $tableData[$x][1], $tableData[$x][2], $tableData[$x][3], $tableData[$x][4], $tableData[$x][5], $tableData[$x][6],$tableData[$x][7], $invType, $_SESSION['empId']);
        }
        echo json_encode([
            "status" => true
            
        ]);
    }
}


function insertInventory($conn, $invControlNumber, $invDate, $invName, $invWeight, $invQuantity, $invMetricTons, $invPlantPrice, $invTotalPrice, $invPlantValue, $invTotalValue, $invType,$invEmpId)
{
    $sql = "INSERT INTO inventory_table (inv_control_number, inv_date, inv_name, inv_weight, inv_quantity, inv_metric_tons, inv_plant_price, inv_total_price, inv_plant_value, inv_total_value, inv_type, inv_emp_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../inventory-report.inc.php?error=stmtfailed");
       exit();
    }
    
    mysqli_stmt_bind_param($stmt, "sssssssssssi", $invControlNumber, $invDate, $invName, $invWeight, $invQuantity, $invMetricTons, $invPlantPrice, $invTotalPrice, $invPlantValue, $invTotalValue, $invType,$invEmpId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}