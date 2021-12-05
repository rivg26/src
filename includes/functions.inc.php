<?php

function validateData($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function CheckKeys($Conn, $RandStr)
{

    $Sql = 'SELECT * FROM inbound_table';
    $Result = mysqli_query($Conn, $Sql);

    while ($Row = mysqli_fetch_assoc($Result)) {
        if ($Row['invoice_number'] === $RandStr) {
            return $KeyExists = true;
            break;
        } else {
            return $KeyExists = false;
        }
    }
}

function GenerateKey($Conn)
{
    $KeyLength = 8;
    $Str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $RandStr = substr(str_shuffle($Str), 0, $KeyLength);

    $CheckKey = CheckKeys($Conn, $RandStr);
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

