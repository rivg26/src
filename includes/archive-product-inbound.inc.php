<?php


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    session_start();
    require_once 'dbh.inc.php';
    if (isset($_POST['productInboundArchive'])) {
        $rowId = $_POST['rowId'];

        $sql = "SELECT pin_quantity FROM product_inbound_table WHERE pin_id = '$rowId' ";
        $result = mysqli_query($conn, $sql);
        $quantity = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $quantity = $row['pin_quantity'];
        }
        if (!($quantity <= 0)) {
            echo json_encode([
                "status" => false
            ]);
        } else {

            $sql2 = "SELECT * FROM product_inbound_table WHERE pin_id = '$rowId'";
            $result2 = mysqli_query($conn, $sql2);
            while ($row2 = mysqli_fetch_assoc($result2)) {
                $sql3 = "INSERT INTO archive_product_inbound_table(a_pin_invoice, a_pin_product_id, a_pin_pun, a_pin_encoder_id, a_pin_date, a_pin_quantity, a_pin_total_quantity, a_pin_total_plant_price, a_pin_total_final_price, a_pin_metric_tons, a_pin_product_option, a_pin_remarks) VALUES ('$row2[pin_invoice]', '$row2[pin_product_id]', '$row2[pin_pun]', '$row2[pin_encoder_id]', '$row2[pin_date]', '$row2[pin_quantity]', '$row2[pin_total_quantity]', '$row2[pin_total_plant_price]', '$row2[pin_total_final_price]', '$row2[pin_metric_tons]', '$row2[pin_product_option]' , '$row2[pin_remarks]')";
                mysqli_query($conn, $sql3);
            }
            $sql4 = "DELETE FROM product_inbound_table WHERE pin_id = '$rowId'";
            mysqli_query($conn, $sql4);
            mysqli_close($conn);
            echo json_encode([
                "status" => true
            ]);
        }
    }


    if (isset($_POST['productInboundRestore'])) {
        $deleteRowId = $_POST['deleteRowId'];
        $sql5 = "SELECT * FROM archive_product_inbound_table WHERE a_pin_id = '$deleteRowId' ";
        $result3 = mysqli_query($conn, $sql5);
        while ($row3 = mysqli_fetch_assoc($result3)) {
            $sql6 = "INSERT INTO product_inbound_table(pin_invoice, pin_product_id, pin_pun, pin_encoder_id, pin_date, pin_quantity, pin_total_quantity, pin_total_plant_price, pin_total_final_price, pin_metric_tons, pin_product_option, pin_remarks) VALUES ('$row3[a_pin_invoice]', '$row3[a_pin_product_id]', '$row3[a_pin_pun]', '$row3[a_pin_encoder_id]', '$row3[a_pin_date]', '$row3[a_pin_quantity]', '$row3[a_pin_total_quantity]', '$row3[a_pin_total_plant_price]', '$row3[a_pin_total_final_price]', '$row3[a_pin_metric_tons]', '$row3[a_pin_product_option]' , '$row3[a_pin_remarks]')";
            mysqli_query($conn, $sql6);
        }

        $sql7 = "DELETE FROM archive_product_inbound_table WHERE a_pin_id = '$deleteRowId'";
        mysqli_query($conn, $sql7);
        mysqli_close($conn);
        echo json_encode([
            "status" => true
        ]);
    }

    if(isset($_POST['productInboundDelete'])){
        $deleteRowIds = $_POST['deleteRowId'];
        $sql8 = "DELETE FROM archive_product_inbound_table WHERE a_pin_id = '$deleteRowIds'";
        mysqli_query($conn, $sql8);
        mysqli_close($conn);
        echo json_encode([
            "status" => true
        ]);
    }
}
