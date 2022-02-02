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


function newCheckKeys($conn, $RandStr, $sql, $rowKey, $sql2, $rowKey2)
{
    
    $result = mysqli_query($conn, $sql);
    $check = true;
    while ($Row = mysqli_fetch_assoc($result)) {
        if ($Row[$rowKey] === $RandStr) {
            return true;
            break;
        } else {
            $check = false;
        }
    }


    if(!$check){

        $result2 = mysqli_query($conn,$sql2);

        while($row = mysqli_fetch_assoc($result2)){
            if($row[$rowKey2] === $RandStr){
                return true;
            }
            else{
                return false;
            }
        }
    }

}

function newGenerateKey($conn, $sql, $code, $rowKey, $sql2, $rowKey2)
{
    $KeyLength = 8;
    $Str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $RandStr = substr(str_shuffle($Str), 0, $KeyLength);

    $CheckKey = newCheckKeys($conn, $RandStr, $sql, $rowKey, $sql2, $rowKey2);
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
    $sql = "SELECT price_date, price_pun, CONCAT(employee_table.emp_lastname, ', ', employee_table.emp_firstname, ' ' , SUBSTR(employee_table.emp_middlename,1,1), '.') AS 'fullname' FROM `price_table` JOIN employee_table ON employee_table.emp_id = price_table.price_emp_id GROUP BY price_pun;";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        echo '
        <tr>
            <td>'.date('d M Y', strtotime($row['price_date'])).'</td>
            <td>'.$row['price_pun'].'</td>
            <td>'.$row['fullname'].'</td>
            <td><button type="button" class="btn btn-warning shadow-none" id = "btnPriceUpdateEdit" row.id="'.$row['price_pun'].'" data-bs-toggle="tooltip" data-bs-placement="top" title="View/Edit"><i class="fas fa-edit"></i></button> <button type="button" class="btn btn-danger shadow-none" row.id="'.$row['price_pun'].'" data-bs-toggle="modal" data-bs-target="#priceUpdateTableModal" id = "btnPriceUpdateArchive"><i class="fas fa-archive" data-bs-toggle="tooltip" data-bs-placement="top" title="Archive"></i></button></td>
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
    $sql = "SELECT `pin_id`, `pin_invoice`, product_table.product_name, pin_pun,CONCAT(employee_table.emp_lastname, ', ', employee_table.emp_firstname, ' ' , SUBSTR(employee_table.emp_middlename,1,1), '.') AS pin_employee_name, pin_date,pin_quantity, pin_total_quantity, pin_total_plant_price, pin_total_final_price, pin_metric_tons, pin_product_option, pin_remarks FROM `product_inbound_table` JOIN product_table ON product_table.product_id = pin_product_id JOIN employee_table ON employee_table.emp_id = pin_encoder_id;";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        echo 
        '<tr>
            <td>'.date('d M Y', strtotime($row['pin_date'])).'</td>
            <td style= "font-size: 1.1rem">'.$row['pin_invoice'].'</td>
            <td style= "font-size: 1.1rem">'.$row['pin_pun'].'</td>
            <td style= "font-size: 1.1rem">'.$row['product_name'].'</td>
            <td>'.$row['pin_quantity'].'</td>
            <td>'.$row['pin_total_quantity'].'</td>
            <td>'.number_format($row['pin_metric_tons'],2).'</td>
            <td>'.number_format($row['pin_total_plant_price'],2).'</td>
            <td>'.number_format($row['pin_total_final_price'],2).'</td>
            <td class="remarksWrapper">'.$row['pin_employee_name'].'</td>
            <td class="remarksWrapper">'.$row['pin_remarks'].'</td>
            <td> <button type="button" class="btn btn-danger shadow-none" data-bs-toggle="modal" data-bs-target="#productInboundTableArchiveModal" id = "btnProductInboundArchive" row.id="'.$row['pin_id'].'" ><i class="fas fa-archive" data-bs-toggle="tooltip" data-bs-placement="top" title="Archive"></i></button></td>
        </tr>';
    }
    // <button type="button" class="btn btn-warning shadow-none mb-2" row.id="'.$row['pin_id'].'" id = "btnProductInboundEdit" data-bs-toggle="tooltip" data-bs-placement="top" title="View/Edit"><i class="fas fa-edit"></i></button>
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
    $sql = "SELECT customer_id, `customer_number`, CONCAT(employee_table.emp_lastname, ', ', employee_table.emp_firstname, ' ' , SUBSTR(employee_table.emp_middlename,1,1), '.') AS 'customer_employee_name', CONCAT( `customer_first_name`, ' ', `customer_middle_name`, ' ', `customer_last_name`) as 'customer_fullname', `customer_phone_number`, `customer_date`, CONCAT(customer_address_table.cus_address_unit, ' ', customer_address_table.cus_address_street, ' ', customer_address_table.cus_address_barangay, ' ', customer_address_table.cus_address_city, ' ', customer_address_table.cus_address_province) as 'customer_full_address' FROM `customer_table` JOIN employee_table ON employee_table.emp_id = customer_encoder_id JOIN customer_address_table ON customer_address_table.cus_customer_number = customer_number;";
    
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
            <td><button type="button" class="btn btn-warning shadow-none" row.id="'.$row['customer_number'].'" id="btnEditCustomer" data-bs-toggle="tooltip" data-bs-placement="top"  title="View/Edit"><i class="fas fa-edit"></i></button>  <button type="button" class="btn btn-danger shadow-none" data-bs-toggle="modal" data-bs-target="#customerArchiveModal" row.id="'.$row['customer_id'].'" id="btnArchiveCustomer" ><i class="fas fa-archive"  data-bs-toggle="tooltip" data-bs-placement="top"  title="Archive"></i></button></td>
        </tr>';
    }
    // <button type="button" class="btn btn-info shadow-none" row.id="'.$row['customer_phone_number'].'" id="btnSendText" data-bs-toggle="modal" data-bs-target="#customerSendModal" ><i class="fas fa-envelope-open-text"></i></button>
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
    $sql = "SELECT `sales_id`,`sales_purchase_date` ,`sales_invoice`, CONCAT( customer_table.customer_first_name, ' ', customer_table.customer_middle_name, ' ', customer_table.customer_last_name) AS 'customer_name', `sales_total_quantity`, `sales_total_price`,`sales_status`,  CONCAT(employee_table.emp_lastname, ', ', employee_table.emp_firstname, ' ' , SUBSTR(employee_table.emp_middlename,1,1), '.') as 'emp_name' FROM `sales_table` JOIN customer_table ON customer_table.customer_id =`sales_customer_id` JOIN employee_table ON employee_table.emp_id = `sales_encoder_id`;";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        if($row['sales_status'] == "pending"){
            $color = "alert alert-warning";
            $icon = '<i class="fas fa-pencil-alt"></i>';
        }
        elseif($row['sales_status'] == "paid"){
            $color = "alert alert-success";
            $icon = '<i class="fas fa-donate"></i>';
        }
        else{
            $color = "alert alert-danger";
            $icon = '<i class="fas fa-ban"></i>';
        }
        echo 
        '<tr>
            <td>'.date('d M Y', strtotime($row['sales_purchase_date'])).'</td>
            <td>'.$row['sales_invoice'].'</td>
            <td>'.$row['customer_name'].'</td>
            <td>'.number_format($row['sales_total_quantity'],2).'</td>
            <td>'.number_format($row['sales_total_price'],2).'</td>
            <td> <div class = "'.$color.' my-3">'.$icon.' '.$row['sales_status'].'</div></td>
            <td class="remarksWrapper">'.$row['emp_name'].'</td>
            <td><button type="button" class="btn btn-warning shadow-none" row.id = "'.$row['sales_invoice'].'" id ="btnViewSales" data-bs-toggle="tooltip" data-bs-placement="top" title="View/Edit" ><i class="fas fa-edit"></i></button> <button type="button" class="btn btn-danger shadow-none" row.id = "'.$row['sales_invoice'].'" data-bs-toggle="modal" data-bs-target="#salesTableArchiveModal"  id ="btnArchiveSales" ><i class="fas fa-archive" data-bs-toggle="tooltip" data-bs-placement="top" title="Archive"></i></button></td>
        </tr>';
    }
}
function deliveryTable($conn)
{
    $sql = "SELECT `delivery_id`, `delivery_sales_invoice`, `delivery_date`, `delivery_status`, CONCAT(customer_table.customer_first_name, ' ', customer_table.customer_middle_name, ' ' , customer_table.customer_last_name) AS 'customer_name', CONCAT(customer_address_table.cus_address_unit,' ',customer_address_table.cus_address_street,' ',customer_address_table.cus_address_barangay,' ', customer_address_table.cus_address_city,' ',customer_address_table.cus_address_province) as 'customer_address' FROM `delivery_table` JOIN sales_table ON sales_table.sales_invoice = `delivery_sales_invoice` JOIN customer_table ON sales_table.sales_customer_id = customer_table.customer_id JOIN customer_address_table ON customer_address_table.cus_customer_number = customer_table.customer_number;";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        if($row['delivery_status'] == "to be delivered"){
            $color = "alert alert-warning";
            $icon = '<i class="fas fa-truck-loading"></i>';
        }
        elseif($row['delivery_status'] == "delivered"){
            $color = "alert alert-success";
            $icon = '<i class="fas fa-truck"></i>';
        }
        else{
            $color = "alert alert-danger";
            $icon = '<i class="fas fa-ban"></i>';
        }
        echo 
        '<tr>
            <td>'.date('d M Y', strtotime($row['delivery_date'])).'</td>
            <td>'.$row['delivery_sales_invoice'].'</td>
            <td>'.$row['customer_name'].'</td>
            <td><div class="'.$color.' my-3"> '.$icon.' '.$row['delivery_status'].'</div></td>
            <td><button type="button" class="btn btn-success shadow-none" row.id = "'.$row['delivery_sales_invoice'].'"  data-bs-toggle="modal" data-bs-target="#deliveryModal" id= "btnDelivered" data-backdrop="false"><i class="fas fa-truck-loading" data-bs-toggle="tooltip" data-bs-placement="top" title="Delivered"></i></button> <button type="button" class="btn btn-warning shadow-none" row.id = "'.$row['delivery_sales_invoice'].'"  data-bs-toggle="modal" data-bs-target="#cancelModal" id= "btnCancel" data-backdrop="false"><i class="fas fa-ban" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancelled"></i></button> <button type="button" class="btn btn-info shadow-none" row.location= "'.$row['customer_address'].'" id ="viewLocation" data-bs-toggle="tooltip" data-bs-placement="top" title="View Location"><i class="fas fa-map-marked-alt"></i></button> </td>
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

function employeeTable($conn)
{
    $sql = "SELECT emp_id, emp_number, emp_firstname, emp_middlename, emp_lastname, emp_phonenumber, emp_email FROM `employee_table`";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        echo 
        '<tr>
            <td>'.$row['emp_number'].'</td>
            <td>'.ucfirst($row['emp_lastname']). ', ' . ucfirst($row['emp_firstname']). ' '. ucfirst(substr($row['emp_middlename'],0,1)) .'.'.'</td>
            <td>'.$row['emp_phonenumber'].'</td>
            <td>'.$row['emp_email'].'</td>
            <td><button type="button" class="btn btn-warning shadow-none" id = "btnEditEmployee"  row.id ="'.$row['emp_number'].'"data-bs-toggle="tooltip" data-bs-placement="top" title="View/Edit"><i class="fas fa-edit"></i></button> <button type="button" class="btn btn-danger shadow-none" data-bs-toggle="modal" data-bs-target="#employeeArchiveModal"  id = "btnArchiveEmployee"  row.id ="'.$row['emp_id'].'"><i class="fas fa-archive" data-bs-toggle="tooltip" data-bs-placement="top" title="Archive"></i></button></td>
        </tr>';
    }
}


