<?php


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    session_start();
    require_once 'dbh.inc.php';
    if (isset($_POST['customerArchive'])) {
        $rowId = $_POST['rowId'];
        $sql = "SELECT * FROM sales_table WHERE sales_customer_id = '$rowId'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo json_encode([
                "status" => false
            ]);
        } else {

            $sql2 = "SELECT * FROM customer_table WHERE customer_id = '$rowId' ";
            $result2 = mysqli_query($conn, $sql2);
            while ($row = mysqli_fetch_assoc($result2)) {
                $sql3 = "INSERT INTO archive_customer_table (a_customer_number, a_customer_encoder_id, a_customer_first_name, a_customer_middle_name, a_customer_last_name, a_customer_phone_number,a_customer_date) VALUES ( '$row[customer_number]' , '$row[customer_encoder_id]' , '$row[customer_first_name]' , '$row[customer_middle_name]' , '$row[customer_last_name]' , '$row[customer_phone_number]', '$row[customer_date]')";
                mysqli_query($conn, $sql3);
            }
            $sql4 = "DELETE FROM customer_table WHERE customer_id ='$rowId' ";
            mysqli_query($conn, $sql4);
            mysqli_close($conn);

            echo json_encode([
                "status" => true
            ]);
        }
    }


    if (isset($_POST['customerRestore'])) {
        $deleteRowId = $_POST['deleteRowId'];
        $sql5 = "SELECT * FROM archive_customer_table WHERE a_customer_number = '$deleteRowId'";
        $result3 = mysqli_query($conn, $sql5);
        while ($row2 = mysqli_fetch_assoc($result3)) {
            $sql6 = "INSERT INTO customer_table (customer_number, customer_encoder_id, customer_first_name, customer_middle_name, customer_last_name, customer_phone_number, customer_date) VALUES ( '$row2[a_customer_number]' , '$row2[a_customer_encoder_id]' , '$row2[a_customer_first_name]' , '$row2[a_customer_middle_name]' , '$row2[a_customer_last_name]' , '$row2[a_customer_phone_number]', '$row2[a_customer_date]')";
            mysqli_query($conn, $sql6);
        }

        $sql7 = "DELETE FROM archive_customer_table WHERE a_customer_number ='$deleteRowId' ";
        mysqli_query($conn, $sql7);
        mysqli_close($conn);


        echo json_encode([
            "status" => true
        ]);
    }
    
    if(isset($_POST['customerDelete'])){
        $deleteRowIds = $_POST['deleteRowId'];
        $sql8 = "DELETE FROM archive_customer_table WHERE a_customer_number ='$deleteRowIds' ";
        mysqli_query($conn, $sql8);
        $sql9 = "DELETE FROM customer_address_table WHERE cus_customer_number = '$deleteRowIds'";
        mysqli_query($conn, $sql9);
        mysqli_close($conn);
        echo json_encode([
            "status" => true
        ]);
    }
}
