<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    if (isset($_POST['btnGetCode'])) {

        $number = $_POST['mobileNumber'];
        $otp = rand(100000, 999999);
        $message = "Your OTP Pin: " . $otp . " sent via Petron Paredes LPG";
        $apicode = "ST-RONIV102938_YZMCN";
        $passwd = "l$3ap3176e";
        itexmo($number, $message, $apicode, $passwd);
        date_default_timezone_set("Asia/Hong_Kong");
        $datetime = date("Y-m-d H:i:s");
        // Convert datetime to Unix timestamp
        $timestamp = strtotime($datetime);
        // Subtract time from datetime
        $time = $timestamp + (5 * 60);
        // Date and time after subtraction
        $newDateTime = date("Y-m-d H:i:s", $time);
        $_SESSION['otp'] = $otp;
        $_SESSION['otpExpiration'] = $newDateTime;
        $time = $_SESSION['otpExpiration'];

        echo json_encode([
            'status' => true,
            'phone' => $time
        ]);
    }

    if (isset($_POST['otpCode'])) {
        date_default_timezone_set("Asia/Hong_Kong");
        $datetime = date("Y-m-d H:i:s");

        $otp = (int)$_POST['otpCode'];
        if($_SESSION['otp'] !==  $otp) {
            echo json_encode([
                'status' => false,
                'message' => 'Please input the correct OTP pin..'
            ]);
        }
        else{
            if($_SESSION['otpExpiration'] <=  $datetime){
                echo json_encode([
                    'status' => false,
                    'message' =>  "Code is Expired. Please send new OTP pin.."
                ]);
            }
            else{
                unset($_SESSION['otp']);
                unset( $_SESSION['otpExpiration']);
                unset($_SESSION['otpPhoneNumber']);
                unset($_SESSION['redirect']);
                echo json_encode([
                    'status' => true
                ]);
            }
        }
    }
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
