<?php require_once 'head.php' ?>
<?php
$data = getDeliveryDate($conn);
$stocks = getPriceSaleData($conn);
$quantity = getStocks($conn);

// ($a == 0 ? "Clear" :($a == 1 ? "Processing" :($a == 2 ? "Marked for delete" : "")));

date_default_timezone_set('Asia/Hong_Kong');
$list = array();
$month = date('m');
$year = date('Y');

for ($d = 1; $d <= 31; $d++) {
    $time = mktime(12, 0, 0, $month, $d, $year);
    if (date('m', $time) == $month)
        $list[] = date('Y-m-d', $time);
}
$rows = [];
for ($x = 0; $x < count($list); $x++) {
    $sql = "SELECT SUM(`sales_total_price`) AS 'total_sales' FROM `sales_table` WHERE `sales_status` = 'paid' AND `sales_purchase_date` = '$list[$x]';";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        array_push($rows, $row['total_sales']);
    }
}

$pushAllQuantity = [];
for ($y = 1; $y <= 8; $y++) {
    $sqlUniq = "SELECT SUM(item_table.item_quantity) AS 'total_quant' FROM `sales_table` JOIN item_table ON item_table.item_invoice = sales_invoice WHERE sales_status = 'paid' AND `sales_purchase_date` > date_sub(now(), interval 1 week) AND item_table.item_product_id = '$y';";
    $resultA = mysqli_query($conn, $sqlUniq);
    while ($rowa = mysqli_fetch_assoc($resultA)) {
        array_push($pushAllQuantity, $rowa['total_quant']);
    }
}

$overAll = [];
$sql5 = "SELECT SUM(`sales_total_price`) AS 'total_one_week' FROM `sales_table` WHERE `sales_status` = 'paid' AND `sales_purchase_date` > date_sub(now(), interval 1 week)";
$result5 = mysqli_query($conn, $sql5);
while ($row5 = mysqli_fetch_assoc($result5)) {
    array_push($overAll, $row5['total_one_week']);
}
$sql6 = "SELECT SUM(`sales_total_price`) - (SELECT SUM(`sales_total_price`) AS 'total_one_week' FROM `sales_table` WHERE `sales_status` = 'paid' AND `sales_purchase_date` > date_sub(now(), interval 1 week)) AS 'total_two_week' FROM `sales_table` WHERE `sales_status` = 'paid' AND `sales_purchase_date` > date_sub(now(), interval 2 week);";
$result6 = mysqli_query($conn, $sql6);
while ($row6 = mysqli_fetch_assoc($result6)) {
    array_push($overAll, $row6['total_two_week']);
}
$sql7 = "SELECT SUM(`sales_total_price`) - (SELECT SUM(`sales_total_price`) AS 'total_one_week' FROM `sales_table` WHERE `sales_status` = 'paid' AND `sales_purchase_date` > date_sub(now(), interval 2 week)) AS 'total_three_week' FROM `sales_table` WHERE `sales_status` = 'paid' AND `sales_purchase_date` > date_sub(now(), interval 3 week);";
$result7 = mysqli_query($conn, $sql7);
while ($row7 = mysqli_fetch_assoc($result7)) {
    array_push($overAll, $row7['total_three_week']);
}
$sql8 = "SELECT SUM(`sales_total_price`) - (SELECT SUM(`sales_total_price`) AS 'total_one_week' FROM `sales_table` WHERE `sales_status` = 'paid' AND `sales_purchase_date` > date_sub(now(), interval 3 week)) AS 'total_four_week' FROM `sales_table` WHERE `sales_status` = 'paid' AND `sales_purchase_date` > date_sub(now(), interval 4 week);";
$result8 = mysqli_query($conn, $sql8);
while ($row8 = mysqli_fetch_assoc($result8)) {
    array_push($overAll, $row8['total_four_week']);
}
$sql9 = "SELECT SUM(`sales_total_price`) AS 'today' FROM `sales_table` WHERE `sales_status` = 'paid' AND DATE(`sales_purchase_date`) = CURDATE();";
$result9 = mysqli_query($conn, $sql9);
while ($row9 = mysqli_fetch_assoc($result9)) {
    array_push($overAll, $row9['today']);
}
$sql10 = "SELECT SUM(`sales_total_price`) AS 'yesterday' FROM `sales_table` WHERE `sales_status` = 'paid' AND DATE(`sales_purchase_date`) = CURDATE()-1;";
$result10 = mysqli_query($conn, $sql10);
while ($row10 = mysqli_fetch_assoc($result10)) {
    array_push($overAll, $row10['yesterday']);
}