function getEmployeeDataTable($conn, $empNumber)
{
    $sql = "SELECT * FROM `employee_table` JOIN emp_address_table ON emp_address_table.address_emp_number = emp_number WHERE emp_number = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../funtions.inc.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $empNumber);
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


function expensesEmployeeSelect($conn,$empId)
{
    $sql = "SELECT emp_id, emp_firstname, emp_middlename, emp_lastname FROM `employee_table`";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $selected = "";
        for($x = 1; $x <= 8; $x++){
            if($empId === $x && $row['emp_id'] === "$x"){
                $selected = "selected";
            }
        }
       echo '<option value="'.$row['emp_id'].'" '.$selected.'>'.ucfirst($row['emp_lastname']). ', ' . ucfirst($row['emp_firstname']). ' '. ucfirst(substr($row['emp_middlename'],0,1)) .'.'.'</option>';
    }
}


function expensesTable($conn)
{
    $sql = "SELECT t.expenses_id, t.expenses_invoice, t.expenses_date, t.expenses_amount, t.expenses_category, t.expenses_description, CONCAT(e1.emp_lastname, ', ', e1.emp_firstname, ' ', SUBSTR(e1.emp_middlename,1,1), '.') AS 'employee_name', CONCAT(e2.emp_lastname, ', ', e2.emp_firstname, ' ', SUBSTR(e2.emp_middlename,1,1), '.') AS 'encoder_name' FROM `expenses_table` t JOIN employee_table e1 ON e1.emp_id = t.expenses_employee_id JOIN employee_table e2 ON e2.emp_id = t.expenses_emp_encoder_id;";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        echo 
        '<tr>
            <td>'.$row['expenses_date'].'</td>
            <td>'.$row['expenses_invoice'].'</td>
            <td>'.$row['employee_name'].'</td>
            <td>'.$row['expenses_amount'].'</td>
            <td>'.$row['expenses_category'].'</td>
            <td class="remarksWrapper">'.$row['encoder_name'].'</td>
            <td class="remarksWrapper">'.$row['expenses_description'].'</td>
            <td><button type="button" class="btn btn-warning shadow-none" row.id = "'.$row['expenses_id'].'" id="btnEditExpenses" data-bs-toggle="tooltip" data-bs-placement="top" title="View/Edit" ><i class="fas fa-edit"></i></button> <button type="button" class="btn btn-danger shadow-none" data-bs-toggle="modal" data-bs-target="#expensesArchiveModal" row.id = "'.$row['expenses_id'].'"  id="btnArchiveExpenses"><i class="fas fa-archive" data-bs-toggle="tooltip" data-bs-placement="top" title="Archive"></i></button></td>
        </tr>';
    }
}

