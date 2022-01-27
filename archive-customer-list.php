<?php require_once 'head.php' ?>
<div class="row p-3" style="position: relative;">
    <div class="shadow p-3 mb-5 bg-body rounded">
        <div class="text-center">
            <h5 class="display-4 mb-5 mt-3">Customer List Archive</h5>
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
                        <option value="<?= date('d M Y', strtotime(date('Y-m-d'))) ?>">Today</option>
                        <option value="<?= date('d M Y', strtotime("-1 days")) ?>">Yesterday</option>
                    </optgroup>
                </select>
            </div>

            <table id="archiveCustomerReportTable" class="tableDesign table table-striped table-hover align-middle shadow-none">
                <thead class="align-middle">
                    <tr>
                        <th>Date</th>
                        <th>Customer Number</th>
                        <th>Customer Name</th>
                        <th>Phone Number</th>
                        <th>Encoder Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT a_customer_id, `a_customer_number`, CONCAT(employee_table.emp_lastname, ', ', employee_table.emp_firstname, ' ' , SUBSTR(employee_table.emp_middlename,1,1), '.') AS 'customer_employee_name', CONCAT( `a_customer_first_name`, ' ', `a_customer_middle_name`, ' ', `a_customer_last_name`) as 'customer_fullname', `a_customer_phone_number`, `a_customer_date` FROM `archive_customer_table` JOIN employee_table ON employee_table.emp_id = a_customer_encoder_id ;";

                    $result = mysqli_query($conn, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo
                        '<tr>
                             <td>' . date('d M Y', strtotime($row['a_customer_date'])) . '</td>
                             <td>' . $row['a_customer_number'] . '</td>
                             <td>' . $row['customer_fullname'] . '</td>
                             <td>' . $row['a_customer_phone_number'] . '</td>
                             <td class="remarksWrapper">' . $row['customer_employee_name'] . '</td>
                             <td><button type="button" class="btn btn-danger shadow-none" data-bs-toggle="modal" data-bs-target="#customerDeleteModal" row.id="' . $row['a_customer_number'] . '" id="btnDeleteCustomer" ><i class="fas fa-trash-alt"  data-bs-toggle="tooltip" data-bs-placement="top"  title="Delete Permanently"></i></button></td>
                         </tr>';
                    }

                    // <button type="button" class="btn btn-warning shadow-none" row.id="' . $row['a_customer_number'] . '" id="btnRestoreCustomer"  data-bs-toggle="modal" data-bs-target="#customerRestoreModal"  ><i class="fas fa-undo" data-bs-toggle="tooltip" data-bs-placement="top" title="Restore"></i></button>
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Date</th>
                        <th>Customer Number</th>
                        <th>Customer Name</th>
                        <th>Phone Number</th>
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
            <input type="hidden" id="deleteRowId">

            <div class="modal fade" id="customerRestoreModal" tabindex="-1" aria-hidden="true">
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
                            <button type="button" class="btn shadow-none rippleButton ripple" id="customerRestore">Restore</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="customerDeleteModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confirmation <i class="fas fa-question-circle link-warning"></i></h5>
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete? <em> It will be permanently deleted</em>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn shadow-none rippleButton ripple" id="customerDelete">Delete</button>
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

        $(document).on('click', '#customerDelete', function() {
            let datastring = {
                "customerDelete": $('#customerDelete').val(),
                "deleteRowId": $('#deleteRowId').val()
            }
            $.ajax({
                url: 'includes/archive-customer-list.inc.php',
                type: 'POST',
                data: datastring,
                dataType: 'json',
                error: function(error) {
                    console.log(error);
                },
                success: function(data) {
                    if (data.status) {
                        $('#customerDeleteModal').modal('hide');
                        $('#errorBox').hide();
                        $('#successText').text('Successfully Deleted...');
                        $('#successBox').show();
                        window.setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    } else {
                        $('#customerDeleteModal').modal('hide');
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
        $(document).on('click', '#customerRestore', function() {
            let datastring = {
                "customerRestore": $('#customerRestore').val(),
                "deleteRowId": $('#deleteRowId').val()
            }
            $.ajax({
                url: 'includes/archive-customer-list.inc.php',
                type: 'POST',
                data: datastring,
                dataType: 'json',
                error: function(error) {
                    console.log(error);
                },
                success: function(data) {
                    if (data.status) {
                        $('#customerRestoreModal').modal('hide');
                        $('#errorBox').hide();
                        $('#successText').text('Restore Complete...');
                        $('#successBox').show();
                        window.setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    } else {
                        $('#customerRestoreModal').modal('hide');
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


        $(document).on('click', '#btnRestoreCustomer', function() {
            let rowId = $(this).attr('row.id');
            $('#deleteRowId').val(rowId);
        });
        $(document).on('click', '#btnDeleteCustomer', function() {
            let rowId = $(this).attr('row.id');
            $('#deleteRowId').val(rowId);
        });


        var table = $('#archiveCustomerReportTable').DataTable({
            "searching": true,
            "bPaginate": true,
            "lengthChange": true,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": true,
            lengthMenu: [5, 10, 25, 50, 100, 200],
            "columnDefs": [{
                    targets: [],
                    className: "text-end"
                },
                {
                    targets: [2, 4],
                    className: "text-justify"
                },
                {
                    targets: [0, 1, 3, 5],
                    className: "text-center"
                },
                {
                    orderable: false,
                    targets: [5]
                }
            ],
        });

        $("#archiveCustomerReportTable_filter.dataTables_filter").append($("#categoryFilter"));

        var categoryIndex = 0;
        $("#archiveCustomerReportTable th").each(function(i) {
            if ($($(this)).html() == "Date") {
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