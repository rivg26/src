<?php
require_once 'includes/dbh.inc.php';
// date_default_timezone_set('Asia/Hong_Kong');
// $list = array();
// $month = date('m');
// $year = date('Y');

// for ($d = 1; $d <= 31; $d++) {
//   $time = mktime(12, 0, 0, $month, $d, $year);
//   if (date('m', $time) == $month)
//     $list[] = date('Y-m-d', $time);
// }
// $rows = [];
// for ($x = 0; $x < count($list); $x++) {
//   $sql = "SELECT SUM(`sales_total_price`) AS 'total_sales' FROM `sales_table` WHERE `sales_status` = 'paid' AND `sales_purchase_date` = '$list[$x]';";
//   $result = mysqli_query($conn, $sql);

//   while ($row = mysqli_fetch_assoc($result)) {
//     array_push($rows, $row['total_sales']);
//   }
// }
// $pushAllQuantity = [];
// for ($y = 1; $y <= 8; $y++) {
//     $sqlUniq = "SELECT SUM(item_table.item_quantity) AS 'total_quant' FROM `sales_table` JOIN item_table ON item_table.item_invoice = sales_invoice WHERE sales_status = 'paid' AND `sales_purchase_date` > date_sub(now(), interval 1 week) AND item_table.item_product_id = '$y';";
//     $resultA = mysqli_query($conn, $sqlUniq);
//     while($rowa = mysqli_fetch_assoc($resultA)){
//         array_push($pushAllQuantity, $rowa['total_quant']);
//     }

// }
$overAll = [];
$sql5 = "SELECT SUM(`sales_total_price`) AS 'total_one_week' FROM `sales_table` WHERE `sales_status` = 'paid' AND `sales_purchase_date` > date_sub(now(), interval 1 week)";
$result5 = mysqli_query($conn, $sql5);
while($row5 = mysqli_fetch_assoc($result5)){
  array_push($overAll,$row5['total_one_week']);
}
$sql6 = "SELECT SUM(`sales_total_price`) - (SELECT SUM(`sales_total_price`) AS 'total_one_week' FROM `sales_table` WHERE `sales_status` = 'paid' AND `sales_purchase_date` > date_sub(now(), interval 1 week)) AS 'total_two_week' FROM `sales_table` WHERE `sales_status` = 'paid' AND `sales_purchase_date` > date_sub(now(), interval 2 week);";
$result6 = mysqli_query($conn, $sql6);
while($row6 = mysqli_fetch_assoc($result6)){
  array_push($overAll,$row6['total_two_week']);
}
$sql7 = "SELECT SUM(`sales_total_price`) - (SELECT SUM(`sales_total_price`) AS 'total_one_week' FROM `sales_table` WHERE `sales_status` = 'paid' AND `sales_purchase_date` > date_sub(now(), interval 2 week)) AS 'total_three_week' FROM `sales_table` WHERE `sales_status` = 'paid' AND `sales_purchase_date` > date_sub(now(), interval 3 week);";
$result7 = mysqli_query($conn, $sql7);
while($row7 = mysqli_fetch_assoc($result7)){
  array_push($overAll,$row7['total_three_week']);
}
$sql8 = "SELECT SUM(`sales_total_price`) - (SELECT SUM(`sales_total_price`) AS 'total_one_week' FROM `sales_table` WHERE `sales_status` = 'paid' AND `sales_purchase_date` > date_sub(now(), interval 3 week)) AS 'total_four_week' FROM `sales_table` WHERE `sales_status` = 'paid' AND `sales_purchase_date` > date_sub(now(), interval 4 week);";
$result8 = mysqli_query($conn, $sql8);
while($row8 = mysqli_fetch_assoc($result8)){
  array_push($overAll,$row8['total_four_week']);
}
$sql9 = "SELECT SUM(`sales_total_price`) AS 'today' FROM `sales_table` WHERE `sales_status` = 'paid' AND DATE(`sales_purchase_date`) = CURDATE();";
$result9 = mysqli_query($conn, $sql9);
while($row9 = mysqli_fetch_assoc($result9)){
  array_push($overAll,$row9['today']);
}
$sql10 = "SELECT SUM(`sales_total_price`) AS 'yesterday' FROM `sales_table` WHERE `sales_status` = 'paid' AND DATE(`sales_purchase_date`) = CURDATE()-1;";
$result10 = mysqli_query($conn, $sql10);
while($row10 = mysqli_fetch_assoc($result10)){
  array_push($overAll,$row10['yesterday']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>Document</title>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <canvas id="myChart3" width="800" height="800"></canvas>
      </div>
    </div>
  </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js" integrity="sha256-Y26AMvaIfrZ1EQU49pf6H4QzVTrOI8m9wQYKkftBt4s=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<!-- <canvas id="myChart" width="400" height="400"></canvas> -->
<script>
  const ctx3 = document.getElementById('myChart3').getContext('2d');
  const myChart3 = new Chart(ctx3, {
    type: 'polarArea',
    data: {
      labels: [
        'This Week',
        'Last 2 Weeks',
        'Last 3 Weeks',
        'Last 4 Weeks',
        'Today',
        'Yesterday'
      ],
      datasets: [{
        label: 'My First Dataset',
        data: <?= json_encode($overAll) ?>,
        backgroundColor: [
          'rgb(202, 168, 245)',
          'rgb(153, 132, 212)',
          'rgb(153, 79, 212)',
          'rgb(89, 46, 131)',
          'rgb(35, 12, 51)',
          'rgb(178, 124, 102)'
          
        ]
      }]
    }
  });
  
</script>

</html>