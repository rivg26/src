<?php require_once 'head.php' ?>
<?php 
$data = getDeliveryDate($conn); 
$stocks = getPriceSaleData($conn);
$quantity = getStocks($conn);

// ($a == 0 ? "Clear" :($a == 1 ? "Processing" :($a == 2 ? "Marked for delete" : "")));
?>

<script>
    var myArray = [];

    function getDeliveryData() {
        var wholeData = <?= json_encode($data) ?>;

        for (let x = 0; x < wholeData.length; x++) {
            var colored = "";
            if(wholeData[x]['delivery_status'] == "to be delivered"){
                colored = '#e06f1f';
            }
            else if(wholeData[x]['delivery_status'] == "delivered"){
                colored = '#00b300';
            }
            else{
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
                                        <p class="mb-0 <?= ((int)$quantity[0]['total_quantity'] == 0 ? "link-danger" :((int)$quantity[0]['total_quantity'] <= 5 ? "link-warning" : "link-info")) ?> quantitySize"><?= $quantity[0]['total_quantity'] ?> <?= (int)$quantity[0]['total_quantity'] <= 5? '<i class="fas fa-caret-down"></i>': '<i class="fas fa-caret-up"></i>' ?></p>
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
                                        <p class="mb-0  <?= ((int)$quantity[1]['total_quantity'] == 0 ? "link-danger" :((int)$quantity[1]['total_quantity'] <= 5 ? "link-warning" : "link-info")) ?>  quantitySize"><?= $quantity[1]['total_quantity'] ?> <?= (int)$quantity[1]['total_quantity'] <= 5? '<i class="fas fa-caret-down"></i>': '<i class="fas fa-caret-up"></i>' ?> </p>
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
                                        <p class="mb-0 <?= ((int)$quantity[2]['total_quantity'] == 0 ? "link-danger" :((int)$quantity[2]['total_quantity'] <= 5 ? "link-warning" : "link-info")) ?>  quantitySize"><?= $quantity[2]['total_quantity'] ?> <?= (int)$quantity[2]['total_quantity'] <= 5? '<i class="fas fa-caret-down"></i>': '<i class="fas fa-caret-up"></i>' ?></p>
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
                                        <p class="mb-0 <?= ((int)$quantity[3]['total_quantity'] == 0 ? "link-danger" :((int)$quantity[3]['total_quantity'] <= 5 ? "link-warning" : "link-info")) ?>  quantitySize"><?= $quantity[3]['total_quantity'] ?> <?= (int)$quantity[3]['total_quantity'] <= 5? '<i class="fas fa-caret-down"></i>': '<i class="fas fa-caret-up"></i>' ?></p>
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
                                        <p class="mb-0 <?= ((int)$quantity[4]['total_quantity'] == 0 ? "link-danger" :((int)$quantity[4]['total_quantity'] <= 5 ? "link-warning" : "link-info")) ?>  quantitySize"><?= $quantity[4]['total_quantity'] ?> <?= (int)$quantity[4]['total_quantity'] <= 5? '<i class="fas fa-caret-down"></i>': '<i class="fas fa-caret-up"></i>' ?></p>
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
                                        <p class="mb-0 <?= ((int)$quantity[5]['total_quantity'] == 0 ? "link-danger" :((int)$quantity[5]['total_quantity'] <= 5 ? "link-warning" : "link-info")) ?>  quantitySize"><?= $quantity[5]['total_quantity'] ?> <?= (int)$quantity[5]['total_quantity'] <= 5? '<i class="fas fa-caret-down"></i>': '<i class="fas fa-caret-up"></i>' ?></p>
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
                                        <p class="mb-0 <?= ((int)$quantity[6]['total_quantity'] == 0 ? "link-danger" :((int)$quantity[6]['total_quantity'] <= 5 ? "link-warning" : "link-info")) ?>  quantitySize"><?= $quantity[6]['total_quantity'] ?> <?= (int)$quantity[6]['total_quantity'] <= 5? '<i class="fas fa-caret-down"></i>': '<i class="fas fa-caret-up"></i>' ?></p>
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
                                        <p class="mb-0 <?= ((int)$quantity[7]['total_quantity'] == 0 ? "link-danger" :((int)$quantity[7]['total_quantity'] <= 5 ? "link-warning" : "link-info")) ?> quantitySize"><?= $quantity[7]['total_quantity'] ?> <?= (int)$quantity[7]['total_quantity'] <= 5? '<i class="fas fa-caret-down"></i>': '<i class="fas fa-caret-up"></i>' ?></p>
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
    <div class="row">
        
    </div>
    <?php require_once 'loader.php' ?>
</div>
<?php require_once 'footer.php' ?>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.js" integrity="sha256-nCXGH8kkPFozCBx4meHWhA5OCqXhhBzoBVpHfM/HmwM=" crossorigin="anonymous"></script>