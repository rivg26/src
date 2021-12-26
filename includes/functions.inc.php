<?php

function validateData($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function CheckKeys($conn, $RandStr, $sql, $rowKey)
{
    
    $result = mysqli_query($conn, $sql);

    while ($Row = mysqli_fetch_assoc($result)) {
        if ($Row[$rowKey] === $RandStr) {
            return $KeyExists = true;
            break;
        } else {
            return $KeyExists = false;
        }
    }
}

function GenerateKey($conn, $sql, $code, $rowKey)
{
    $KeyLength = 8;
    $Str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $RandStr = substr(str_shuffle($Str), 0, $KeyLength);

    $CheckKey = CheckKeys($conn, $RandStr, $sql, $rowKey);
    while ($CheckKey === true) {
        $RandStr = substr(str_shuffle($Str), 0, $KeyLength);
    }
    return $code . $RandStr;
}

function itexmo($number, $message, $apicode, $passwd)
{
    $url = 'https://www.itexmo.com/php_api/api.php';
    $itexmo = array('1' => $number, '2' => $message, '3' => $apicode, 'passwd' => $passwd);
    $param = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($itexmo),
        ),
    );
    $context  = stream_context_create($param);
    return file_get_contents($url, false, $context);
}

//price-update-add

function printProductOption($conn,$productId)
{
    $sql = 'SELECT * FROM `product_table`';
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $selected = "";
        for($x = 1; $x <= 8; $x++){
            if($productId === $x && $row['product_id'] === "$x"){
                $selected = "selected";
            }
        }
        echo '<option value="'. $row['product_id']. '" '.$selected.'>'.$row['product_name'].'</option>';
    }
}

//price-update-report


function priceUpdateReportTable($conn)
{
    $sql = "SELECT price_date, price_pun, CONCAT(employee_table.emp_firstname,' ',employee_table.emp_middlename,' ',employee_table.emp_lastname) AS 'fullname' FROM `price_table` JOIN employee_table ON employee_table.emp_id = price_table.price_emp_id GROUP BY price_pun;";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        echo '
        <tr>
            <td>'.date('d M Y', strtotime($row['price_date'])).'</td>
            <td>'.$row['price_pun'].'</td>
            <td>'.$row['fullname'].'</td>
            <td><button type="button" class="btn btn-warning shadow-none" id = "btnPriceUpdateEdit" row.id="'.$row['price_pun'].'"><i class="fas fa-edit"></i></button> <button type="button" class="btn btn-danger shadow-none" row.id="'.$row['price_pun'].'"><i class="fas fa-trash-alt"></i></button></td>
        </tr>';
    }
}

function getPriceUpdateData($conn, $pun)
{
    $sql = "SELECT * FROM `price_table` WHERE price_pun = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../price-update-add.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $pun);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    
    while ($row= mysqli_fetch_assoc($resultData)) {
        $rows [] = $row;
        // echo '<pre>';
        // var_dump($row);
        // echo '</pre>';
    } 
    return $rows;
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

function getPunInbound($conn)
{
    $sql = "SELECT price_pun FROM price_table JOIN employee_table ON employee_table.emp_id = price_table.price_emp_id WHERE price_date IN (SELECT MAX(price_date) FROM price_table ) GROUP BY price_pun;";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        return $row;
    }
}



function productInboundTable($conn)
{
    $sql = "SELECT `pin_id`, `pin_invoice`, product_table.product_name, pin_pun, CONCAT(employee_table.emp_firstname ,' ', employee_table.emp_middlename, ' ', employee_table.emp_lastname) AS pin_employee_name, pin_date, pin_total_quantity, pin_total_plant_price, pin_total_final_price, pin_metric_tons, pin_product_option, pin_remarks FROM `product_inbound_table` JOIN product_table ON product_table.product_id = pin_product_id JOIN employee_table ON employee_table.emp_id = pin_encoder_id;";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        echo 
        '<tr>
            <td>'.date('d M Y', strtotime($row['pin_date'])).'</td>
            <td>'.$row['pin_invoice'].'</td>
            <td>'.$row['pin_pun'].'</td>
            <td>'.$row['product_name'].'</td>
            <td>'.$row['pin_total_quantity'].'</td>
            <td>'.number_format($row['pin_metric_tons'],2).'</td>
            <td>'.number_format($row['pin_total_plant_price'],2).'</td>
            <td>'.number_format($row['pin_total_final_price'],2).'</td>
            <td class="remarksWrapper">'.$row['pin_employee_name'].'</td>
            <td class="remarksWrapper">'.$row['pin_remarks'].'</td>
            <td><button type="button" class="btn btn-warning shadow-none mb-2" row.id="'.$row['pin_id'].'" id = "btnProductInboundEdit"><i class="fas fa-edit"></i></button> <button type="button" class="btn btn-danger shadow-none"><i class="fas fa-trash-alt"></i></button></td>
        </tr>';
    }
}


