<?php require_once 'head.php' ?>
<div class="row" style="position: relative;">
    <div class="shadow p-3 mb-5 bg-body rounded">
        <div class="text-center">
            <h5 class="display-4 mb-5 mt-3">Inventory Report</h5>
        </div>
        <div class="">
            <div class="px-5">
                <em>Please Select Date...</em>
                <div class="row mt-3">
                    <div class="col-md-7 col-sm-12 col-xs-12 ">
                        <!-- <div class="row ">
                            <label for="fromDate" class="col-sm-1 col-form-label">From</label>
                            <div class="col-sm-5">
                                <input type="date" class="form-control shadow-none" id="fromDate">
                                <div class="invalid-feedback" id="fromDateFeedback">Please Select Valid Date..</div>
                            </div>
                            <label for="endDate" class="col-sm-1 col-form-label">To</label>
                            <div class="col-sm-5">
                                <input type="date" class="form-control shadow-none" id='endDate'>
                                <div class="invalid-feedback" id="endDateFeedback">Please Select Valid Date..</div>
                            </div>
                        </div> -->
                        <div class="row">
                            <label for="type" class="col-sm-1 col-form-label">Type</label>
                            <div class="col-sm-3">
                                <select class="form-select shadow-none" id="type">
                                    <option value="" selected disabled>---Select Type---</option>
                                    <option value="NEW">NEW</option>
                                    <option value="REFILL">REFILL</option>
                                </select>
                                <div class="invalid-feedback" id="typeFeedback">Please Select Type..</div>
                            </div>
                            <!-- <label for="type" class="col-sm-1 col-form-label">Calculate</label>
                            <div class="col-sm-3">
                                <select class="form-select shadow-none" id="calculate">
                                    <option value="" selected disabled>---Select Calculate---</option>
                                    <option value="remaining">Remaining Quantity</option>
                                    <option value="total">Total Quantity</option>
                                </select>
                                <div class="invalid-feedback" id="calculateFeedback">Please Select Calculate..</div>
                            </div> -->
                            <div class="col-sm-2">
                                <button class="btn shadow-none rippleButton ripple" id="btnInventorySubmit">Submit</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive mb-5 mt-2 p-5">


            <table id="inventoryTable" class="tableDesign table table-striped table-hover align-middle shadow-none" style="font-size: 0.8rem;">
                <thead class="align-middle">
                    <tr>
                        <th>Product</th>
                        <th>Weight</th>
                        <th>Remaining Quantity</th>
                        <th>Total Metric Tons</th>
                        <th>Plant Price Cost</th>
                        <th>Total Price Cost</th>
                        <th>Plant Price Inv Value</th>
                        <th>Total Price Inv Value</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- <tr style="font-size: 0.9rem;">
                        <td>Petron LPG Gasul 50kg Pol-Valve</td>
                        <td>11</td>
                        <td>9</td>
                        <td>3.2</td>
                        <td>800</td>
                        <td>900</td>
                        <td>20000</td>
                        <td>30000</td>
                    </tr> -->
                </tbody>
                <tfoot>
                    <tr>
                        <th>Product</th>
                        <th>Weight</th>
                        <th>Remaining Quantity</th>
                        <th>Total Metric Tons</th>
                        <th>Plant Price Cost</th>
                        <th>Total Price Cost</th>
                        <th>Plant Price Inv Value</th>
                        <th>Total Price Inv Value</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <?php require_once 'loader.php' ?>
