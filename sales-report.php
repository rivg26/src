<?php require_once 'head.php' ?>
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
                        <option value='<?php echo "Jan " . date("Y") ?>'>January</option>
                        <option value='<?php echo "Feb " . date("Y") ?>'>February</option>
                        <option value='<?php echo "Mar " . date("Y") ?>'>March</option>
                        <option value='<?php echo "Apr " . date("Y") ?>'>April</option>
                        <option value='<?php echo "May " . date("Y") ?>'>May</option>
                        <option value='<?php echo "Jun " . date("Y") ?>'>June</option>
                        <option value='<?php echo "Jul " . date("Y") ?>'>July</option>
                        <option value='<?php echo "Aug " . date("Y") ?>'>August</option>
                        <option value='<?php echo "Sep " . date("Y") ?>'>September</option>
                        <option value='<?php echo "Oct " . date("Y") ?>'>October</option>
                        <option value='<?php echo "Nov " . date("Y") ?>'>November</option>
                        <option value='<?php echo "Dec " . date("Y") ?>'>December</option>
                    </optgroup>
                    <optgroup label="Sort by Day">
                        <option value="<?= date('d-m-y') ?>">Today</option>
                        <option value="<?= date('d-m-y', strtotime("-1 days")) ?>">Yesterday</option>
                    </optgroup>
                </select>
            </div>
            
            <div class="category-filter2">
                <select id="categoryFilter2" class="form-control shadow-none">
                    <option value="">Show All</option>
                    <option value="Pending">Pending</option>
                    <option value="Paid">Paid</option>
                </select>
            </div>

            <table id="salesTable" class="tableDesign table table-striped table-hover align-middle shadow-none">
                <thead class="align-middle">
                    <tr>
                        <th>Purchase Date</th>
                        <th>Sales Invoice</th>
                        <th>Customer Name</th>
                        <th>Payment Type</th>
                        <th>Total Amount</th>
                        <th>Payment Status</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>21 Nov 2021</td>
                        <td>PTR-23</td>
                        <td>Ron Ivin Gregorio</td>
                        <td>Cash on Delivery</td>
                        <td>1000</td>
                        <td>Pending</td>
                        <td class="remarksWrapper">Palitan Kagad</td>
                        <td><button type="button" class="btn btn-warning shadow-none"><i class="fas fa-edit"></i></button> <button type="button" class="btn btn-danger shadow-none"><i class="fas fa-trash-alt"></i></button></td>
                    </tr>
                    <tr>
                        <td>21 Dec 2021</td>
                        <td>PTR-23</td>
                        <td>Ron Ivin Gregorio</td>
                        <td>Cash on Delivery</td>
                        <td>1000</td>
                        <td>Paid</td>
                        <td class="remarksWrapper">Palitan Kagad</td>
                        <td><button type="button" class="btn btn-warning shadow-none"><i class="fas fa-edit"></i></button> <button type="button" class="btn btn-danger shadow-none"><i class="fas fa-trash-alt"></i></button></td>
                    </tr>
                    <tr>
                        <td>21 Dec 2021</td>
                        <td>PTR-23</td>
                        <td>Ron Ivin Gregorio</td>
                        <td>Cash on Delivery</td>
                        <td>1000</td>
                        <td>Paid</td>
                        <td class="remarksWrapper">Palitan Kagad</td>
                        <td><button type="button" class="btn btn-warning shadow-none"><i class="fas fa-edit"></i></button> <button type="button" class="btn btn-danger shadow-none"><i class="fas fa-trash-alt"></i></button></td>
                    </tr>
                    <tr>
                        <td>21 Nov 2021</td>
                        <td>PTR-23</td>
                        <td>Ron Ivin Gregorio</td>
                        <td>Cash on Delivery</td>
                        <td>1000</td>
                        <td>Paid</td>
                        <td class="remarksWrapper">Palitan Kagad</td>
                        <td><button type="button" class="btn btn-warning shadow-none"><i class="fas fa-edit"></i></button> <button type="button" class="btn btn-danger shadow-none"><i class="fas fa-trash-alt"></i></button></td>
                    </tr>

                </tbody>
                <tfoot>
                    <tr>
                        <th>Purchase Date</th>
                        <th>Sales Invoice</th>
                        <th>Customer Name</th>
                        <th>Payment Type</th>
                        <th>Total Amount</th>
                        <th>Payment Status</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <?php require_once 'loader.php' ?>
    </div>
</div>
<?php require_once 'footer.php' ?>
<script>
    $(document).ready(function() {
        $('#salesTable').DataTable({
            "searching": true,
            "bPaginate": true,
            "lengthChange": true,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": true,
            lengthMenu: [5, 10, 25, 50, 100, 200],
            "columnDefs": [{
                    targets: [4],
                    className: "text-end"
                },
                {
                    targets: [1, 2, 6],
                    className: "text-justify"
                },
                {
                    targets: [0, 3, 5, 7],
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