function getExpensesData($conn,$expensesId)
{
    $sql = "SELECT * FROM `expenses_table` WHERE expenses_id = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../funtions.inc.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "i", $expensesId);
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

function viewInventoryTable($conn)
{
    $sql = "SELECT `inv_control_number`,`inv_date`,`inv_type`, CONCAT(employee_table.emp_lastname, ', ', employee_table.emp_firstname, ' ', SUBSTRING(employee_table.emp_middlename,1,1),'.') AS 'encoder_name' FROM `inventory_table` JOIN employee_table ON employee_table.emp_id = inv_emp_id GROUP BY `inv_control_number`;";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        echo 
        '<tr>
            <td>'.date('d M Y', strtotime($row['inv_date'])).'</td>
            <td>'.$row['inv_control_number'].'</td>
            <td>'.$row['inv_type'].'</td>
            <td>'.$row['encoder_name'].'</td>
            <td><button type="button" class="btn btn-warning shadow-none" row.id = "'.$row['inv_control_number'].'" id="btnViewInventory" data-bs-toggle="tooltip" data-bs-placement="top" title="View"><i class="fas fa-eye"></i></button> <button type="button" class="btn btn-danger shadow-none" data-bs-toggle="modal" data-bs-target="#inventoryArchiveModal" row.id = "'.$row['inv_control_number'].'" id = "btnArchiveInventory" ><i class="fas fa-archive"  data-bs-toggle="tooltip" data-bs-placement="top" title="Archive"></i></button></td>
        </tr>';
    }
}

