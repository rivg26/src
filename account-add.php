<?php require_once 'head.php' ?>
<div class="container" style="position: relative;">
    <div class="shadow p-3 mb-5 bg-body rounded">
        <div class="text-center">
            <h5 class="display-4 mb-5 mt-3">Create User Account</h5>
        </div>
        <div class="row d-flex align-items-center flex-column justify-content-center ">
            <div class="col-md-5 mt-2">
                <label for="accEmployee" class="form-label">Employee Name</label>
                <select class="form-select shadow-none" id="accEmployee">
                    <option value="" selected disabled>---Select Employee---</option>
                    <?= accountEmployeeSelect($conn); ?>
                </select>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback" id="accEmployeeFeedback">
                    Please Select Employee...
                </div>
            </div>
            <div class="col-md-5 mt-2">
                <label for="accRole" class="form-label">Role</label>
                <select class="form-select shadow-none" id="accRole">
                    <option value="" selected disabled>---Select Role---</option>
                    <option value="admin">Admin</option>
                    <option value="secretary">Secretary</option>
                </select>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback" id="accRoleFeedback">
                    Please Select Role...
                </div>
            </div>
            <div class="col-md-5 mt-2">
                <label for="accUsername" class="form-label">Username</label>
                <input type="text" class="form-control shadow-none" id="accUsername" placeholder="username">
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback" id="accUsernameFeedback">
                    Please input username...
                </div>
            </div>
            <div class="col-md-5 mt-2">
                <label for="accPassword" class="form-label">Password</label>
                <input type="password" class="form-control shadow-none" id="accPassword" readonly>
            </div>
            <div class="text-center my-5 no-printme">
                <button class="btn btn-lg shadow-none rippleButton ripple no-printme" id="btnAccSubmit" data-bs-toggle="modal" data-bs-target="#accModal" data-backdrop="false">Create</button>
            </div>
            <div class="text-center alert alert-danger my-4" style="display: none;" id="errorBox">
                <i class="fas fa-times-circle"></i> Please fill all the fields...
            </div>
            <div class="text-center alert alert-success mb-5 w-50" style="display: none;" id="successBox">
                <i class="fas fa-check-circle"></i> Account Creation Success!
            </div>
        </div>

    </div>
    <!-- Modal -->
    <div class="modal fade" id="accModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmation <i class="fas fa-question-circle link-warning"></i></h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to create account?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn shadow-none rippleButton ripple" id="accSubmit">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- hidden -->
    <input type="hidden" name="" id="accPhoneNumber">
</div>
<?php require_once 'loader.php' ?>
<?php require_once 'footer.php' ?>
<script>
    $(document).ready(function() {

        $(document).on('click', '#accSubmit', function() {
            $('select').each(function() {
                if ($(this).val() === "" || !$(this).val()) {
                    $(this).removeClass('is-valid').addClass('is-invalid');
                }
            });
            $('input').not('#accPassword, #accPhoneNumber').each(function() {
                if ($(this).val() === "" || !$(this).val()) {
                    $(this).removeClass('is-valid').addClass('is-invalid');
                }
            });

            if ($('.is-invalid')[0]) {
                $('#accModal').modal('hide');
            } else {
                let datastring = {
                    "accEmployee": $('#accEmployee').val(),
                    "accRole": $('#accRole').val(),
                    "accUsername": $('#accUsername').val(),
                    "accPassword": $('#accPassword').val(),
                    "accPhoneNumber": $('#accPhoneNumber').val(),
                    "btnAccSubmit": "submit"
                };

                $.ajax({
                    url: 'includes/account-add.inc.php',
                    type: 'POST',
                    data: datastring,
                    dataType: 'json',
                    error: function(error) {
                        console.log(error);
                    },
                    success: function(data) {
                        if (data.status) {
                            $('input').prop('disabled', true);
                            $('select').prop('disabled', true);
                            $('#btnAccSubmit').html("<span class='spinner-border spinner-border-sm ' id = 'loading' role='status' aria-hidden='true'></span>");
                            $('#successBox').show();
                            $('#accModal').modal('hide');
                            window.setTimeout(function() {
                                window.location.href = 'account-management-list.php';
                            }, 2000);
                        } else {
                            alert('error');
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

            }
        });



        $(document).on('change', '#accEmployee', function() {
            if ($('#accEmployee').val() == "" || !$('#accEmployee').val()) {
                $('#accEmployee').removeClass('is-valid').addClass('is-invalid');
                $('#accEmployeeFeedback').text('Please Select Employee...');
            } else {
                let datastring = {
                    "accEmployee": $('#accEmployee').val(),
                    "checkEmp": "check"
                };

                $.ajax({
                    url: 'includes/account-add.inc.php',
                    type: 'POST',
                    data: datastring,
                    dataType: 'json',
                    error: function(error) {
                        console.log(error);
                    },
                    success: function(data) {
                        if (data.status) {
                            $('#accEmployee').removeClass('is-invalid').addClass('is-valid');
                            $('#accPhoneNumber').val(data.phoneNumber);
                        } else {
                            $('#accEmployee').removeClass('is-valid').addClass('is-invalid');
                            $('#accEmployeeFeedback').text('User Account Exist...');
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

            }
        });

        $(document).on('change', '#accRole', function() {
            if ($(this).val() === "" || !$(this).val()) {
                $(this).removeClass('is-valid').addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid').addClass('is-valid');
            }
        });
        $(document).on('keyup', '#accUsername', function() {
            if ($(this).val().trim() === "" || !$(this).val().trim()) {
                $(this).removeClass('is-valid').addClass('is-invalid');
                $('#accUsernameFeedback').text('Please input username...');
            } else {
                let datastring = {
                    "accUsername": $('#accUsername').val(),
                    "checkUsername": "check"
                };

                $.ajax({
                    url: 'includes/account-add.inc.php',
                    type: 'POST',
                    data: datastring,
                    dataType: 'json',
                    error: function(error) {
                        console.log(error);
                    },
                    success: function(data) {
                        if (data.status) {
                            $('#accUsername').removeClass('is-invalid').addClass('is-valid');
                            $('#accPassword').val(data.pass);
                        } else {
                            $('#accUsername').removeClass('is-valid').addClass('is-invalid');
                            $('#accUsernameFeedback').text('Username Exist...');
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
            }
        });
    });
</script>