function getProductInboundData($conn, $pinId)
{
    $sql = "SELECT * FROM `product_inbound_table` WHERE pin_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../price-update-add.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "i", $pinId);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } 
    else{
        return false;
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}



function customerTable($conn)
{
    $sql = "SELECT `customer_number`, CONCAT(employee_table.emp_firstname, ' ', employee_table.emp_middlename, ' ', employee_table.emp_lastname) AS 'customer_employee_name', CONCAT( `customer_first_name`, ' ', `customer_middle_name`, ' ', `customer_last_name`) as 'customer_fullname', `customer_phone_number`, `customer_date`, CONCAT(customer_address_table.cus_address_unit, ' ', customer_address_table.cus_address_street, ' ', customer_address_table.cus_address_barangay, ' ', customer_address_table.cus_address_city, ' ', customer_address_table.cus_address_province) as 'customer_full_address' FROM `customer_table` JOIN employee_table ON employee_table.emp_id = customer_encoder_id JOIN customer_address_table ON customer_address_table.cus_customer_number = customer_number;";
    
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        echo 
        '<tr>
            <td>'.date('d M Y', strtotime($row['customer_date'])).'</td>
            <td>'.$row['customer_number'].'</td>
            <td>'.$row['customer_fullname'].'</td>
            <td>'.$row['customer_phone_number'].'</td>
            <td class="remarksWrapper">'.$row['customer_full_address'].'</td>
            <td class="remarksWrapper">'.$row['customer_employee_name'].'</td>
            <td><button type="button" class="btn btn-warning shadow-none" row.id="'.$row['customer_number'].'" id="btnEditCustomer"><i class="fas fa-edit"></i></button> <button type="button" class="btn btn-info shadow-none" row.id="'.$row['customer_phone_number'].'" id="btnSendText" data-bs-toggle="modal" data-bs-target="#customerSendModal" ><i class="fas fa-envelope-open-text"></i></button> <button type="button" class="btn btn-danger shadow-none"><i class="fas fa-trash-alt"></i></button></td>
        </tr>';
    }
}

