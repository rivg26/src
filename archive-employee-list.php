<?php require_once 'head.php' ?>
<div class="row p-3" style="position: relative;">
    <div class="shadow p-3 mb-5 bg-body rounded">
        <div class="text-center">
            <h5 class="display-4 mb-5 mt-3">Employee List Archive</h5>
        </div>

        <div class="table-responsive my-5 p-5">
            <table id="archiveEmployeeTable" class="tableDesign table table-striped table-hover align-middle shadow-none">
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
                    <?php
                      $sql = "SELECT a_emp_id, a_emp_number, a_emp_firstname, a_emp_middlename, a_emp_lastname, a_emp_phonenumber, a_emp_email FROM `archive_employee_table`";
                      $result = mysqli_query($conn, $sql);
                  
                      while ($row = mysqli_fetch_assoc($result)) {
                          echo 
                          '<tr>
                              <td>'.$row['a_emp_number'].'</td>
                              <td>'.ucfirst($row['a_emp_lastname']). ', ' . ucfirst($row['a_emp_firstname']). ' '. ucfirst(substr($row['a_emp_middlename'],0,1)) .'.'.'</td>
                              <td>'.$row['a_emp_phonenumber'].'</td>
                              <td>'.$row['a_emp_email'].'</td>
                              <td><button type="button" class="btn btn-danger shadow-none" data-bs-toggle="modal" data-bs-target="#employeeDeleteModal"  id = "btnDeleteEmployee"  row.id ="'.$row['a_emp_number'].'"><i class="fas fa-trash-alt" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Permanently"></i></button></td>
                          </tr>';
                      }
                    //   <button type="button" class="btn btn-warning shadow-none" data-bs-toggle="modal" data-bs-target="#employeeRestoreModal"  id = "btnRestoreEmployee"  row.id ="'.$row['a_emp_id'].'" ><i class="fas fa-undo" data-bs-toggle="tooltip" data-bs-placement="top" title="Restore"></i></button> 
                    ?>
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
                <i class="fas fa-check-circle"></i> Successfully Deleted...
            </div>
            <input type="hidden" id="deleteRowId">
            <!-- Modal -->
            <div class="modal fade" id="employeeRestoreModal" tabindex="-1" aria-hidden="true">
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
                            <button type="button" class="btn shadow-none rippleButton ripple" id="employeeRestore">Restore</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="employeeDeleteModal" tabindex="-1" aria-hidden="true">
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
                            <button type="button" class="btn shadow-none rippleButton ripple" id="employeeDelete">Delete</button>
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
    $(document).ready(function(){
        $(document).on('click', '#employeeDelete', function(){
            let datastring = {
                "employeeDelete": $('#employeeDelete').val(),
                "deleteRowId": $('#deleteRowId').val()
            };
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
                        $('#employeeDeleteModal').modal('hide');
                        $('#errorBox').hide();
                        $('#successBox').show();
                        window.setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    } else {
                        $('#employeeDeleteModal').modal('hide');
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
        $(document).on('click', '#btnRestoreEmployee', function() {
            let rowId = $(this).attr('row.id');
            $('#deleteRowId').val(rowId);
        });
        $(document).on('click', '#btnDeleteEmployee', function() {
            let rowId = $(this).attr('row.id');
            $('#deleteRowId').val(rowId);
        });
        var table = $('#archiveEmployeeTable').DataTable({
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
        });
    });
</script>