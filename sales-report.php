<?php require_once 'head.php' ?>
<?php

date_default_timezone_set('Asia/Hong_Kong');
$today = date('d M Y', strtotime(date('Y-m-d')));
$yesterday = date('d M Y', strtotime("-1 days"));
$year = date("Y");


?>
<div class="row" style="position: relative;">
    <div class="shadow p-3 mb-5 bg-body rounded">
        <div class="text-center">
            <h5 class="display-4 mb-5 mt-3">Sales Report</h5>
        </div>

        <div class="table-responsive my-5 p-5">
            <div class="category-filter">
                <select id="categoryFilter" class="form-control shadow-none">
                    <option value="">Show All</option>
                    <optgroup label="Sort by Months">
                        <option value='<?php echo "Jan " . $year  ?>'>January</option>
                        <option value='<?php echo "Feb " . $year  ?>'>February</option>
                        <option value='<?php echo "Mar " . $year  ?>'>March</option>
                        <option value='<?php echo "Apr " . $year  ?>'>April</option>
                        <option value='<?php echo "May " . $year  ?>'>May</option>
                        <option value='<?php echo "Jun " . $year  ?>'>June</option>
                        <option value='<?php echo "Jul " . $year  ?>'>July</option>
                        <option value='<?php echo "Aug " . $year  ?>'>August</option>
                        <option value='<?php echo "Sep " . $year  ?>'>September</option>
                        <option value='<?php echo "Oct " . $year  ?>'>October</option>
                        <option value='<?php echo "Nov " . $year  ?>'>November</option>
                        <option value='<?php echo "Dec " . $year  ?>'>December</option>
                    </optgroup>
                    <optgroup label="Sort by Day">
                        <option value="<?= $today ?>" selected>Today</option>
                        <option value="<?= $yesterday ?>">Yesterday</option>
                    </optgroup>
                </select>
            </div>
            <div class="category-filter2">
                <select id="categoryFilter2" class="form-control shadow-none">
                    <optgroup label="Sort by Payment Status">
                        <option value="">Show All</option>
                        <option value='pending'>Pending</option>
                        <option value='paid'>Paid</option>
                        <option value='cancelled'>Cancelled</option>
                    </optgroup>
                </select>
            </div>

            <table id="salesTable" class="tableDesign table table-striped table-hover align-middle shadow-none">
                <thead class="align-middle">
                    <tr>
                        <th>Purchase Date</th>
                        <th>Sales Invoice</th>
                        <th>Customer Name</th>
                        <th>Total Quantity</th>
                        <th>Total Amount</th>
                        <th>Payment Status</th>
                        <th>Encoder Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?= salesTable($conn); ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Purchase Date</th>
                        <th>Sales Invoice</th>
                        <th>Customer Name</th>
                        <th>Total Quantity</th>
                        <th>Total Amount</th>
                        <th>Payment Status</th>
                        <th>Encoder Name</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
            <div class="text-center alert alert-danger my-4" style="display: none;" id="errorBox">
                <i class="fas fa-times-circle"></i> Unable to delete this data row...
            </div>
            <div class="text-center alert alert-success my-4" style="display: none;" id="successBox">
                <i class="fas fa-check-circle"></i> Archive Success!
            </div>
            <input type="hidden" id="rowId">
            <div class="modal fade" id="salesTableArchiveModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confirmation <i class="fas fa-question-circle link-warning"></i></h5>
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to archive?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn shadow-none rippleButton ripple" id="salesTableArchive">Archive</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php require_once 'loader.php' ?>
    </div>
