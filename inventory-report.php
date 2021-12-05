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
                    <div class="col-md-7 col-sm-12 col-xs-12">
                        <div class="row">
                            <label for="fromDate" class="col-sm-1 col-form-label">From</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" id="fromDate">
                                <div class="invalid-feedback" id="fromDateFeedback">Please Select Date..</div>
                            </div>
                            <label for="endDate" class="col-sm-1 col-form-label">To</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" id='endDate'>
                                <div class="invalid-feedback" id="endDateFeedback">Please Select Date..</div>
                            </div>

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
                        <th>Date</th>
                        <th>Product</th>
                        <th>Total Product Inbound</th>
                        <th>Total Product Outbound</th>
                        <th>Total Remaining Quantity</th>
                        <th>Total Metric Tons</th>
                        <th>Plant Price Cost</th>
                        <th>Total Price Cost</th>
                        <th>Plant Price Inv Value</th>
                        <th>Total Price Inv Value</th>
                        <th>Total Vat</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="font-size: 0.85rem;">
                        <td>20 Nov 2021</td>
                        <td>Petron LPG Gasul 50kg Pol-Valve</td>
                        <td>11</td>
                        <td>2</td>
                        <td>9</td>
                        <td>3.2</td>
                        <td>800</td>
                        <td>900</td>
                        <td>20000</td>
                        <td>30000</td>
                        <td>2000</td>
                    </tr>
                    <tr style="font-size: 0.85rem;">
                        <td>20 Nov 2021</td>
                        <td>Petron LPG Gasul 50kg Pol-Valve</td>
                        <td>11</td>
                        <td>2</td>
                        <td>9</td>
                        <td>3.2</td>
                        <td>800</td>
                        <td>900</td>
                        <td>20000</td>
                        <td>30000</td>
                        <td>2000</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Date</th>
                        <th>Product</th>
                        <th>Total Product Inbound</th>
                        <th>Total Product Outbound</th>
                        <th>Total Remaining Quantity</th>
                        <th>Total Metric Tons</th>
                        <th>Plant Price Cost</th>
                        <th>Total Price Cost</th>
                        <th>Plant Price Inv Value</th>
                        <th>Total Price Inv Value</th>
                        <th>Total Vat</th>
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
        $('#inventoryTable').DataTable({
            "searching": true,
            "bPaginate": true,
            "lengthChange": true,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": true,
            lengthMenu: [5, 10, 25, 50, 100, 200],
            "columnDefs": [{
                    targets: [2, 3, 4, 5, 6, 7, 8, 9, 10],
                    className: "text-end"
                },
                {
                    targets: [1],
                    className: "text-justify"
                },
                {
                    targets: [0, 10],
                    className: "text-center"
                },
                {
                    orderable: false,
                    targets: []
                }
            ],
            dom: 'Bfrtip',
            buttons: [{
                    text: '<i class="fas fa-folder-plus"></i>',
                    titleAttr: 'NEW INBOUND',
                    className: 'btn-warning me-3 shadow-none rounded',
                    action: function(e, dt, node, config) {
                        $("#loader").fadeIn(function() {
                            $("#loader").fadeOut();
                            window.location.href = "product-inbound-add.php";
                        });

                    },

                },
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