function getInventoryData($conn,$controlNumber)
{
    $sql = "SELECT * FROM `inventory_table` WHERE inv_control_number = ? LIMIT 1;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../funtions.inc.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $controlNumber);
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

function totalInventoryTable($conn,$controlNumber)
{
    $sql = "SELECT `inv_name`,`inv_weight`,`inv_quantity`,`inv_metric_tons`,`inv_plant_price`,`inv_total_price`,`inv_plant_value`,`inv_total_value` FROM `inventory_table` WHERE `inv_control_number` = '$controlNumber'";
    $result = mysqli_query($conn, $sql);
    
    while ($row = mysqli_fetch_assoc($result)) {
        echo 
        '<tr>
            <td>'.$row['inv_name'].'</td>
            <td>'.$row['inv_weight'].'</td>
            <td>'.$row['inv_quantity'].'</td>
            <td>'.$row['inv_metric_tons'].'</td>
            <td>'.$row['inv_plant_price'].'</td>
            <td>'.$row['inv_total_price'].'</td>
            <td>'.$row['inv_plant_value'].'</td>
            <td>'.$row['inv_total_value'].'</td>
        </tr>';
    }
}


function accountEmployeeSelect($conn)
{
    $sql = "SELECT emp_id, emp_firstname, emp_middlename, emp_lastname FROM `employee_table`";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<option value="'.$row['emp_id'].'" >'.ucfirst($row['emp_lastname']). ', ' . ucfirst($row['emp_firstname']). ' '. ucfirst(substr($row['emp_middlename'],0,1)) .'.'.'</option>';
       
    }
}


