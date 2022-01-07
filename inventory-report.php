<?php require_once 'head.php' ?>
<?php
if (isset($_GET['rowId'])) {
    $data = getInventoryData($conn,$_GET['rowId']);
    $generate = $_GET['rowId'];
    $date = $data['inv_date'];
    $type = $data['inv_type'];
} else {
    date_default_timezone_set('Asia/Hong_Kong');
    $date = date('Y-m-d');
    $generate = GenerateKey($conn, 'SELECT * FROM `inventory_table`;', 'ICN-', 'inv_control_number');
    $type = "";
}
?>
<div class="row" style="position: relative;">
    <div class="shadow p-3 mb-5 bg-body rounded">
        <div class="text-center">
            <h5 class="display-4 mb-5 mt-3">Total Inventory Report</h5>
        </div>
        <div class="d-flex flex-row justify-content-between mb-5">
            <div class="px-5 form-group col-3">
                <label for="invDate" class="form-label">Date</label>
                <input type="date" class="form-control shadow-none" id="invDate" value="<?= $date ?>" readonly required>
            </div>
            <div class="px-5 form-group col-3">
                <label for="invInvoice" class="form-label">Inventory Control Number</label>
                <input type="text" class="form-control shadow-none" id="invInvoice" value="<?= $generate ?>" readonly required>
            </div>
        </div>
        <div class="">

            <div class="px-5">
                <em><?= isset($_GET['rowId'])? "": "Please Select Type..." ?></em>
                <div class="row mt-3">
                    <div class="col-md-10 col-sm-12 col-xs-12 ">
                        <div class="row">
                            <label for="type" class="col-sm-1 col-form-label">Type</label>
                            <div class="col-sm-3">
                                <select class="form-select shadow-none" id="type"  <?= isset($_GET['rowId'])? "disabled": "" ?> >
                                    <option value="" <?= $type == ""? "selected": "" ?> disabled>---Select Type---</option>
                                    <option value="NEW" <?= $type == "NEW"? "selected": "" ?>>NEW</option>
                                    <option value="REFILL" <?= $type == "REFILL"? "selected": "" ?>>REFILL</option>
                                </select>
                                <div class="invalid-feedback" id="typeFeedback">Please Select Type..</div>
                            </div>
                            <div class="col-sm-2">
                                <?= isset($_GET['rowId'])? "": '<button class="btn shadow-none rippleButton ripple" id="btnInventorySubmit">Submit</button>' ?>   
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
                <?= isset($_GET['rowId'])? totalInventoryTable($conn,$_GET['rowId']): "" ?>
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
            <div class="text-center mb-5">
            <?= isset($_GET['rowId'])? "": '<button class="btn btn-lg shadow-none rippleButton ripple" id="btnInventorySave" data-bs-toggle="modal" data-bs-target="#invModal" data-backdrop="false"> Save Table</button>' ?>   
            </div>
            <div class="text-center alert alert-danger my-4" style="display: none;" id="errorBox">
                <i class="fas fa-times-circle"></i> Invalid Process...
            </div>
            <div class="text-center alert alert-success my-4" style="display: none;" id="successBox">
                <i class="fas fa-check-circle"></i> Submission Success!
            </div>
        </div>

        <div class="modal fade" id="invModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirmation <i class="fas fa-question-circle link-warning"></i></h5>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to Save?
                    </div>
                    <div class="modal-footer">
                        <?php

                        if (isset($_GET['rowId'])) {
                            echo '<button type="button" class="btn shadow-none rippleButton ripple" id="invUpdate">Save changes</button>';
                        } else {
                            echo '<button type="button" class="btn shadow-none rippleButton ripple" id="invSave">Save changes</button>';
                        }

                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once 'loader.php' ?>
</div>
<?php require_once 'footer.php' ?>
<script>
    $(document).ready(function() {

        $(document).on('click', '#invSave', function() {
            let tableData = inventoryTable.rows().data().toArray();
            if (tableData.length <= 0) {
                $('#errorBox').show();
                $('#invModal').modal('hide');
            } 
            else if($('#type').val() === "" || !$('#type').val()){
                $('#errorBox').show();
                $('#invModal').modal('hide');
            }
            else {
                let datastring = {
                    "btnInventorySave": "btn",
                    "invDate": $('#invDate').val(),
                    "invInvoice": $('#invInvoice').val(),
                    "type": $('#type').val(),
                    "tableData": tableData
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
                        if (data) {
                            $('#errorBox').hide();
                            $('#btnInventorySave').html("<span class='spinner-border spinner-border-sm ' id = 'loading' role='status' aria-hidden='true'></span>");
                            $('buttons').prop('disabled', true);
                            $('input').prop('disabled', true);
                            $('#invModal').modal('hide'); 
                            $('#successBox').show();
                            window.setTimeout(function() {
                                window.location.href = 'inventory-view-report.php';
                                
                            }, 3000);
                        } else {
                            alert('error') 
                        }
                    }

                });
            }

        });

        $(document).on('change', '#type', function() {

            if ($(this).val() === "" || !$(this).val()) {
                $(this).removeClass('is-valid').addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid').addClass('is-valid');
            }

        });

        function getProductInbound() {
            let datastring = {
                "btnInventorySubmit": "btn"
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

                        }
                        arrayRow.push(rowData);
                    }

                    for (let b = 0; b < arrayRow.length; b++) {
                        inventoryTable.rows.add($(arrayRow[b])).draw();
                    }

                }

            });

        }

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
        $(document).on('click', '#btnInventorySubmit', function() {
            $('select').each(function() {
                if ($(this).val() === "" || !$(this).val()) {
                    $(this).removeClass('is-valid').addClass('is-invalid');
                }
            });

            if ($('.is-invalid')[0]) {
                $('#errorBox').show();
            } else {
                $('#errorBox').hide();
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
            "order": [[ 1, "desc" ]],
            dom: 'Bfrtip',
            buttons: [{
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