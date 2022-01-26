<?php


if($_SERVER['REQUEST_METHOD'] == "POST"){
    session_start();
    require_once 'dbh.inc.php';
    if(isset($_POST['punTableArchive'])){
        $rowId = $_POST['rowId'];
        $sql = "SELECT * FROM product_inbound_table WHERE pin_pun = '$rowId' ";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0){
            mysqli_close($conn);
            echo json_encode([
                "status" => false
            ]);
        }
        else{
            $sql2 = "SELECT * FROM price_table WHERE price_pun = '$rowId' ";
            $result2 = mysqli_query($conn, $sql2);
            while($row = mysqli_fetch_assoc($result2)){
                $sqlInsert = "INSERT INTO archive_price_table ( a_price_pun , a_price_emp_id , a_price_product_id , a_price_date , a_price_plant_price , a_price_final_price , a_price_type ) VALUES ('$row[price_pun]', '$row[price_emp_id]', '$row[price_product_id]', '$row[price_date]', '$row[price_plant_price]', '$row[price_final_price]', '$row[price_type]' );";
               mysqli_query($conn, $sqlInsert);
            }

            $sql3 = "DELETE FROM price_table WHERE price_pun = '$rowId'";
            mysqli_query($conn,$sql3);
            mysqli_close($conn);
            echo json_encode([
                "status" => true,
                
            ]);
        }



        
    }

    if(isset($_POST['punTableRestore'])){
        $archiveDeleteRow = $_POST['archiveDeleteRow'];

        $sql4 = "SELECT * FROM archive_price_table WHERE a_price_pun = '$archiveDeleteRow' ";
        $result4 = mysqli_query($conn,$sql4);
        while($row4 = mysqli_fetch_assoc($result4)){
            $sqlInsert2 = "INSERT INTO price_table ( price_pun , price_emp_id , price_product_id , price_date , price_plant_price , price_final_price , price_type ) VALUES ('$row4[a_price_pun]', '$row4[a_price_emp_id]', '$row4[a_price_product_id]', '$row4[a_price_date]', '$row4[a_price_plant_price]', '$row4[a_price_final_price]', '$row4[a_price_type]' );";
            mysqli_query($conn, $sqlInsert2);
        }

        $sql5 = "DELETE FROM archive_price_table WHERE a_price_pun = '$archiveDeleteRow'";
        mysqli_query($conn,$sql5);
        mysqli_close($conn);
        echo json_encode([
            "status" => true,
        ]);
    }
    
    if(isset($_POST['punTableDelete'])){
        $archiveDeleteRow = $_POST['archiveDeleteRow'];
        $sql6 = "DELETE FROM archive_price_table WHERE a_price_pun = '$archiveDeleteRow'";
        mysqli_query($conn,$sql6);
        mysqli_close($conn);
        echo json_encode([
            "status" => true
        ]);
    }
}