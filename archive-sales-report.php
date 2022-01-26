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
            <h5 class="display-4 mb-5 mt-3">Sales Report Archive</h5>
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
                        <option value="<?= $today ?>" >Today</option>
                        <option value="<?= $yesterday ?>">Yesterday</option>
                    </optgroup>
                </select>
            </div>


            <table id="archiveSalesTable" class="tableDesign table table-striped table-hover align-middle shadow-none">
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
                    <?php

                    $sql = "SELECT `a_sales_id`,`a_sales_purchase_date` ,`a_sales_invoice`, CONCAT( customer_table.customer_first_name, ' ', customer_table.customer_middle_name, ' ', customer_table.customer_last_name) AS 'customer_name', `a_sales_total_quantity`, `a_sales_total_price`,`a_sales_status`, CONCAT(employee_table.emp_lastname, ', ', employee_table.emp_firstname, ' ' , SUBSTR(employee_table.emp_middlename,1,1), '.') as 'emp_name' FROM `archive_sales_table` JOIN customer_table ON customer_table.customer_id =`a_sales_customer_id` JOIN employee_table ON employee_table.emp_id = `a_sales_encoder_id`;";
                    $result = mysqli_query($conn, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($row['a_sales_status'] == "pending") {
                            $color = "alert alert-warning";
                            $icon = '<i class="fas fa-pencil-alt"></i>';
                        } elseif ($row['a_sales_status'] == "paid") {
                            $color = "alert alert-success";
                            $icon = '<i class="fas fa-donate"></i>';
                        } else {
                            $color = "alert alert-danger";
                            $icon = '<i class="fas fa-ban"></i>';
                        }
                        echo
                        '<tr>
                            <td>' . date('d M Y', strtotime($row['a_sales_purchase_date'])) . '</td>
                            <td>' . $row['a_sales_invoice'] . '</td>
                            <td>' . $row['customer_name'] . '</td>
                            <td>' . number_format($row['a_sales_total_quantity'], 2) . '</td>
                            <td>' . number_format($row['a_sales_total_price'], 2) . '</td>
                            <td> <div class = "' . $color . ' my-3">' . $icon . ' ' . $row['a_sales_status'] . '</div></td>
                            <td class="remarksWrapper">' . $row['emp_name'] . '</td>
                            <td><button type="button" class="btn btn-warning shadow-none" row.id = "' . $row['a_sales_invoice'] . '" data-bs-toggle="modal" data-bs-target="#salesTableRestoreModal" id ="btnRestoreSales"  ><i class="fas fa-undo" data-bs-toggle="tooltip" data-bs-placement="top" title="Restore"></i></button> <button type="button" class="btn btn-danger shadow-none" row.id = "' . $row['a_sales_invoice'] . '" data-bs-toggle="modal" data-bs-target="#salesTableDeleteModal"  id ="btnDeleteSales" ><i class="fas fa-trash-alt" data-bs-toggle="tooltip" data-bs-placement="top" title="Permanently Delete"></i></button></td>
                        </tr>';
                    }
                    ?>
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
                <i class="fas fa-check-circle"></i> <span id="successText">Archive Success!</span> 
            </div>
            <input type="hidden" id="archiveRowId">

            <div class="modal fade" id="salesTableRestoreModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confirmation <i class="fas fa-question-circle link-warning"></i></h5>
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to restore?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn shadow-none rippleButton ripple" id="salesTableRestore">Restore</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="salesTableDeleteModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confirmation <i class="fas fa-question-circle link-warning"></i></h5>
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        Are you sure you want to delete? <em>It will be permanently deleted</em>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn shadow-none rippleButton ripple" id="salesTableDelete">Delete</button>
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
        $(document).on('click', '#salesTableRestore', function () {  
            let datastring = {
                "salesTableRestore": $('#salesTableRestore').val(),
                "archiveRowId": $('#archiveRowId').val()
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
                        $('#salesTableRestoreModal').modal('hide');
                        $('#errorBox').hide();
                        $('#successText').text('Restore Complete...');
                        $('#successBox').show();
                        window.setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    } else {
                        $('#salesTableRestoreModal').modal('hide');
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

        $(document).on('click','#salesTableDelete', function () {  
            let datastring = {
                "salesTableDelete": $('#salesTableDelete').val(),
                "archiveRowId": $('#archiveRowId').val()
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
                        $('#salesTableDeleteModal').modal('hide');
                        $('#errorBox').hide();
                        $('#successText').text('Successfully Deleted...');
                        $('#successBox').show();
                        window.setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    } else {
                        $('#salesTableDeleteModal').modal('hide');
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

        $(document).on('click', '#btnRestoreSales', function(){
            let rowId = $(this).attr('row.id');
            $('#archiveRowId').val(rowId);
            
        });
        $(document).on('click', '#btnDeleteSales', function(){
            let rowId = $(this).attr('row.id');
            $('#archiveRowId').val(rowId);
            
        });

        var table = $('#archiveSalesTable').DataTable({
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
        });


        $("#archiveSalesTable_filter.dataTables_filter").append($("#categoryFilter"));

        var categoryIndex = 0;
        $("#archiveSalesTable th").each(function(i) {
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



        table.draw();
    });
</script>