?>

<script>
    var myArray = [];

    function getDeliveryData() {
        var wholeData = <?= json_encode($data) ?>;

        for (let x = 0; x < wholeData.length; x++) {
            var colored = "";
            if (wholeData[x]['delivery_status'] == "to be delivered") {
                colored = '#e06f1f';
            } else if (wholeData[x]['delivery_status'] == "delivered") {
                colored = '#00b300';
            } else {
                colored = '#b30000';
            }
            var hello = {
                title: wholeData[x]['customer_name'] + '---' + wholeData[x]['delivery_status'],
                url: 'delivery-report.php',
                start: wholeData[x]['delivery_date'],
                color: colored
            }
            myArray.push(hello)

        }
    }
    getDeliveryData();
    draw();


    function draw() {
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');




            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    start: 'Paredes Petron Calendar',
                    left: 'prev next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                googleCalendarApiKey: 'AIzaSyCxID7BTR6z_WWwgNs7pFLfJca89adkRfo',
                eventSources: [{
                    googleCalendarId: 'gregorioron26@gmail.com',

                }],
                events: myArray,
                windowResize: function(arg) {
                    // alert('The calendar has adjusted to a window resize. Current view: ' + arg.view.type);
                }
            });
            calendar.render();
        });
    }
</script>
<style>
    @font-face {
        font-family: Dashboard;
        src: url('assets/fonts/Dashboard-Regular.ttf');
    }

    .weightFont {
        font-family: Dashboard;
        color: #fff;
    }

    p {
        color: #fff;
    }

    .moneySize {
        color: #00ff00;
    }


    @media only screen and (max-width: 1920px) {
        .img-size {
            width: 7rem;
            height: 5.6rem;
        }

        .quantitySize {
            font-size: 1.5rem;
            font-weight: 500;
        }

    }

    @media only screen and (max-width: 1400px) {
        p {
            font-size: 0.5rem;
        }

        .img-size {
            width: 5rem;
            height: 6rem;
        }

        .moneySize {
            font-size: 0.6rem;
        }

        .typeSize {
            font-size: 0.8rem;
        }
    }
</style>