</div>
<?php require_once 'footer.php' ?>
<script>
    $(document).ready(function() {
        $(document).on('click', '#btnArchiveSales', function(){
            let rowId = $(this).attr('row.id');
            $('#rowId').val(rowId);
            
        });
        $(document).on('click', '#salesTableArchive', function(){
            let datastring = {
                "salesTableArchive": $('#salesTableArchive').val(),
                "rowId": $('#rowId').val()
            };
            $.ajax({
                url: 'includes/archive-sales-report.inc.php',
                type: 'POST',
                data: datastring,
                dataType: 'json',
                error: function(error) {
                    console.log(error);
                },
                success: function(data) {
                    if (data.status) {
                        $('#salesTableArchiveModal').modal('hide');
                        $('#errorBox').hide();
                        $('#successBox').show();
                        window.setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    } else {
                        $('#salesTableArchiveModal').modal('hide');
                        $('#errorBox').show();
                        $('#successBox').hide();
                        window.setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                        
                    }
                },
                fail: function(xhr, textStatus, errorThrown) {
                    alert(errorThrown);
                    alert(xhr);
                    alert(textStatus);
                },
                catch: function(error) {
                    alert(error);
                }

            });
        });
        $(document).on('click', '#btnViewSales', function() {
            let rowId = $(this).attr('row.id');
            $("#loader").fadeIn();
            window.setTimeout(function() {
                $("#loader").fadeOut();
                window.location.href = "sales-view.php?salesInvoice=" + rowId;
            }, 2000);
        });

        $('#salesTable').DataTable({
            "searching": true,
            "bPaginate": true,
            "lengthChange": true,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": true,
            lengthMenu: [5, 10, 25, 50, 100, 200],
            "columnDefs": [{
                    targets: [3, 4],
                    className: "text-end"
                },
                {
                    targets: [1, 2, 6],
                    className: "text-justify"
                },
                {
                    targets: [0, 7, 5],
                    className: "text-center"
                },
                {
                    orderable: false,
                    targets: [7]
                }
            ],
            dom: 'B<"searchBar">frtip',
            buttons: [{
                    text: '<i class="fas fa-folder-plus"></i>',
                    titleAttr: 'NEW INBOUND',
                    className: 'btn-warning me-3 shadow-none rounded',
                    action: function(e, dt, node, config) {
                        $("#loader").fadeIn(function() {
                            $("#loader").fadeOut();
                            window.location.href = "sales-add.php";
                        });

                    },

                },
                {
                    text: '<i class="fas fa-file-excel"></i>',
                    extend: 'excel',
                    title: 'Sales Report_' + moment().format('MMMM Do YYYY, h:mm:ss a'),
                    className: 'btn-success me-3 shadow-none rounded',
                    titleAttr: 'EXCEL',
                    exportOptions: {
                        columns: 'th:not(:last-child):visible',
                    }
                },
                {
                    text: '<i class="fas fa-file-pdf"></i>',
                    extend: 'pdf',
                    titleAttr: 'PDF',
                    orientation: 'portrait',
                    pageSize: 'LEGAL',
                    className: 'btn-danger me-3 shadow-none rounded',
                    filename: 'Sales Report_' + moment().format('MMMM Do YYYY, h:mm:ss a'),
                    header: 'Sales Report',
                    messageTop: 'Date: ' + moment().format('MMMM Do YYYY, h:mm:ss a'),
                    title: 'Sales Report',
                    exportOptions: {
                        columns: 'th:not(:last-child):visible',
                    }

                },
                {
                    text: '<i class="fas fa-print"></i>',
                    extend: 'print',
                    titleAttr: 'PRINT',
                    className: 'btn-info me-3 shadow-none rounded',
                    title: 'Sales Report_' + moment().format('MMMM Do YYYY, h:mm:ss a'),
                    exportOptions: {
                        columns: 'th:not(:last-child):visible',
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
        var table = $('#salesTable').DataTable();
        $("#salesTable_filter.dataTables_filter").append($("#categoryFilter"));

        var categoryIndex = 0;
        $("#salesTable th").each(function(i) {
            if ($($(this)).html() == "Purchase Date") {
                categoryIndex = i;
                return false;
            }
        });

        //Use the built in datatables API to filter the existing rows by the Category column
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var selectedItem = $('#categoryFilter').val()
                var category = data[categoryIndex];
                if (selectedItem === "" || category.includes(selectedItem)) {
                    return true;
                }
                return false;
            }
        );

        //Set the change event for the Category Filter dropdown to redraw the datatable each time
        //a user selects a new filter.
        $("#categoryFilter").change(function(e) {
            table.draw();
        });



        $("#salesTable_filter.dataTables_filter").append($("#categoryFilter2"));

        var categoryIndex2 = 0;
        $("#salesTable th").each(function(i) {
            if ($($(this)).html() == "Payment Status") {
                categoryIndex2 = i;
                return false;
            }
        });

        //Use the built in datatables API to filter the existing rows by the Category column
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var selectedItem = $('#categoryFilter2').val()
                var category = data[categoryIndex2];
                if (selectedItem === "" || category.includes(selectedItem)) {
                    return true;
                }
                return false;
            }
        );

        //Set the change event for the Category Filter dropdown to redraw the datatable each time
        //a user selects a new filter.
        $("#categoryFilter2").change(function(e) {
            table.draw();
        });

        table.draw();
    });
</script>