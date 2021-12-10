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

function printProductOption($conn)
{
    $sql = 'SELECT * FROM `product_table`';
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<option value="'. $row['product_id']. '">'.$row['product_name'].'</option>';
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