function getCustomerData($conn, $customerId)
{
    $sql = "SELECT `customer_number`, `customer_first_name`, `customer_middle_name`, `customer_last_name`, `customer_phone_number`, customer_address_table.cus_address_unit, customer_address_table.cus_address_street, customer_address_table.cus_address_barangay, customer_address_table.cus_address_city, customer_address_table.cus_address_province, customer_address_table.cus_address_landmark FROM `customer_table` JOIN customer_address_table ON customer_address_table.cus_customer_number = customer_number WHERE `cus_customer_number` = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../funtions.inc.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $customerId);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } 
    else{
        return false;
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
function getPriceSaleData($conn)
{
    $sql = "SELECT product_table.product_name, price_table.price_final_price, price_table.price_type FROM `price_table` JOIN product_table ON product_table.product_id = price_product_id WHERE price_pun = (SELECT price_pun FROM price_table JOIN employee_table ON employee_table.emp_id = price_table.price_emp_id WHERE price_date IN (SELECT MAX(price_date) FROM price_table ) GROUP BY price_pun);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../funtions.inc.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    
    while($row = mysqli_fetch_assoc($resultData)) {
        $rows[] = $row;
    } 
    return $rows;
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
function getStocks($conn)
{
    $sql = "SELECT  product_table.product_name ,`pin_product_id`, SUM(`pin_quantity`) as 'total_quantity' FROM `product_inbound_table` JOIN product_table ON product_table.product_id = product_inbound_table.pin_product_id GROUP BY `pin_product_id`;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../funtions.inc.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    
    while($row = mysqli_fetch_assoc($resultData)) {
        $rows[] = $row;
    } 
    return $rows;
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

function salesTable($conn)
{
    $sql = "SELECT `sales_id`,`sales_purchase_date` ,`sales_invoice`, CONCAT( customer_table.customer_first_name, ' ', customer_table.customer_middle_name, ' ', customer_table.customer_last_name) AS 'customer_name', `sales_total_quantity`, `sales_total_price`,`sales_status`, CONCAT(employee_table.emp_firstname, ' ' , employee_table.emp_middlename, ' ', employee_table.emp_lastname) as 'emp_name' FROM `sales_table` JOIN customer_table ON customer_table.customer_id =`sales_customer_id` JOIN employee_table ON employee_table.emp_id = `sales_encoder_id`;";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        echo 
        '<tr>
            <td>'.date('d M Y', strtotime($row['sales_purchase_date'])).'</td>
            <td>'.$row['sales_invoice'].'</td>
            <td>'.$row['customer_name'].'</td>
            <td>'.number_format($row['sales_total_quantity'],2).'</td>
            <td>'.number_format($row['sales_total_price'],2).'</td>
            <td>'.$row['sales_status'].'</td>
            <td class="remarksWrapper">'.$row['emp_name'].'</td>
            <td><button type="button" class="btn btn-warning shadow-none" row.id = "'.$row['sales_invoice'].'" id ="btnViewSales"><i class="fas fa-edit"></i></button> <button type="button" class="btn btn-danger shadow-none"><i class="fas fa-trash-alt"></i></button></td>
        </tr>';
    }
}
function deliveryTable($conn)
{
    $sql = "SELECT `delivery_id`, `delivery_sales_invoice`, `delivery_date`, `delivery_status`, CONCAT(customer_table.customer_first_name, ' ', customer_table.customer_middle_name, ' ' , customer_table.customer_last_name) AS 'customer_name', CONCAT(customer_address_table.cus_address_unit,' ',customer_address_table.cus_address_street,' ',customer_address_table.cus_address_barangay,' ', customer_address_table.cus_address_city,' ',customer_address_table.cus_address_province) as 'customer_address' FROM `delivery_table` JOIN sales_table ON sales_table.sales_invoice = `delivery_sales_invoice` JOIN customer_table ON sales_table.sales_customer_id = customer_table.customer_id JOIN customer_address_table ON customer_address_table.cus_customer_number = customer_table.customer_number;";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        echo 
        '<tr>
            <td>'.date('d M Y', strtotime($row['delivery_date'])).'</td>
            <td>'.$row['delivery_sales_invoice'].'</td>
            <td>'.$row['customer_name'].'</td>
            <td>'.$row['delivery_status'].'</td>
            <td><button type="button" class="btn btn-warning shadow-none" row.id = "'.$row['delivery_sales_invoice'].'"><i class="fas fa-edit"></i></button> <button type="button" class="btn btn-info shadow-none" row.location= "'.$row['customer_address'].'" id ="viewLocation"><i class="fas fa-map-marked-alt"></i></button> <button type="button" class="btn btn-danger shadow-none"><i class="fas fa-trash-alt"></i></button></td>
        </tr>';
    }
}

function getSalesData($conn, $salesInvoice)
{
    $sql = "SELECT `sales_purchase_date`,`sales_invoice`, CONCAT(customer_table.customer_first_name,' ', customer_table.customer_middle_name, ' ', customer_table.customer_last_name) AS 'customer_name', CONCAT(employee_table.emp_firstname, ' ', employee_table.emp_middlename, ' ', employee_table.emp_lastname) AS 'emp_name', `sales_status`, `sales_total_quantity`, `sales_total_price` FROM `sales_table` JOIN customer_table ON customer_table.customer_id = `sales_customer_id` JOIN employee_table ON employee_table.emp_id = sales_encoder_id WHERE sales_invoice = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../funtions.inc.php?error=stmtfailed");
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
    mysqli_close($conn);
}

function salesItemTable($conn,$salesInvoice)
{
    $sql = "SELECT `item_invoice`, product_table.product_name, `item_quantity` ,`item_price`,`item_option` FROM `item_table` JOIN product_table ON product_table.product_id = `item_product_id` WHERE `item_invoice` = '$salesInvoice'";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        echo 
        '<tr>
            <td>'.$row['item_invoice'].'</td>
            <td>'.$row['product_name'].'</td>
            <td>'.$row['item_option'].'</td>
            <td>'.number_format($row['item_quantity'],2).'</td>
            <td>'.number_format($row['item_price'],2).'</td>
        </tr>';
    }
}

function customerHistoryTable($conn,$customerId)
{
    $sql = "SELECT `sales_id`,`sales_purchase_date` ,`sales_invoice`, CONCAT( customer_table.customer_first_name, ' ', customer_table.customer_middle_name, ' ', customer_table.customer_last_name) AS 'customer_name', `sales_total_quantity`, `sales_total_price`,`sales_status`, CONCAT(employee_table.emp_firstname, ' ' , employee_table.emp_middlename, ' ', employee_table.emp_lastname) as 'emp_name' FROM `sales_table` JOIN customer_table ON customer_table.customer_id =`sales_customer_id` JOIN employee_table ON employee_table.emp_id = `sales_encoder_id` WHERE customer_number = '$customerId';";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        echo 
        '<tr>
            <td>'.date('d M Y', strtotime($row['sales_purchase_date'])).'</td>
            <td>'.$row['sales_invoice'].'</td>
            <td>'.$row['customer_name'].'</td>
            <td>'.number_format($row['sales_total_quantity'],2).'</td>
            <td>'.number_format($row['sales_total_price'],2).'</td>
            <td>'.$row['sales_status'].'</td>
            <td class="remarksWrapper">'.$row['emp_name'].'</td>
        </tr>';
    }
}