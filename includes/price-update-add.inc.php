<?php


if($_SERVER['REQUEST_METHOD'] == "POST"){
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
    session_start();
    if(isset($_POST['btnPriceUpdateAdd'])){
        $pun = $_POST['punId'];
        for($x = 0; $x < 16; $x++){
           $pp[$x] = validateData($_POST['pp'][$x]);
           $fp[$x] = validateData($_POST['fp'][$x]);
           $product[$x] = validateData($_POST['product'][$x]);
           $pt[$x] = validateData($_POST['pt'][$x]);

           insertPrices($conn,$pun,$_SESSION['empId'],$product[$x],date('Y-m-d H:i:s'),$pp[$x],$fp[$x],$pt[$x]);
        }
        echo json_encode([
            'status' => true
        ]);
    }
    if(isset($_POST['btnPriceUpdateUpdate'])){
        $pun = $_POST['punId'];
        for($x = 0; $x < 16; $x++){
           $pp[$x] = validateData($_POST['pp'][$x]);
           $fp[$x] = validateData($_POST['fp'][$x]);
           $product[$x] = validateData($_POST['product'][$x]);
           $pt[$x] = validateData($_POST['pt'][$x]);
           updatePrices($conn,$pun,$_SESSION['empId'],$product[$x],$pp[$x],$fp[$x],$pt[$x]);
        }
        echo json_encode([
            'status' => true
        ]);
    }
    
}


function insertPrices($conn,$pun,$encoderId,$product,$date,$pp,$fp,$pt)
{
    $sql = "INSERT INTO price_table (price_pun , price_emp_id , price_product_id, price_date ,price_plant_price , price_final_price , price_type) VALUES (?,?,?,?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../price-update-add.inc.php?error=stmtfailed");
       exit();
    }
    
    mysqli_stmt_bind_param($stmt, "siisdds",$pun,$encoderId,$product,$date,$pp,$fp,$pt);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function updatePrices($conn,$pun,$encoderId,$product,$pp,$fp,$pt)
{
    $sql = "UPDATE price_table SET price_emp_id = ? , price_product_id = ?,price_plant_price = ?, price_final_price = ?, price_type = ? WHERE price_pun = ? && price_product_id = ? && price_type = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../price-update-add.inc.php?error=stmtfailed");
       exit();
    }
    
    mysqli_stmt_bind_param($stmt, "iiddssis",$encoderId,$product,$pp,$fp,$pt,$pun,$product,$pt);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}




?>