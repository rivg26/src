<?php

function validateData($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function CheckKeys($conn, $RandStr)
{

    $sql = 'SELECT * FROM employee_table';
    $result = mysqli_query($conn, $sql);

    while ($Row = mysqli_fetch_assoc($result)) {
        if ($Row['emp_number'] === $RandStr) {
            return $KeyExists = true;
            break;
        } else {
            return $KeyExists = false;
        }
    }
}

function GenerateKey($conn)
{
    $KeyLength = 8;
    $Str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $RandStr = substr(str_shuffle($Str), 0, $KeyLength);

    $CheckKey = CheckKeys($conn, $RandStr);
    while ($CheckKey === true) {
        $RandStr = substr(str_shuffle($Str), 0, $KeyLength);
    }
    return 'EMP-' . $RandStr;
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
