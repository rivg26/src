<?php require_once 'head.php' ?>
<?php

date_default_timezone_set('Asia/Hong_Kong');
$today = date('d M Y', strtotime(date('Y-m-d')));
$yesterday = date('d M Y', strtotime("-1 days"));
$year = date("Y");


?>
<div class="row p-3" style="position: relative;">
    <div class="shadow p-3 mb-5 bg-body rounded">
        <div class="text-center">
            <h5 class="display-4 mb-5 mt-3">Product Inbound Report Archive</h5>
        </div>

        <div class="table-responsive my-5 p-5">
            <div class="category-filter">
                <select id="categoryFilter" class="form-control shadow-none">
                    <option value="">Show All</option>
                    <optgroup label="Sort by Months">
                        <option value='<?php echo "Jan " . $year ?>'>January</option>
                        <option value='<?php echo "Feb " . $year ?>'>February</option>
                        <option value='<?php echo "Mar " . $year ?>'>March</option>
                        <option value='<?php echo "Apr " . $year ?>'>April</option>
                        <option value='<?php echo "May " . $year ?>'>May</option>
                        <option value='<?php echo "Jun " . $year ?>'>June</option>
                        <option value='<?php echo "Jul " . $year ?>'>July</option>
                        <option value='<?php echo "Aug " . $year ?>'>August</option>
                        <option value='<?php echo "Sep " . $year ?>'>September</option>
                        <option value='<?php echo "Oct " . $year ?>'>October</option>
                        <option value='<?php echo "Nov " . $year ?>'>November</option>
                        <option value='<?php echo "Dec " . $year ?>'>December</option>
                    </optgroup>
                    <optgroup label="Sort by Day">
                        <option value="<?php echo $today ?>" >Today</option>
                        <option value="<?php echo $yesterday ?>">Yesterday</option>
                    </optgroup>
                </select>
            </div>

            <table id="archiveProductInboundTable" class="tableDesign table table-striped table-hover align-middle shadow-none">
                <thead class="align-middle">
                    <tr>
                        <th>Date Inbound</th>
                        <th>Invoice Number</th>
                        <th>PU Number</th>
                        <th>Product Name</th>
                        <th>Total Quantity</th>
                        <th>Metric Tons</th>
                        <th>Plant Price</th>
                        <th>Final Price</th>
                        <th>Encoder Name</th>
                        <th>Remarks</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $sql = "SELECT `a_pin_id`, `a_pin_invoice`, product_table.product_name, a_pin_pun,CONCAT(employee_table.emp_lastname, ', ', employee_table.emp_firstname, ' ' , SUBSTR(employee_table.emp_middlename,1,1), '.') AS a_pin_employee_name, a_pin_date, a_pin_total_quantity, a_pin_total_plant_price, a_pin_total_final_price, a_pin_metric_tons, a_pin_product_option, a_pin_remarks FROM `archive_product_inbound_table` JOIN product_table ON product_table.product_id = a_pin_product_id JOIN employee_table ON employee_table.emp_id = a_pin_encoder_id;";
                    $result = mysqli_query($conn, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo
                        '<tr>
                            <td>' . date('d M Y', strtotime($row['a_pin_date'])) . '</td>
                            <td style= "font-size: 1.1rem">' . $row['a_pin_invoice'] . '</td>
                            <td style= "font-size: 1.1rem">' . $row['a_pin_pun'] . '</td>
                            <td style= "font-size: 1.1rem">' . $row['product_name'] . '</td>
                            <td>' . $row['a_pin_total_quantity'] . '</td>
                            <td>' . number_format($row['a_pin_metric_tons'], 2) . '</td>
                            <td>' . number_format($row['a_pin_total_plant_price'], 2) . '</td>
                            <td>' . number_format($row['a_pin_total_final_price'], 2) . '</td>
                            <td class="remarksWrapper">' . $row['a_pin_employee_name'] . '</td>
                            <td class="remarksWrapper">' . $row['a_pin_remarks'] . '</td>
                            <td><button type="button" class="btn btn-warning shadow-none mb-2" row.id="' . $row['a_pin_id'] . '" id = "btnProductInboundRestore" data-bs-toggle="modal" data-bs-target="#productInboundTableRestoreModal" ><i class="fas fa-undo" data-bs-toggle="tooltip" data-bs-placement="top" title="Archive"></i></button> <button type="button" class="btn btn-danger shadow-none" data-bs-toggle="modal" data-bs-target="#productInboundTableDeleteModal" id = "btnProductInboundDelete" row.id="' . $row['a_pin_id'] . '" ><i class="fas fa-trash-alt" data-bs-toggle="tooltip" data-bs-placement="top" title="Archive"></i></button></td>
                        </tr>';
                    }


                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Date Inbound</th>
                        <th>Invoice Number</th>
                        <th>PU Number</th>
                        <th>Product Name</th>
                        <th>Total Quantity</th>
                        <th>Metric Tons</th>
                        <th>Plant Price</th>
                        <th>Final Price</th>
                        <th>Encoder Name</th>
                        <th>Remarks</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
            </table>
            <div class="text-center alert alert-danger my-4" style="display: none;" id="errorBox">
                <i class="fas fa-times-circle"></i> Unable to delete this data row...
            </div>
            <div class="text-center alert alert-success my-4" style="display: none;" id="successBox">
                <i class="fas fa-check-circle"></i> <span id="successText"> Archive Success!</span>
            </div>
            <input type="hidden" id="deleteRowId">
            <!-- Modal -->
            <div class="modal fade" id="productInboundTableRestoreModal" tabindex="-1" aria-hidden="true">
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
                            <button type="button" class="btn shadow-none rippleButton ripple" id="productInboundRestore">Restore</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="productInboundTableDeleteModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confirmation <i class="fas fa-question-circle link-warning"></i></h5>
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to archive?<em>It will be permanently deleted</em>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn shadow-none rippleButton ripple" id="productInboundDelete">Delete</button>
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
        
        $(document).on('click', '#productInboundDelete', function(){
            let datastring = {
                "productInboundDelete": $('#productInboundDelete').val(),
                "deleteRowId": $('#deleteRowId').val()
            };
            $.ajax({
                url: 'includes/archive-product-inbound.inc.php',
                type: 'POST',
                data: datastring,
                dataType: 'json',
                error: function(error) {
                    console.log(error);
                },
                success: function(data) {
                    if (data.status) {
                        $('#productInboundTableDeleteModal').modal('hide');
                        $('#errorBox').hide();
                        $('#successText').text('Successfully Deleted...')
                        $('#successBox').show();
                        window.setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    } else {
                        $('#productInboundTableDeleteModal').modal('hide');
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
        $(document).on('click', '#productInboundRestore', function(){
            let datastring = {
                "productInboundRestore": $('#productInboundRestore').val(),
                "deleteRowId": $('#deleteRowId').val()
            };
            $.ajax({
                url: 'includes/archive-product-inbound.inc.php',
                type: 'POST',
                data: datastring,
                dataType: 'json',
                error: function(error) {
                    console.log(error);
                },
                success: function(data) {
                    if (data.status) {
                        $('#productInboundTableRestoreModal').modal('hide');
                        $('#errorBox').hide();
                        $('#successText').text('Restore Complete...')
                        $('#successBox').show();
                        window.setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    } else {
                        $('#productInboundTableRestoreModal').modal('hide');
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
        $(document).on('click', '#btnProductInboundRestore', function(){
            let rowId = $(this).attr('row.id');
            $('#deleteRowId').val(rowId);
            console.log($('#deleteRowId').val())
        });
        $(document).on('click', '#btnProductInboundDelete', function(){
            let rowId = $(this).attr('row.id');
            $('#deleteRowId').val(rowId);
            console.log($('#deleteRowId').val())
        });
        var table = $('#archiveProductInboundTable').DataTable({
            "searching": true,
            "bPaginate": true,
            "lengthChange": true,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": true,
            lengthMenu: [5, 10, 25, 50, 100, 200],
            "columnDefs": [{
                    targets: [4, 5, 6, 7],
                    className: "text-end"
                },
                {
                    targets: [1, 2, 3, 8, 9],
                    className: "text-justify"
                },
                {
                    targets: [0, 10],
                    className: "text-center"
                },
                {
                    orderable: false,
                    targets: [10]
                }
            ],
        });


        $("#archiveProductInboundTable_filter.dataTables_filter").append($("#categoryFilter"));

        var categoryIndex = 0;
        $("#archiveProductInboundTable th").each(function(i) {
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

    });
</script>