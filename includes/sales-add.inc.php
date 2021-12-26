<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (isset($_POST['gettingCustomerName'])) {

        $sql = "SELECT * FROM `customer_table`";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../price-update-add.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($resultData)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        echo json_encode([
            'status' => true,
            'customerInfo' => $rows
        ]);
    }


    if (isset($_POST['gettingCustomerId'])) {
        $phoneNumber = validateData($_POST['customerPhone']);
        $data = getCustomerId($conn, $phoneNumber);
        $id = $data['customer_id'];
        echo json_encode([
            "status" => true,
            "message" => $id
        ]);
    }




    if (isset($_POST['salesSubmit'])) {

        $salesInvoice = validateData($_POST['salesInvoice']);
        $customerId = validateData($_POST['customerId']);
        $quantityCustomer = $_POST['items'];
        $totalPriceOverall = validateData($_POST['totalPriceOverall']);
        $totalQuantityOverall = validateData($_POST['totalQuantityOverall']);
        $allCustomerItems = $_POST['allItems'];
        date_default_timezone_set('Asia/Hong_Kong');
        $date = date('Y-m-d');


        $totalQuantityDB = getAllProductQuantity($conn);
        for($x = 0; $x < count($totalQuantityDB); $x++){
            if($totalQuantityDB[$x]['quantity'] == $allCustomerItems[$x]){
                $param = false;
                continue;
            }
            else{
                $param = true;
                break;
            }
        }

        if($param){
            echo json_encode([
                "status" => false
            ]);
        }
        else{
            for ($x = 0; $x < count($quantityCustomer); $x++) {
                (int)$quantityDB = getPinQuantity($conn, $quantityCustomer[$x][1]);
                $newQuantity = 0;
                for ($y = 0; $y < count($quantityDB); $y++) {
                    if ($newQuantity == 0) {
                        $newQuantity = $quantityCustomer[$x][3];
                    }
                    $finalQuantityCustomer = $newQuantity;
                    $result = $quantityDB[$y]["pin_quantity"] - $finalQuantityCustomer;
                    if (0 <= $result) {
                        $resulting = $quantityDB[$y]["pin_quantity"] - $finalQuantityCustomer;
                        updatePinSalesQuantity($conn, $resulting, $quantityDB[$y]["pin_invoice"]);
                        $newQuantity = 0;
                        break;
                    } else {
    
                        $newResult =  $finalQuantityCustomer - $quantityDB[$y]["pin_quantity"];
                        updatePinSalesQuantity($conn, 0, $quantityDB[$y]["pin_invoice"]);
                        $newQuantity = $newResult;
                    }
                }
                insertItems($conn, $quantityCustomer[$x][0], $date, $quantityCustomer[$x][1], $quantityCustomer[$x][3],$quantityCustomer[$x][4], $quantityCustomer[$x][2]);
            }
            session_start();
            insertSales($conn, $salesInvoice,$customerId, $date, $totalQuantityOverall, $totalPriceOverall, "pending", $_SESSION['empId']);
            insertDelivery($conn, $salesInvoice, $date, "to be delivered");
            echo json_encode([
                'status' => true
            ]);
        }

        
    }
}


function insertDelivery($conn, $salesInvoice, $date, $deliveryStatus)
{
    $sql = "INSERT INTO delivery_table(delivery_sales_invoice, delivery_date, delivery_status) VALUES (?,?,?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../sales-add.inc.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sss", $salesInvoice, $date, $deliveryStatus);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
function insertSales($conn, $salesInvoice,$customerId, $date, $salesTotalQuantity, $salesTotalPrice, $salesStatus, $salesEncoderId)
{
    $sql = "INSERT INTO sales_table(sales_invoice, sales_customer_id, sales_purchase_date, sales_total_quantity, sales_total_price, sales_status, sales_encoder_id) VALUES (?,?,?,?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../sales-add.inc.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sisidsi", $salesInvoice,$customerId, $date, $salesTotalQuantity, $salesTotalPrice, $salesStatus, $salesEncoderId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
function insertItems($conn, $salesInvoice, $date, $productId, $itemQuantity, $itemPrice, $itemOption)
{
    $sql = "INSERT INTO item_table(item_invoice, item_date, item_product_id, item_quantity, item_price, item_option) VALUES (?,?,?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../sales-add.inc.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ssiids", $salesInvoice, $date, $productId, $itemQuantity, $itemPrice, $itemOption);
    mysqli_stmt_execute($stmt);
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







function getCustomerId($conn, $phoneNumber)
{
    $sql = "SELECT customer_id, customer_number FROM `customer_table` WHERE customer_phone_number = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../sales-add.inc.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $phoneNumber);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }

    mysqli_stmt_close($stmt);
}
