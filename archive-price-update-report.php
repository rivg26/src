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
            <h5 class="display-4 mb-5 mt-3">Price Update Report Archive</h5>
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
                        <option value="<?php echo $today ?>">Today</option>
                        <option value="<?php echo $yesterday ?>">Yesterday</option>
                    </optgroup>
                </select>
            </div>

            <table id="archivePriceUpdateTable" class="tableDesign table table-striped table-hover align-middle shadow-none">
                <thead class="align-middle">
                    <tr>
                        <th>Date</th>
                        <th>PU Number</th>
                        <th>Encoder Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $sql = "SELECT a_price_date, a_price_pun, CONCAT(employee_table.emp_lastname, ', ', employee_table.emp_firstname, ' ' , SUBSTR(employee_table.emp_middlename,1,1), '.') AS 'fullname' FROM `archive_price_table` JOIN employee_table ON employee_table.emp_id = archive_price_table.a_price_emp_id GROUP BY a_price_pun;";
                    $result = mysqli_query($conn, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '
                            <tr>
                                <td>' . date('d M Y', strtotime($row['a_price_date'])) . '</td>
                                <td>' . $row['a_price_pun'] . '</td>
                                <td>' . $row['fullname'] . '</td>
                                <td><button type="button" class="btn btn-warning shadow-none" data-bs-toggle="modal" data-bs-target="#archivePriceUpdateTableRestoreModal" id = "btnPriceUpdateRestore" row.id="' . $row['a_price_pun'] . '" ><i class="fas fa-undo" data-bs-toggle="tooltip" data-bs-placement="top" title="Restore"></i></button> <button type="button" class="btn btn-danger shadow-none" row.id="' . $row['a_price_pun'] . '" data-bs-toggle="modal" data-bs-target="#archivePriceUpdateTableDeleteModal" id = "btnPriceUpdateDelete"><i class="fas fa-trash-alt" data-bs-toggle="tooltip" data-bs-placement="top" title="Permanent Delete"></i></button></td>
                            </tr>';
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Date</th>
                        <th>PU Number</th>
                        <th>Encoder Name</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
            </table>

            <div class="text-center alert alert-danger my-4" style="display: none;" id="errorBox">
                <i class="fas fa-times-circle"></i> Error in executing this data...
            </div>
            <div class="text-center alert alert-success my-4" style="display: none;" id="successBox">
                <i class="fas fa-check-circle"></i> <span id="successText">Archive Success!</span>
            </div>

            <input type="hidden" id="archiveDeleteRow">
            <!-- Modal -->
            <div class="modal fade" id="archivePriceUpdateTableRestoreModal" tabindex="-1" aria-hidden="true">
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
                            <button type="button" class="btn shadow-none rippleButton ripple" id="punTableRestore">Restore</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="archivePriceUpdateTableDeleteModal" tabindex="-1" aria-hidden="true">
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
                            <button type="button" class="btn shadow-none rippleButton ripple" id="punTableDelete">Delete</button>
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

        $(document).on('click', '#punTableRestore', function() {
            let datastring = {
                "punTableRestore": $('#punTableRestore').val(),
                "archiveDeleteRow": $('#archiveDeleteRow').val()
            };
            $.ajax({
                url: 'includes/archive-product-update.inc.php',
                type: 'POST',
                data: datastring,
                dataType: 'json',
                error: function(error) {
                    console.log(error);
                },
                success: function(data) {
                    if (data.status) {
                        $('#archivePriceUpdateTableRestoreModal').modal('hide');
                        $('#errorBox').hide();
                        $('#successText').text('Restore Complete...');
                        $('#successBox').show();
                        window.setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    } else {
                        $('#archivePriceUpdateTableRestoreModal').modal('hide');
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


        $(document).on('click', '#punTableDelete', function () {  
            let datastring = {
                "punTableDelete": $('#punTableDelete').val(),
                "archiveDeleteRow": $('#archiveDeleteRow').val()
            };
            $.ajax({
                url: 'includes/archive-product-update.inc.php',
                type: 'POST',
                data: datastring,
                dataType: 'json',
                error: function(error) {
                    console.log(error);
                },
                success: function(data) {
                    if (data.status) {
                        $('#archivePriceUpdateTableDeleteModal').modal('hide');
                        $('#errorBox').hide();
                        $('#successText').text('Successfully Deleted...');
                        $('#successBox').show();
                        window.setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    } else {
                        $('#archivePriceUpdateTableDeleteModal').modal('hide');
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

        $(document).on('click', '#btnPriceUpdateRestore', function() {
            let rowId = $(this).attr('row.id');
            $('#archiveDeleteRow').val(rowId);
            console.log($('#archiveDeleteRow').val())
        });
        $(document).on('click', '#btnPriceUpdateDelete', function() {
            let rowId = $(this).attr('row.id');
            $('#archiveDeleteRow').val(rowId);
            console.log($('#archiveDeleteRow').val())
        });




        var table = $('#archivePriceUpdateTable').DataTable({
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
                    targets: [1, 2],
                    className: "text-justify"
                },
                {
                    targets: [0, 3],
                    className: "text-center"
                },
                {
                    orderable: false,
                    targets: [3]
                }
            ],
            // dom: 'B<"searchBar">frtip',
        });




        $("#archivePriceUpdateTable_filter.dataTables_filter").append($("#categoryFilter"));

        var categoryIndex = 0;
        $("#archivePriceUpdateTable th").each(function(i) {
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