<div class="container-fluid" style="position: relative; ">
    <div class="row">
        <div class="col-md-6 d-flex flex-column align-items-center justify-content-center ">
            <div class="container">
                <button class="btn btn-dark shadow-none mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" data-toggle="tooltip" title="Legend" data-bs-placement="right">
                    <i class="fas fa-info-circle"></i>
                </button>
                <div class="collapse" id="collapseExample">
                    <div class="card card-body bg-body mb-3">
                        <div class="text-center mt-2">
                            <h6>Total Quantity Legend</h6>
                        </div>
                        <div class="row my-3">
                            <div class="col-md-4"><span class="alert alert-info w-25 rounded"></span> &nbsp; Sufficient Supply</div>
                            <div class="col-md-4"><span class="alert alert-warning w-25 rounded"></span> &nbsp; Low Supply</div>
                            <div class="col-md-4"><span class="alert alert-danger w-25 rounded"></span> &nbsp; Zero Supply</div>
                        </div>
                        <div class="text-center mt-5">
                            <h6>Calendar Legend</h6>
                        </div>
                        <div class="row my-2">
                            <div class="col-md-4"><span class="alert w-25 rounded" style="background-color: #e06f1f;"></span> &nbsp; To be Delivered</div>
                            <div class="col-md-4"><span class="alert w-25 rounded" style="background-color: #00b300;"></span> &nbsp; Delivered</div>
                            <div class="col-md-4"><span class="alert w-25 rounded" style="background-color: #b30000;"></span> &nbsp; Cancelled</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container px-4 ">
                <div class="row gx-5 mb-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4 rounded-start" style="background-color: #2a2a72;">
                                <div class="row mt-3 mb-2">
                                    <img src="assets/logo/gas-icon.png" class="img-size" alt="">
                                </div>
                                <div class="row text-center">
                                    <p class="weightFont">50KG</p>
                                </div>
                            </div>
                            <div class="col-md-8 rounded-end" style="background-color: #2a2a72;opacity: 90%;">
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <p class="mb-1 typeSize">REFILL</p>
                                        <p class="moneySize">₱ <?= $stocks[1]['price_final_price'] ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1 typeSize">NEW</p>
                                        <p class="moneySize">₱ <?= $stocks[0]['price_final_price'] ?></p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="text-center">
                                        <p class="mb-1 typeSize">Total Quantity</p>
                                        <p class="mb-0 <?= ((int)$quantity[0]['total_quantity'] == 0 ? "link-danger" : ((int)$quantity[0]['total_quantity'] <= 5 ? "link-warning" : "link-info")) ?> quantitySize"><?= $quantity[0]['total_quantity'] ?> <?= (int)$quantity[0]['total_quantity'] <= 5 ? '<i class="fas fa-caret-down"></i>' : '<i class="fas fa-caret-up"></i>' ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4 rounded-start" style="background-color: #1b2f33;">
                                <div class="row mt-3 mb-2">
                                    <img src="assets/logo/gas-icon.png" class="img-size" alt="">
                                </div>
                                <div class="row text-center">
                                    <p class="weightFont">22KG</p>
                                </div>
                            </div>
                            <div class="col-md-8 rounded-end" style="background-color: #1b2f33;opacity: 90%;">
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <p class="mb-1 typeSize">REFILL</p>
                                        <p class="moneySize">₱ <?= $stocks[3]['price_final_price'] ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1 typeSize">NEW</p>
                                        <p class="moneySize">₱ <?= $stocks[2]['price_final_price'] ?></p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="text-center">
                                        <p class="mb-1 typeSize">Total Quantity</p>
                                        <p class="mb-0  <?= ((int)$quantity[1]['total_quantity'] == 0 ? "link-danger" : ((int)$quantity[1]['total_quantity'] <= 5 ? "link-warning" : "link-info")) ?>  quantitySize"><?= $quantity[1]['total_quantity'] ?> <?= (int)$quantity[1]['total_quantity'] <= 5 ? '<i class="fas fa-caret-down"></i>' : '<i class="fas fa-caret-up"></i>' ?> </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row gx-5 mb-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4 rounded-start" style="background-color: #28231c;">
                                <div class="row mt-3 mb-2">
                                    <img src="assets/logo/gas-icon.png" class="img-size" alt="">
                                </div>
                                <div class="row text-center">
                                    <p class="weightFont">11KG CVT</p>
                                </div>
                            </div>
                            <div class="col-md-8 rounded-end" style="background-color: #28231c;opacity: 90%;">
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <p class="mb-1 typeSize">REFILL</p>
                                        <p class="moneySize">₱ <?= $stocks[5]['price_final_price'] ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1 typeSize">NEW</p>
                                        <p class="moneySize">₱ <?= $stocks[4]['price_final_price'] ?></p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="text-center">
                                        <p class="mb-1 typeSize">Total Quantity</p>
                                        <p class="mb-0 <?= ((int)$quantity[2]['total_quantity'] == 0 ? "link-danger" : ((int)$quantity[2]['total_quantity'] <= 5 ? "link-warning" : "link-info")) ?>  quantitySize"><?= $quantity[2]['total_quantity'] ?> <?= (int)$quantity[2]['total_quantity'] <= 5 ? '<i class="fas fa-caret-down"></i>' : '<i class="fas fa-caret-up"></i>' ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4 rounded-start" style="background-color: #2d232e;">
                                <div class="row mt-3 mb-2">
                                    <img src="assets/logo/gas-icon.png" class="img-size" alt="">
                                </div>
                                <div class="row text-center">
                                    <p class="weightFont">11KG PVT</p>
                                </div>
                            </div>
                            <div class="col-md-8 rounded-end" style="background-color: #2d232e;opacity: 90%;">
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <p class="mb-1 typeSize">REFILL</p>
                                        <p class="moneySize">₱ <?= $stocks[7]['price_final_price'] ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1 typeSize">NEW</p>
                                        <p class="moneySize">₱ <?= $stocks[6]['price_final_price'] ?></p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="text-center">
                                        <p class="mb-1 typeSize">Total Quantity</p>
                                        <p class="mb-0 <?= ((int)$quantity[3]['total_quantity'] == 0 ? "link-danger" : ((int)$quantity[3]['total_quantity'] <= 5 ? "link-warning" : "link-info")) ?>  quantitySize"><?= $quantity[3]['total_quantity'] ?> <?= (int)$quantity[3]['total_quantity'] <= 5 ? '<i class="fas fa-caret-down"></i>' : '<i class="fas fa-caret-up"></i>' ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row gx-5 mb-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4 rounded-start" style="background-color: #3f292b;">
                                <div class="row mt-3 mb-2">
                                    <img src="assets/logo/gas-icon.png" class="img-size" alt="">
                                </div>
                                <div class="row text-center">
                                    <p class="weightFont">7KG CVT</p>
                                </div>
                            </div>
                            <div class="col-md-8 rounded-end" style="background-color: #3f292b;opacity: 90%;">
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <p class="mb-1 typeSize">REFILL</p>
                                        <p class="moneySize">₱ <?= $stocks[9]['price_final_price'] ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1 typeSize">NEW</p>
                                        <p class="moneySize">₱ <?= $stocks[8]['price_final_price'] ?></p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="text-center">
                                        <p class="mb-1 typeSize">Total Quantity</p>
                                        <p class="mb-0 <?= ((int)$quantity[4]['total_quantity'] == 0 ? "link-danger" : ((int)$quantity[4]['total_quantity'] <= 5 ? "link-warning" : "link-info")) ?>  quantitySize"><?= $quantity[4]['total_quantity'] ?> <?= (int)$quantity[4]['total_quantity'] <= 5 ? '<i class="fas fa-caret-down"></i>' : '<i class="fas fa-caret-up"></i>' ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4 rounded-start" style="background-color: #03012c;">
                                <div class="row mt-3 mb-2">
                                    <img src="assets/logo/gas-icon.png" class="img-size" alt="">
                                </div>
                                <div class="row text-center">
                                    <p class="weightFont">7KG PVT</p>
                                </div>
                            </div>
                            <div class="col-md-8 rounded-end" style="background-color: #03012c;opacity: 90%;">
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <p class="mb-1 typeSize">REFILL</p>
                                        <p class="moneySize">₱ <?= $stocks[11]['price_final_price'] ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1 typeSize">NEW</p>
                                        <p class="moneySize">₱ <?= $stocks[10]['price_final_price'] ?></p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="text-center">
                                        <p class="mb-1 typeSize">Total Quantity</p>
                                        <p class="mb-0 <?= ((int)$quantity[5]['total_quantity'] == 0 ? "link-danger" : ((int)$quantity[5]['total_quantity'] <= 5 ? "link-warning" : "link-info")) ?>  quantitySize"><?= $quantity[5]['total_quantity'] ?> <?= (int)$quantity[5]['total_quantity'] <= 5 ? '<i class="fas fa-caret-down"></i>' : '<i class="fas fa-caret-up"></i>' ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row gx-5">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4 rounded-start" style="background-color: #1f0318;">
                                <div class="row mt-3 mb-2">
                                    <img src="assets/logo/gas-icon.png" class="img-size" alt="">
                                </div>
                                <div class="row text-center">
                                    <p class="weightFont">2.7KG CVT</p>
                                </div>
                            </div>
                            <div class="col-md-8 rounded-end" style="background-color: #1f0318;opacity: 90%;">
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <p class="mb-1 typeSize">REFILL</p>
                                        <p class="moneySize">₱ <?= $stocks[13]['price_final_price'] ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1 typeSize">NEW</p>
                                        <p class="moneySize">₱ <?= $stocks[12]['price_final_price'] ?></p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="text-center">
                                        <p class="mb-1 typeSize">Total Quantity</p>
                                        <p class="mb-0 <?= ((int)$quantity[6]['total_quantity'] == 0 ? "link-danger" : ((int)$quantity[6]['total_quantity'] <= 5 ? "link-warning" : "link-info")) ?>  quantitySize"><?= $quantity[6]['total_quantity'] ?> <?= (int)$quantity[6]['total_quantity'] <= 5 ? '<i class="fas fa-caret-down"></i>' : '<i class="fas fa-caret-up"></i>' ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4 rounded-start" style="background-color: #20063b;">
                                <div class="row mt-3 mb-2">
                                    <img src="assets/logo/gas-icon.png" class="img-size" alt="">
                                </div>
                                <div class="row text-center">
                                    <p class="weightFont">2.7KG PVT</p>
                                </div>
                            </div>
                            <div class="col-md-8 rounded-end" style="background-color: #20063b;opacity: 90%;">
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <p class="mb-1 typeSize">REFILL</p>
                                        <p class="moneySize">₱ <?= $stocks[15]['price_final_price'] ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1 typeSize">NEW</p>
                                        <p class="moneySize">₱ <?= $stocks[14]['price_final_price'] ?></p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="text-center">
                                        <p class="mb-1 typeSize">Total Quantity</p>
                                        <p class="mb-0 <?= ((int)$quantity[7]['total_quantity'] == 0 ? "link-danger" : ((int)$quantity[7]['total_quantity'] <= 5 ? "link-warning" : "link-info")) ?> quantitySize"><?= $quantity[7]['total_quantity'] ?> <?= (int)$quantity[7]['total_quantity'] <= 5 ? '<i class="fas fa-caret-down"></i>' : '<i class="fas fa-caret-up"></i>' ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 ">
            <div class="row  shadow-sm p-3 mb-5 bg-body rounded ">
                <div class="display-6 mb-3 text-center">Paredes Petron Calendar Schedule</div>
                <div class="col-md-12">
                    <div id='calendar'></div>
                </div>

            </div>
        </div>
    </div>
    <div class="row d-flex flex-row align-items-center justify-content-center">
        <div class="col-md-10 shadow-sm p-3 mb-5 bg-body rounded mt-5 h-50">
            <canvas id="myChart" width="200"></canvas>
        </div>

    </div>
    <div class="row flex-row align-items-center justify-content-center">
        <div class="col-md-5 shadow-sm p-3 mb-5 bg-body rounded me-1">
            <div class="text-center mb-3">
                <h6 class="display-6">Fast Moving Items</h6>
            </div>
            <canvas id="myChart2"></canvas>
        </div>
        <div class="col-md-5 shadow-sm p-3 mb-5 bg-body rounded ms-1">
            <div class="text-center mb-3">
                <h6 class="display-6">Sales Comparison</h6>
            </div>
            <canvas id="myChart3"></canvas>
        </div>
    </div>
    <?php require_once 'loader.php' ?>
