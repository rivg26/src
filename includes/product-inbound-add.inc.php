<?php


if($_SERVER['REQUEST_METHOD'] == "POST"){
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
    session_start();
    if(isset($_POST['s1'])){
        $pinProduct = $_POST['pinProduct'];
        $pinOption = $_POST['pinProductOption'];
        $pinPun = $_POST['pinPun'];
        $data = getPrice($conn, $pinProduct, $pinOption, $pinPun);
        echo json_encode([
            'status' => true,
            'price_plant_price' => $data['price_plant_price'],
            'price_final_price' => $data['price_final_price']
        ]);
    }

    if(isset($_POST['metric'])){
        $product = validateData($_POST['pinProduct']);
        $data =  getProductWeight($conn, $product);
        echo json_encode([
            'status' => true,
            'weight' => $data['product_weight']
        ]);
    }

    if(isset($_POST['insertProduct'])){
        $pinInvoice = validateData($_POST['pinInvoice']);
        $pinProductId = validateData($_POST['pinProduct']);
        $pinPun = validateData($_POST['pinPun']);
        $pinEcoderId = $_SESSION['empId'];
        $pinDate = validateData($_POST['pinDate']);
        $pinQuantity = validateData($_POST['pinQuantity']);
        $pinTotalQuantity = $pinQuantity;
        $pinTotalPlantPrice = validateData($_POST['pinTPlantPrice']);
        $pinTotalFinalPrice =  validateData($_POST['pinTFinalPrice']);
        $pinMetricTons = validateData($_POST['pinMetricTon']);
        $pinProductOption = validateData($_POST['pinProductOption']);
        $pinRemarks = validateData($_POST['pinRemarks']);

        insertProductInbound($conn,$pinInvoice,$pinProductId,$pinPun,$pinEcoderId,$pinDate,$pinQuantity,$pinTotalQuantity,$pinTotalPlantPrice,$pinTotalFinalPrice,$pinMetricTons,$pinProductOption,$pinRemarks);
        echo json_encode([
            'status' => true,
            'message' => $pinRemarks
        ]);
    }

}


function insertProductInbound($conn,$pinInvoice,$pinProductId,$pinPun,$pinEcoderId,$pinDate,$pinQuantity,$pinTotalQuantity,$pinTotalPlantPrice,$pinTotalFinalPrice,$pinMetricTons,$pinProductOption,$pinRemarks)
{
    $sql = "INSERT INTO `product_inbound_table` (pin_invoice, pin_product_id, pin_pun, pin_encoder_id, pin_date, pin_quantity, pin_total_quantity, pin_total_plant_price, pin_total_final_price, pin_metric_tons, pin_product_option, pin_remarks) VALUES (?,?,?,?,?,?,?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../product-inbound-add.inc.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sisisiidddss", $pinInvoice,$pinProductId,$pinPun,$pinEcoderId,$pinDate,$pinQuantity,$pinTotalQuantity,$pinTotalPlantPrice,$pinTotalFinalPrice,$pinMetricTons,$pinProductOption,$pinRemarks);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}



function getProductWeight($conn, $product)
{
    $sql = "SELECT product_weight FROM product_table WHERE product_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../product-inbound-add.inc.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "i", $product);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function getPrice($conn, $pinProduct, $pinOption, $pinPun)
{
    $sql = "SELECT price_pun, price_date, price_plant_price, price_final_price FROM price_table JOIN employee_table ON employee_table.emp_id = price_table.price_emp_id JOIN product_table ON product_table.product_id = price_product_id WHERE price_pun = ? AND price_product_id = ? AND price_type = ? ;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../product-inbound-add.inc.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sis", $pinPun, $pinProduct, $pinOption);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}




?>