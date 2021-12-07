<?php require_once 'head.php' ?>
<div class="row p-3" style="position: relative;">
    <div class="shadow p-3 mb-5 bg-body rounded">
        <div class="text-center">
            <h5 class="display-4 mb-5 mt-3">Product Inbound Report</h5>
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

            <table id="productInboundTable" class="tableDesign table table-striped table-hover align-middle shadow-none">
                <thead class="align-middle">
                    <tr>
                        <th>Date Inbound</th>
                        <th>Invoice Number</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Metric Tons</th>
                        <th>Plant Price</th>
                        <th>Final Price</th>
                        <th>Encoder Name</th>
                        <th>Remarks</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>20 Nov 2021</td>
                        <td>PTR-123</td>
                        <td>Petron 50kg</td>
                        <td>11</td>
                        <td>3.2</td>
                        <td>900.00</td>
                        <td>1000.00</td>
                        <td class="remarksWrapper">Ron Ivin V. Gregorio</td>
                        <td class="remarksWrapper">Wala lang</td>
                        <td><button type="button" class="btn btn-warning shadow-none mb-2"><i class="fas fa-edit"></i></button> <button type="button" class="btn btn-danger shadow-none"><i class="fas fa-trash-alt"></i></button></td>
                    </tr>
                    <tr>
                        <td>19 Dec 2021</td>
                        <td>PTR-123</td>
                        <td>Petron 50kg</td>
                        <td>10</td>
                        <td>3.2</td>
                        <td>900.00</td>
                        <td>1000.00</td>
                        <td class="remarksWrapper">Ron Ivin V. Gregorio</td>
                        <td class="remarksWrapper"> lorem </td>
                        <td><button type="button" class="btn btn-warning shadow-none mb-2"><i class="fas fa-edit"></i></button> <button type="button" class="btn btn-danger shadow-none"><i class="fas fa-trash-alt"></i></button></td>
                    </tr>


                </tbody>
                <tfoot>
                    <tr>
                        <th>Date Inbound</th>
                        <th>Invoice Number</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Metric Tons</th>
                        <th>Plant Price</th>
                        <th>Final Price</th>
                        <th>Encoder Name</th>
                        <th>Remarks</th>
                        <th>Actions</th>
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

        

        // var today = new Date().toLocaleString();
        var today = new Date();
        // today.toLocaleDateString("en-US", options);
        var options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        $('#productInboundTable').DataTable({
            "searching": true,
            "bPaginate": true,
            "lengthChange": true,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": true,
            lengthMenu: [5, 10, 25, 50, 100, 200],
            "columnDefs": [{
                    targets: [3, 4, 5, 6],
                    className: "text-end"
                },
                {
                    targets: [1, 2, 7, 8],
                    className: "text-justify"
                },
                {
                    targets: [0, 9],
                    className: "text-center"
                },
                {
                    orderable: false,
                    targets: [9]
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
                            window.location.href = "product-inbound-add.php";
                        });

                    },

                },
                {
                    text: '<i class="fas fa-file-excel"></i>',
                    extend: 'excel',
                    title: 'Product Inbound Report_' + moment().format('MMMM Do YYYY, h:mm:ss a'),
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
                    filename: 'Product Inbound Report_' + moment().format('MMMM Do YYYY, h:mm:ss a'),
                    header: 'Product Inbound Report',
                    messageTop: 'Date: ' + moment().format('MMMM Do YYYY, h:mm:ss a'),
                    title: 'Product Inbound Report',
                    exportOptions: {
                        columns: 'th:not(:last-child):visible',
                    }

                },
                {
                    text: '<i class="fas fa-print"></i>',
                    extend: 'print',
                    titleAttr: 'PRINT',
                    className: 'btn-info me-3 shadow-none rounded',
                    title: 'Product Inbound Report_' + moment().format('MMMM Do YYYY, h:mm:ss a'),
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
        var table = $('#productInboundTable').DataTable();
        $("#productInboundTable_filter.dataTables_filter").append($("#categoryFilter"));

        var categoryIndex = 0;
        $("#productInboundTable th").each(function(i) {
            if ($($(this)).html() == "Date Inbound") {
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

        table.draw();



        $(document).on('click', '#hel', function() {
            alert('hello');
        });









    });
</script>