<?php require_once 'head.php' ?>
<div class="row p-3" style="position: relative;">
    <div class="shadow p-3 mb-5 bg-body rounded">
        <div class="text-center">
            <h5 class="display-4 mb-5 mt-3">Employee List</h5>
        </div>

        <div class="table-responsive my-5 p-5">
            <table id="employeeTable" class="tableDesign table table-striped table-hover align-middle shadow-none">
                <thead class="align-middle">
                    <tr>
                        <th>Employee Number</th>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Email Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?= employeeTable($conn); ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Employee Number</th>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Email Address</th>
                        <th>Actions</th>
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
            <!-- Modal -->
            <div class="modal fade" id="employeeArchiveModal" tabindex="-1" aria-hidden="true">
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
                            <button type="button" class="btn shadow-none rippleButton ripple" id="employeeArchive">Archive</button>
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
        $(document).on('click', '#employeeArchive', function() {
            let datastring = {
                "employeeArchive": $('#employeeArchive').val(),
                "rowId": $('#rowId').val()
            }
            $.ajax({
                url: 'includes/archive-employee-list.inc.php',
                type: 'POST',
                data: datastring,
                dataType: 'json',
                error: function(error) {
                    console.log(error);
                },
                success: function(data) {
                    if (data.status) {
                        $('#employeeArchiveModal').modal('hide');
                        $('#errorBox').hide();
                        $('#successBox').show();
                        window.setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    } else {
                        $('#employeeArchiveModal').modal('hide');
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


        $(document).on('click', '#btnArchiveEmployee', function() {
            let rowId = $(this).attr('row.id');
            $('#rowId').val(rowId);
        });
        $(document).on('click', '#btnEditEmployee', function() {
            let rowId = $(this).attr('row.id');
            $("#loader").fadeIn();
            window.setTimeout(function() {
                $("#loader").fadeOut();
                window.location.href = "employee-add.php?rowId=" + rowId;
            }, 2000);
        });


        // var today = new Date().toLocaleString();
        var today = new Date();
        // today.toLocaleDateString("en-US", options);
        var options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        $('#employeeTable').DataTable({
            "searching": true,
            "bPaginate": true,
            "lengthChange": true,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": true,
            lengthMenu: [5, 10, 25, 50, 100, 200],
            "columnDefs": [{
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
            dom: 'Bfrtip',
            buttons: [{
                    text: '<i class="fas fa-folder-plus"></i>',
                    titleAttr: 'NEW EMPLOYEE',
                    className: 'btn-warning me-3 shadow-none rounded',
                    action: function(e, dt, node, config) {
                        $("#loader").fadeIn(function() {
                            $("#loader").fadeOut();
                            window.location.href = "employee-add.php";
                        });

                    },

                },
                {
                    text: '<i class="fas fa-file-excel"></i>',
                    extend: 'excel',
                    title: 'Employee List_' + moment().format('MMMM Do YYYY, h:mm:ss a'),
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
                    filename: 'Employee List_' + moment().format('MMMM Do YYYY, h:mm:ss a'),
                    header: 'Employee List',
                    messageTop: 'Date: ' + moment().format('MMMM Do YYYY, h:mm:ss a'),
                    title: 'Employee List',
                    exportOptions: {
                        columns: 'th:not(:last-child):visible',
                    }

                },
                {
                    text: '<i class="fas fa-print"></i>',
                    extend: 'print',
                    titleAttr: 'PRINT',
                    className: 'btn-info me-3 shadow-none rounded',
                    title: 'Employee List_' + moment().format('MMMM Do YYYY, h:mm:ss a'),
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
    });
</script>