function accountManagementTable($conn)
{
    $employee = $_SESSION['empId'];
    $sql = "SELECT `acc_id`, `acc_role`, `acc_username`, `acc_date_creation`, CONCAT(employee_table.emp_lastname, ', ', employee_table.emp_firstname, ' ' , SUBSTR(employee_table.emp_middlename,1,1), '.') as 'acc_emp_name' FROM `admin_account_table` JOIN employee_table ON employee_table.emp_id = acc_emp_id WHERE NOT acc_emp_id = '$employee';";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        echo 
        '<tr>
            <td>'.date('d M Y', strtotime($row['acc_date_creation'])).'</td>
            <td>'.$row['acc_emp_name'].'</td>
            <td>'.$row['acc_username'].'</td>
            <td>'.$row['acc_role'].'</td>
            <td><button type="button" class="btn btn-danger shadow-none" row.id= "'.$row['acc_id'].'" id= "btnAccLock" data-bs-toggle="modal" data-bs-target="#lockAccountModal"><i class="fas fa-lock" data-bs-toggle="tooltip" data-bs-placement="top" title="Lock Account"></i></button> <button type="button" class="btn btn-dark shadow-none" data-bs-toggle="modal" data-bs-target="#unlockAccountModal" row.id= "'.$row['acc_id'].'" id= "btnAccUnlock"><i class="fas fa-lock-open" data-bs-toggle="tooltip" data-bs-placement="top" title="Unlock Account"></i></button></td>
        </tr>';
    }
}


function getSessionEmployeeData($conn, $empId)
{
    $sql = "SELECT * FROM `employee_table` WHERE emp_id = ? LIMIT 1;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../funtions.inc.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "i", $empId);
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

function getDeliveryDate($conn)
{
    $sql = "SELECT delivery_table.delivery_sales_invoice, delivery_table.delivery_date, delivery_table.delivery_status, CONCAT(customer_table.customer_last_name, ', ', customer_table.customer_first_name, ' ', substr(customer_table.customer_last_name,1,1),'.') AS 'customer_name' FROM `sales_table` JOIN delivery_table ON delivery_table.delivery_sales_invoice = sales_invoice JOIN customer_table ON customer_table.customer_id = sales_customer_id ORDER BY delivery_date ASC;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../funtions.inc.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($resultData)) {
        $rows[] = $row;
    }
    return $rows;
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}