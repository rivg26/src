<?php


if($_SERVER['REQUEST_METHOD'] == "POST"){
    require_once 'dbh.inc.php';
    if(isset($_POST['salesTableArchive'])){
        $rowId = $_POST['rowId'];
        $sql = "SELECT sales_status FROM sales_table WHERE sales_invoice = '$rowId'";
        $result = mysqli_query($conn,$sql);
        $status = "";
        while($row = mysqli_fetch_assoc($result)){
            $status = $row['sales_status'];
        }
        if($status == "pending"){
            mysqli_close($conn);
            echo json_encode([
                "status" => false
            ]);
        }
        else{
            $sql2 = "SELECT * FROM sales_table WHERE sales_invoice = '$rowId'";
            $result2 = mysqli_query($conn,$sql2);
            while($row2 = mysqli_fetch_assoc($result2)){
                $sql3 = "INSERT INTO archive_sales_table(a_sales_invoice, a_sales_customer_id, a_sales_purchase_date, a_sales_total_quantity, a_sales_total_price, a_sales_status, a_sales_encoder_id) VALUES ('$row2[sales_invoice]', '$row2[sales_customer_id]', '$row2[sales_purchase_date]', '$row2[sales_total_quantity]', '$row2[sales_total_price]', '$row2[sales_status]', '$row2[sales_encoder_id]')";
                mysqli_query($conn,$sql3);
            }

            $sql4 = "DELETE FROM sales_table WHERE sales_invoice = '$rowId' ";
            mysqli_query($conn,$sql4);
            mysqli_close($conn);
            echo json_encode([
                "status" => true
            ]);
        }
        
    }

    if(isset($_POST['salesTableRestore'])){
        $archiveRowId = $_POST['archiveRowId'];
        $sql5 = "SELECT * FROM archive_sales_table WHERE a_sales_invoice = '$archiveRowId'";
        $result3 = mysqli_query($conn,$sql5);
        while($row3 = mysqli_fetch_assoc($result3)){
            $sql6 = "INSERT INTO sales_table(sales_invoice, sales_customer_id, sales_purchase_date, sales_total_quantity, sales_total_price, sales_status, sales_encoder_id) VALUES ('$row3[a_sales_invoice]', '$row3[a_sales_customer_id]', '$row3[a_sales_purchase_date]', '$row3[a_sales_total_quantity]', '$row3[a_sales_total_price]', '$row3[a_sales_status]', '$row3[a_sales_encoder_id]')";
            mysqli_query($conn,$sql6);
        }

        $sql7 = "DELETE FROM archive_sales_table WHERE a_sales_invoice = '$archiveRowId'";
        mysqli_query($conn,$sql7);
        mysqli_close($conn);

        echo json_encode([
            "status" => true
        ]);
    }

    if(isset($_POST['salesTableDelete'])){
        $archiveRowIds = $_POST['archiveRowId'];
        $sql8 = "DELETE FROM archive_sales_table WHERE a_sales_invoice = '$archiveRowIds'";
        mysqli_query($conn,$sql8);
        mysqli_close($conn);

        echo json_encode([
            "status" => true
        ]);
    }
}