</div>
<?php require_once 'footer.php' ?>
<script>
    $(document).ready(function() {

        $(document).on('change', '#fromDate', function() {
            var x = new Date($('#fromDate').val());
            if ($('#fromDate').val() === "" || !$('#fromDate').val()) {
                $('#fromDate').removeClass('is-valid').addClass('is-invalid');
            } else if (x.getFullYear() < 2020) {
                $('#fromDate').removeClass('is-valid').addClass('is-invalid');
            } else {
                $('#fromDate').removeClass('is-invalid').addClass('is-valid');
            }
        });

        $(document).on('change', '#endDate', function() {
            var x = new Date($('#endDate').val());
            if ($('#endDate').val() === "" || !$('#endDate').val()) {
                $('#endDate').removeClass('is-valid').addClass('is-invalid');
            } else if (x.getFullYear() < 2020) {
                $('#endDate').removeClass('is-valid').addClass('is-invalid');
            } else {
                $('#endDate').removeClass('is-invalid').addClass('is-valid');
            }
        });
        $(document).on('change', '#type', function() {

            if ($(this).val() === "" || !$(this).val()) {
                $(this).removeClass('is-valid').addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid').addClass('is-valid');
            }
        });
        $(document).on('change', '#calculate', function() {

            if ($(this).val() === "" || !$(this).val()) {
                $(this).removeClass('is-valid').addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid').addClass('is-valid');
            }
        });

        function getProductInbound() {
            let datastring = {
                "btnInventorySubmit": "btn",
                // "fromDate": $('#fromDate').val(),
                // "endDate": $('#endDate').val()
            }
            console.log(datastring);

            $.ajax({
                url: 'includes/inventory-report.inc.php',
                type: 'POST',
                data: datastring,
                dataType: 'json',
                error: function(error) {
                    console.log(error);
                },
                success: function(data) {
                    if (data == "") {
                        alert('Invalid Date');
                    } else {
                        getPrice(data);
                    }
                }

            });
        }

        function getPrice(firstResult) {
            var firstResult = firstResult;
            let datastring = {
                "btnInventoryNext": "btn",
                "type": $('#type').val()
            }
            console.log(datastring);

            $.ajax({
                url: 'includes/inventory-report.inc.php',
                type: 'POST',
                data: datastring,
                dataType: 'json',
                error: function(error) {
                    console.log(error);
                },
                success: function(data) {

                    // alert(firstResult[0]['product_name'] + ' ' + data[0]['price_plant_price']);

                    var arrayRow = [];
                    for (let x = 0; x < firstResult.length; x++) {

                        let getInboundProduct = firstResult[x]['product_name'];
                        let getUpdateProduct = data[x]['product_name'];

                        if (getInboundProduct == getUpdateProduct) {
                            //For getProduct
                            let remainingQuantity = firstResult[x]['rem_quantity'];
                            let totalQuantity = firstResult[x]['total_quantity'];
                            let weight = firstResult[x]['product_weight'];
                            //For getProduct
                            let plantPrice = data[x]['price_plant_price'];
                            let finalPrice = data[x]['price_final_price'];

                            //////////////////////TOTAL QUANTITY///////////////////////////////////
                            //For Metric Tons
                            let metricTonsRQ = (parseFloat(remainingQuantity) * parseFloat(weight) / 1000);
                            let plantInvValueRQ = parseFloat(remainingQuantity) * parseFloat(plantPrice);
                            let totalInvValueRQ = parseFloat(remainingQuantity) * parseFloat(finalPrice);
                            //////////////////////REMAINING QUANTITY///////////////////////////////////
                            var rowData = '<tr style="font-size: 1rem;" ><td>' + getInboundProduct + '</td><td>' + numberWithCommas(weight) + '</td><td>' + numberWithCommas(remainingQuantity) + '</td><td>' + numberWithCommas(parseFloat(metricTonsRQ).toFixed(3)) + '</td><td>' + numberWithCommas(plantPrice) + '</td><td>' + numberWithCommas(finalPrice) + '</td><td>' + numberWithCommas(parseFloat(plantInvValueRQ).toFixed(2)) + '</td><td>' + numberWithCommas(parseFloat(totalInvValueRQ).toFixed(2)) + '</td></tr>';


                            // if ($('#calculate').val() == "total") {
                            //     //////////////////////TOTAL QUANTITY///////////////////////////////////
                            //     //For Metric Tons
                            //     let metricTonsTQ = (parseFloat(totalQuantity) * parseFloat(weight) / 1000);
                            //     let plantInvValueTQ = parseFloat(totalQuantity) * parseFloat(plantPrice);
                            //     let totalInvValueTQ = parseFloat(totalQuantity) * parseFloat(finalPrice);
                            //     //////////////////////TOTAL QUANTITY///////////////////////////////////
                            //     var rowData = '<tr style="font-size: 1rem;" ><td>' + getInboundProduct + '</td><td>' + numberWithCommas(weight) + '</td><td>' + numberWithCommas(remainingQuantity) + '</td><td>' + numberWithCommas(totalQuantity) + '</td><td>' + numberWithCommas(parseFloat(metricTonsTQ).toFixed(3)) + '</td><td>' + numberWithCommas(plantPrice) + '</td><td>' + numberWithCommas(finalPrice) + '</td><td>' + numberWithCommas(parseFloat(plantInvValueTQ).toFixed(2)) + '</td><td>' + numberWithCommas(parseFloat(totalInvValueTQ).toFixed(2)) + '</td></tr>';
                            // } else {
                            //     //////////////////////TOTAL QUANTITY///////////////////////////////////
                            //     //For Metric Tons
                            //     let metricTonsRQ = (parseFloat(remainingQuantity) * parseFloat(weight) / 1000);
                            //     let plantInvValueRQ = parseFloat(remainingQuantity) * parseFloat(plantPrice);
                            //     let totalInvValueRQ = parseFloat(remainingQuantity) * parseFloat(finalPrice);
                            //     //////////////////////REMAINING QUANTITY///////////////////////////////////
                            //     var rowData = '<tr style="font-size: 1rem;" ><td>' + getInboundProduct + '</td><td>' + numberWithCommas(weight) + '</td><td>' + numberWithCommas(remainingQuantity) + '</td><td>' + numberWithCommas(totalQuantity) + '</td><td>' + numberWithCommas(parseFloat(metricTonsRQ).toFixed(3)) + '</td><td>' + numberWithCommas(plantPrice) + '</td><td>' + numberWithCommas(finalPrice) + '</td><td>' + numberWithCommas(parseFloat(plantInvValueRQ).toFixed(2)) + '</td><td>' + numberWithCommas(parseFloat(totalInvValueRQ).toFixed(2)) + '</td></tr>';

                            // }

                        }
                        arrayRow.push(rowData);
                    }

                    for (let b = 0; b < arrayRow.length; b++) {
                        inventoryTable.rows.add($(arrayRow[b])).order([1, 'desc']).draw();
                    }

                }

            });

        }

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
        $(document).on('click', '#btnInventorySubmit', function() {
            // $('input').not('#inventoryTable_filter input').each(function() {
            //     if ($(this).val() === "" || !$(this).val()) {
            //         $(this).removeClass('is-valid').addClass('is-invalid');
            //     }
            // });
            $('select').each(function() {
                if ($(this).val() === "" || !$(this).val()) {
                    $(this).removeClass('is-valid').addClass('is-invalid');
                }
            });

            if ($('.is-invalid')[0]) {
                alert('error')
            } else {
                inventoryTable.clear().draw();
                getProductInbound()
            }



        });

        var inventoryTable = $('#inventoryTable').DataTable({
            "searching": true,
            "bPaginate": true,
            "lengthChange": true,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": true,
            lengthMenu: [8, 10, 25, 50, 100, 200],
            "columnDefs": [{
                    targets: [1, 2, 3, 4, 5, 6, 7],
                    className: "text-end"
                },
                {
                    targets: [0],
                    className: "text-justify"
                },
                // {
                //     targets: [],
                //     className: "text-center"
                // },
                // {
                //     orderable: false,
                //     targets: []
                // }
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    text: '<i class="fas fa-file-excel"></i>',
                    extend: 'excel',
                    title: 'Inventory Report_' + moment().format('MMMM Do YYYY, h:mm:ss a'),
                    className: 'btn-success me-3 shadow-none rounded',
                    titleAttr: 'EXCEL',
                    exportOptions: {
                        columns: ':visible',
                    }
                },
                {
                    text: '<i class="fas fa-file-pdf"></i>',
                    extend: 'pdf',
                    titleAttr: 'PDF',
                    orientation: 'portrait',
                    pageSize: 'LEGAL',
                    className: 'btn-danger me-3 shadow-none rounded',
                    filename: 'Inventory Report_' + moment().format('MMMM Do YYYY, h:mm:ss a'),
                    header: 'Inventory Report',
                    messageTop: 'Date: ' + moment().format('MMMM Do YYYY, h:mm:ss a'),
                    title: 'Inventory  Report',
                    exportOptions: {
                        columns: ':visible',
                    }

                },
                {
                    text: '<i class="fas fa-print"></i>',
                    extend: 'print',
                    titleAttr: 'PRINT',
                    className: 'btn-info me-3 shadow-none rounded',
                    title: 'Inventory Report_' + moment().format('MMMM Do YYYY, h:mm:ss a'),
                    exportOptions: {
                        columns: ':visible',
                    }

                },
                {
                    extend: 'colvis',
                    className: 'btn-dark me-3 shadow-none rounded-3',
                    text: '<i class="fas fa-columns"></i>',
                    titleAttr: 'COLUMNS VISIBLITY'
                },
                {
                    extend: 'pageLength',
                    className: 'btn-dark shadow-none rounded-3',
                    text: '<i class="fas fa-ruler-vertical"></i>',
                    titleAttr: 'PAGE LENGTH'
                }
            ]
        });



    });
</script>