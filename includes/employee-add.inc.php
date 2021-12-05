<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['empPhoneNumber'])) {
        $success = false;
        $pattern = "/((\+[0-9]{2})|0)[.\- ]?9[0-9]{2}[.\- ]?[0-9]{3}[.\- ]?[0-9]{4}/";
        $number = '0' . $_POST['empPhoneNumber'];
        if (preg_match($pattern, $number)) {
            $success = true;
        } else {
            $success = false;
        }
        echo json_encode([
            'status' => $success
        ]);
    }



}
