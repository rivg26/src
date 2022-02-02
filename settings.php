<?php require_once 'head.php' ?>
<div class="container shadow p-3 mb-5 bg-body rounded">
    <div class="text-center">
        <h5 class="display-4 mb-5 mt-3"><i class="fas fa-cogs"></i> Settings</h5>
    </div>

    <div class="container">
        <hr>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">
                <h5>Change Password: </h5>
            </label>
            <div class="col-sm-10">
                <div class="input-group mb-3">
                    <input type="password" class="form-control" value="password" readonly>
                    <button class="btn btn-outline-secondary shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" id="button-addon2">CHANGE</button>
                </div>
                <div class="collapse" id="collapseExample">
                    <div class="card card-body">
                        <div class="mb-3">
                            <label for="oldPassword" class="form-label">Old Password</label>
                            <input type="password" class="form-control shadow-none" id="oldPassword" placeholder="input old password">
                            <div id="oldPasswordFeedback" class="invalid-feedback">
                                Please input old password...
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">New Password</label>
                            <input type="password" class="form-control shadow-none" id="newPassword" placeholder="input new password">
                            <div id="newPasswordFeedback" class="invalid-feedback">
                                Please input new password...
                            </div>
                        </div>
                        <div class="text-center">
                            <button class="btn shadow-none rippleButton ripple" data-bs-toggle="modal" data-bs-target="#passwordModal" id="btnUpdatePassword">Update Password</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <?php
                if(isset($_SESSION['accRole'])){
                    if($_SESSION['accRole'] === 'admin'){
                        echo 
                        '<div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">
                            <h5>Download Database: </h5>
                        </label>
                        <div class="col-sm-9">
                            <button class="btn shadow-none rippleButton ripple" data-bs-toggle="modal" data-bs-target="#downloadModal" id="btnDownload">Download</button>
                        </div>
                    </div>';
                    }
                }
            ?>
            
        </div>
        <div class="text-center alert alert-success my-4" style="display: none;" id="successBox">
            <i class="fas fa-check-circle"></i> <span id="successText"></span>
        </div>

        <div class="modal fade" id="passwordModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirmation <i class="fas fa-question-circle link-warning"></i></h5>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to update your password?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn shadow-none rippleButton ripple" id="update">Update</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="downloadModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirmation <i class="fas fa-question-circle link-warning"></i></h5>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to download the database?
                    </div>
                    <div class="modal-footer">
                        <form action="includes/settings.inc.php" method="POST">
                            <button type="submit" class="btn shadow-none rippleButton ripple" id="download" name="downloads">Download</button>
                        </form>

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
        $(document).on('keyup', '#oldPassword', function() {
            if (!$('#oldPassword').val().trim() || $('#oldPassword').val().trim() == "") {
                $('#oldPasswordFeedback').text('Please input old password...');
                $('#oldPassword').removeClass('is-valid').addClass('is-invalid');
            } else {
                $('#oldPassword').removeClass('is-invalid').addClass('is-valid');
            }
        });
        $(document).on('keyup', '#newPassword', function() {
            if (!$('#newPassword').val().trim() || $('#newPassword').val().trim() == "") {
                $('#newPasswordFeedback').text('Please input new password...');
                $('#newPassword').removeClass('is-valid').addClass('is-invalid');
            } else {
                $('#newPassword').removeClass('is-invalid').addClass('is-valid');
            }
        });
        $(document).on('click', '#update', function() {
            $('input').each(function() {
                if ($(this).val().trim() === "") {
                    $(this).removeClass("is-valid");
                    $(this).addClass("is-invalid");
                }
            });
            if ($('.is-invalid')[0]) {
                $('#passwordModal').modal('hide');
            } else {
                let datastring = {
                    "update": $('#update').val(),
                    "oldPassword": $('#oldPassword').val(),
                    "newPassword": $('#newPassword').val()
                };
                $.ajax({
                    url: 'includes/settings.inc.php',
                    type: 'POST',
                    data: datastring,
                    dataType: 'json',
                    error: function(error) {
                        console.log(error);
                    },
                    success: function(data) {
                        if (data.status) {
                            $('#passwordModal').modal('hide');
                            $('#successText').text('Password Updated Success...');
                            $('#successBox').show();
                            window.setTimeout(function() {
                                window.location.href = "includes/logout.inc.php";
                            }, 1200);
                        } else {
                            if (data.message == "old") {
                                $('#passwordModal').modal('hide');
                                $('#oldPassword').removeClass('is-valid').addClass('is-invalid');
                                $('#oldPasswordFeedback').text('Invalid old password');
                            } else if (data.message == "new") {
                                $('#passwordModal').modal('hide');
                                $('#newPassword').removeClass('is-valid').addClass('is-invalid');
                                $('#newPasswordFeedback').text('Password must have numbers,capital letters, small letters, symbol and 8 characters...');
                            } else if (data.message == "same") {
                                $('#passwordModal').modal('hide');
                                $('#newPassword').removeClass('is-valid').addClass('is-invalid');
                                $('#newPasswordFeedback').text('Password must not be the same in old password...');
                            }


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
        $(document).on('click', '#download', function() {
            $('#downloadModal').modal('hide');
            $('#successText').text('Successfully downloaded the database...');
            $('#successBox').show();
            window.setTimeout(function() {
                window.location.reload();
            }, 1200);

        });
    });
</script>