</div>

<?php require_once 'footer.php' ?>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.js" integrity="sha256-nCXGH8kkPFozCBx4meHWhA5OCqXhhBzoBVpHfM/HmwM=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js" integrity="sha256-Y26AMvaIfrZ1EQU49pf6H4QzVTrOI8m9wQYKkftBt4s=" crossorigin="anonymous"></script>
<script>


    var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    var date = new Date();
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($list) ?>,
            datasets: [{
                label: 'Sales in the month of ' + months[date.getMonth()] + ' ' + date.getFullYear(),
                data: <?= json_encode($rows) ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const ctx2 = document.getElementById('myChart2').getContext('2d');
    const myChart2 = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: [
                '50 KILOS',
                '22 KILOS',
                '11 KILOS Compact-Valve Type ',
                '11 KILOS POL Type ',
                '7 KILOS Compact-Valve Type ',
                '7 KILOS POL Type ',
                '2.7 KILOS Compact-Valve Type ',
                '2.7 KILOS POL Type '
            ],
            datasets: [{
                label: 'My First Dataset',
                data: <?= json_encode($pushAllQuantity) ?>,
                backgroundColor: [
                    '#0e0e25',
                    '#1b1c4b',
                    '#363a7d',
                    '#5e64ba',
                    '#3a9efd',
                    '#81c1fe',
                    '#ffaa00',
                    '#ffdd99',
                ],
                hoverOffset: 4
            }],

        },
        options: {
            plugins: {
                legend: {
                    labels: {
                        // This more specific font property overrides the global property
                        font: {
                            size: 11,
                            lineHeight: 50
                        }
                    },
                    align: 'start',
                    position: 'left',


                }
            }
        }
    });
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
                    '#8c61ff',
                    '#44c2fd',
                    '#6592fd',
                    '#5f59f7',
                    '#343090',
                    '#232060'

                ]
            }]
        }
    });
</script>