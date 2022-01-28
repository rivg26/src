<?php require_once 'head.php' ?>
<div class="row" style="position: relative;">
    <div class="shadow p-3 mb-5 bg-body rounded">
        <div class="text-center">
            <h5 class="display-4 mb-5 mt-3">User Account List</h5>
        </div>
        <div class="table-responsive mb-5 mt-2 p-5">
            <table id="accountManagementTable" class="tableDesign table table-striped table-hover align-middle shadow-none" style="font-size: 0.8rem;">
                <thead class="align-middle">
                    <tr>
                        <th>Date</th>
                        <th>Employee Name</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?= accountManagementTable($conn) ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Date</th>
                        <th>Employee Name</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
            
            <div class="text-center alert alert-danger my-4" style="display: none;" id="errorBox">
                <i class="fas fa-times-circle"></i> <span id="errorText"></span>
            </div>
            <div class="text-center alert alert-success my-4" style="display: none;" id="successBox">
                <i class="fas fa-check-circle"></i> <span id="successText"></span>
            </div>
            <input type="hidden" id="rowId">
            <!-- Modal -->
            <div class="modal fade" id="lockAccountModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confirmation <i class="fas fa-question-circle link-warning"></i></h5>
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to lock this account?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn shadow-none rippleButton ripple" id="lock">Lock</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="unlockAccountModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confirmation <i class="fas fa-question-circle link-warning"></i></h5>
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to unlock this account?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn shadow-none rippleButton ripple" id="unlock">unlock</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once 'loader.php' ?>
</div>
<?php require_once 'footer.php' ?>
<script>
    $(document).ready(function(){
        $(document).on('click','#lock', function(){
            let datastring = {
                "lock": $('#lock').val(),
                "rowId": $('#rowId').val()
            };

            $.ajax({
                url: 'includes/account-management-list.inc.php',
                type: 'POST',
                data: datastring,
                dataType: 'json',
                error: function(error) {
                    console.log(error);
                },
                success: function(data) {
                    if (data.status) {
                        $('#lockAccountModal').modal('hide');
                        $('#errorBox').hide();
                        $('#successText').text('Successfully lock the account...');
                        $('#successBox').show();
                        window.setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    } else {
                        $('#lockAccountModal').modal('hide');
                        $('#errorText').text('Unable to lock the account...');
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
        $(document).on('click','#unlock', function(){
            let datastring = {
                "unlock": $('#unlock').val(),
                "rowId": $('#rowId').val()
            };

            $.ajax({
                url: 'includes/account-management-list.inc.php',
                type: 'POST',
                data: datastring,
                dataType: 'json',
                error: function(error) {
                    console.log(error);
                },
                success: function(data) {
                    if (data.status) {
                        $('#unlockAccountModal').modal('hide');
                        $('#errorBox').hide();
                        $('#successText').text('Successfully unlock the account...');
                        $('#successBox').show();
                        window.setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    } else {
                        $('#unlockAccountModal').modal('hide');
                        $('#errorText').text('Unable to unlock the account...');
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

        $(document).on('click','#btnAccLock', function(){
            let rowId = $(this).attr('row.id');
            $('#rowId').val(rowId);
        });
        $(document).on('click','#btnAccUnlock', function(){
            let rowId = $(this).attr('row.id');
            $('#rowId').val(rowId);
        });
        $('#accountManagementTable').DataTable({
            "searching": true,
            "bPaginate": true,
            "lengthChange": true,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": true,
            lengthMenu: [8, 10, 25, 50, 100, 200],
            "columnDefs": [{
                    targets: [],
                    className: "text-end"
                },
                {
                    targets: [1],
                    className: "text-justify"
                },
                {
                    targets: [0,2,3,4],
                    className: "text-center"
                },
                {
                    orderable: false,
                    targets: [4]
                },
                
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    text: '<i class="fas fa-folder-plus"></i>',
                    titleAttr: 'NEW INBOUND',
                    className: 'btn-warning me-3 shadow-none rounded',
                    action: function(e, dt, node, config) {
                        $("#loader").fadeIn(function() {
                            $("#loader").fadeOut();
                            window.location.href = "account-add.php";
                        });

                    },

                },
                {
                    text: '<i class="fas fa-file-excel"></i>',
                    extend: 'excel',
                    title: 'Account List_' + moment().format('MMMM Do YYYY, h:mm:ss a'),
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
                    filename: 'Account List_' + moment().format('MMMM Do YYYY, h:mm:ss a'),
                    header: 'Account List',
                    messageTop: 'Date: ' + moment().format('MMMM Do YYYY, h:mm:ss a'),
                    title: 'Account List',
                    exportOptions: {
                        columns: ':visible',
                    }

                },
                {
                    text: '<i class="fas fa-print"></i>',
                    extend: 'print',
                    titleAttr: 'PRINT',
                    className: 'btn-info me-3 shadow-none rounded',
                    title: 'Account List_' + moment().format('MMMM Do YYYY, h:mm:ss a'),
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