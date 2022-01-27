<?php require_once 'head.php' ?>
<div class="row" style="position: relative;">
    <div class="shadow p-3 mb-5 bg-body rounded">
        <div class="text-center">
            <h5 class="display-4 mb-5 mt-3">Inventory List Archive</h5>
        </div>

        <div class="table-responsive mb-5 mt-2 p-5">


            <table id="archiveInventoryViewTable" class="tableDesign table table-striped table-hover align-middle shadow-none" style="font-size: 0.8rem;">
                <thead class="align-middle">
                    <tr>
                        <th>Date</th>
                        <th>Control Number</th>
                        <th>Type</th>
                        <th>Encoder Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT `a_inv_control_number`,`a_inv_date`,`a_inv_type`, CONCAT(employee_table.emp_lastname, ', ', employee_table.emp_firstname, ' ', SUBSTRING(employee_table.emp_middlename,1,1),'.') AS 'encoder_name' FROM `archive_inventory_table` JOIN employee_table ON employee_table.emp_id = a_inv_emp_id GROUP BY `a_inv_control_number`;";
                    $result = mysqli_query($conn, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo
                        '<tr>
                            <td>' . date('d M Y', strtotime($row['a_inv_date'])) . '</td>
                            <td>' . $row['a_inv_control_number'] . '</td>
                            <td>' . $row['a_inv_type'] . '</td>
                            <td>' . $row['encoder_name'] . '</td>
                            <td><button type="button" class="btn btn-warning shadow-none" row.id = "' . $row['a_inv_control_number'] . '" id="btnRestoreInventory" data-bs-toggle="modal" data-bs-target="#inventoryRestoreModal" ><i class="fas fa-undo" data-bs-toggle="tooltip" data-bs-placement="top" title="Restore"></i></button> <button type="button" class="btn btn-danger shadow-none" data-bs-toggle="modal" data-bs-target="#inventoryDeleteModal" row.id = "' . $row['a_inv_control_number'] . '" id = "btnDeleteInventory" ><i class="fas fa-trash-alt"  data-bs-toggle="tooltip" data-bs-placement="top" title="Permanently Delete"></i></button></td>
                        </tr>';
                    }

                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Date</th>
                        <th>Control Number</th>
                        <th>Type</th>
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
            <!-- Modal -->
            <div class="modal fade" id="inventoryRestoreModal" tabindex="-1" aria-hidden="true">
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
                            <button type="button" class="btn shadow-none rippleButton ripple" id="inventoryRestore">Restore</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="inventoryDeleteModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confirmation <i class="fas fa-question-circle link-warning"></i></h5>
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete?<em> It will be permanently deleted</em>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn shadow-none rippleButton ripple" id="inventoryDelete">Delete</button>
                        </div>
                    </div>
                </div>
            </div>


        </div>


    </div>
    <?php require_once 'loader.php' ?>
    <?php require_once 'footer.php' ?>
    <script>
        $(document).ready(function() {
            $(document).on('click', '#inventoryDelete', function() {
                let datastring = {
                    "inventoryDelete": $('#inventoryDelete').val(),
                    "deleteRowId": $('#deleteRowId').val()
                };
                $.ajax({
                    url: 'includes/archive-inventory-view-report.inc.php',
                    type: 'POST',
                    data: datastring,
                    dataType: 'json',
                    error: function(error) {
                        console.log(error);
                    },
                    success: function(data) {
                        if (data.status) {
                            $('#inventoryDeleteModal').modal('hide');
                            $('#errorBox').hide();
                            $('#successText').text('Successfully Deleted...');
                            $('#successBox').show();
                            window.setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        } else {
                            $('#inventoryDeleteModal').modal('hide');
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
            $(document).on('click', '#inventoryRestore', function() {
                let datastring = {
                    "inventoryRestore": $('#inventoryRestore').val(),
                    "deleteRowId": $('#deleteRowId').val()
                };
                $.ajax({
                    url: 'includes/archive-inventory-view-report.inc.php',
                    type: 'POST',
                    data: datastring,
                    dataType: 'json',
                    error: function(error) {
                        console.log(error);
                    },
                    success: function(data) {
                        if (data.status) {
                            $('#inventoryRestoreModal').modal('hide');
                            $('#errorBox').hide();
                            $('#successText').text('Restore Complete...');
                            $('#successBox').show();
                            window.setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        } else {
                            $('#inventoryRestoreModal').modal('hide');
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


            $(document).on('click', '#btnRestoreInventory', function() {
                let rowId = $(this).attr('row.id');
                $('#deleteRowId').val(rowId);
            });
            $(document).on('click', '#btnDeleteInventory', function() {
                let rowId = $(this).attr('row.id');
                $('#deleteRowId').val(rowId);
            });

            $('#archiveInventoryViewTable').DataTable({
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
                        targets: [1, 3],
                        className: "text-justify"
                    },
                    {
                        targets: [0, 2, 4],
                        className: "text-center"
                    },
                    {
                        orderable: false,
                        targets: [4]
                    }
                ],
            });
        });
    </script>