<?php


if($_SERVER['REQUEST_METHOD'] == "POST"){
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if(isset($_POST['btnDeliverySave'])){
        $salesInvoice = $_POST['salesInvoice'];
        $data = getDeliveryStatus($conn, $salesInvoice);
        if(!($data['delivery_status'] == "to be delivered")){
            echo json_encode([
                "status" => false
            ]);
        }
        else{
            $deliveryStatus = "delivered";
            $saleStatus = "paid";
            updateSalesSuccess($conn,$saleStatus,$salesInvoice);
            updateDeliverySuccess($conn,$deliveryStatus,$salesInvoice);
            echo json_encode([
                "status" => true
            ]);
        }
    }

    if(isset($_POST['btnDeliveryCancel'])){
        $salesInvoice = $_POST['salesInvoice'];
        $data = getDeliveryStatus($conn, $salesInvoice);
        if(!($data['delivery_status'] == "to be delivered")){
            echo json_encode([
                "status" => false
            ]);
        }
        else{
           $cancelledItems = getCancelledItems($conn, $salesInvoice);
           for($x = 0; $x < count($cancelledItems); $x++){
                $data = getLatestQuantityOfItem($conn, $cancelledItems[$x]['item_product_id']);
                (int)$result = (int)$cancelledItems[$x]['item_quantity'] + (int)$data['pin_quantity'];
                updateProductQuantityCancelled($conn, $result , $data['pin_invoice']);
           }
           $deliveryStatus = "cancelled";
           $saleStatus = "cancelled";
           updateSalesSuccess($conn,$saleStatus,$salesInvoice);
           updateDeliverySuccess($conn,$deliveryStatus,$salesInvoice);
           echo json_encode([
            "status" => true
            ]);
        }
    }

}

function updateDeliverySuccess($conn,$deliveryStatus,$salesInvoice)
{
    $sql = "UPDATE delivery_table SET delivery_status = ? WHERE delivery_sales_invoice = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../delivery-report.inc.php?error=stmtfailed");
       exit();
    }
    mysqli_stmt_bind_param($stmt, "ss",$deliveryStatus,$salesInvoice);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);   
}
function updateSalesSuccess($conn,$saleStatus,$salesInvoice)
{
    $sql = "UPDATE sales_table SET sales_status = ? WHERE sales_invoice = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../delivery-report.inc.php?error=stmtfailed");
       exit();
    }
    mysqli_stmt_bind_param($stmt, "ss",$saleStatus,$salesInvoice);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
function getDeliveryStatus($conn, $salesInvoice)
{
    $sql = "SELECT * FROM `delivery_table` WHERE `delivery_sales_invoice` = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../delivery-report.inc.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $salesInvoice);
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

function getCancelledItems($conn, $salesInvoice)
{
    $sql = "SELECT `item_product_id`,`item_quantity` FROM `item_table` WHERE `item_invoice` = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../delivery-report.inc.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $salesInvoice);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    
    while ($row = mysqli_fetch_assoc($resultData)) {
        $rows[] = $row;
    } 
    return $rows;
    mysqli_stmt_close($stmt);
}

function getLatestQuantityOfItem($conn,$productId)
{
    $sql = "SELECT `pin_invoice`,`pin_product_id`, `pin_quantity` FROM `product_inbound_table` WHERE `pin_product_id` = ? AND `pin_date` = (SELECT MAX(`pin_date`) FROM `product_inbound_table` WHERE `pin_product_id` = ? LIMIT 1) ORDER BY `pin_id` DESC LIMIT 1;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../delivery-report.inc.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ii", $productId,$productId);
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

function updateProductQuantityCancelled($conn, $pin_quantity, $pin_invoice)
{
    $sql = "UPDATE `product_inbound_table` SET  pin_quantity = ? WHERE pin_invoice = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../delivery-report.inc.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "is", $pin_quantity, $pin_invoice);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}


?>