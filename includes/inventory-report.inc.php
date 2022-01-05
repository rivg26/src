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
}