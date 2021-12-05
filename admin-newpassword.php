<?php
session_start();

if (isset($_SESSION['forgotUsername'])) {
    $username = $_SESSION['forgotUsername'];
} else {
    header('location: admin-login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/admin-component.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<style>
    body {
        background-image: linear-gradient(to right, #31b9f1, #35b5f0, #3ab1f0, #3facee, #45a8ed, #4ba4ec, #51a0ea, #579ce8, #5e97e6, #6592e3, #6b8de0, #7288dc);
    }

    input {
        border-radius: 4px;
        height: 54px;
        border: none;
    }

    .wrapper {
        width: 30%;
    }

    #errorBox {
        display: none;
    }
</style>

<body>
    <div class="container-fluid" style="position: relative;">
        <div class="d-flex flex-column align-items-center justify-content-center" style="height: 100vh;">
            <div class="shadow p-5 mb-5 bg-body rounded wrapper">
                <div class="row p-0 m-0">
                    <img src="assets/logo/logo-blue-small.png" alt="" class="img-fluid px-5 mb-5">
                </div>
                <form action="">
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password</label>
                        <div class="input-group mb-3 show_hide_password0">
                            <input type="password" class="form-control shadow-none" id="newPassword" placeholder="ENTER NEW PASSWORD">
                            <span class="input-group-text shadow-none"><a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a></span>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div id="newPasswordFeedback" class="invalid-feedback">
                                Password must contain atleast 8 characters, 1 small letter, 1 big letter, 1 symbol & 1 number..
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="newPassword1" class="form-label">Confirm New Password</label>
                        <div class="input-group mb-3 show_hide_password1">
                            <input type="password" class="form-control shadow-none" id="newPassword1" placeholder="CONFIRM NEW PASSWORD">
                            <span class="input-group-text shadow-none"><a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a></span>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div id="newPassword1Feedback" class="invalid-feedback">
                                Passwords doesn't match...
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 mt-5">
                        <button class="btn btn-lg shadow-none rippleButton ripple" id="btnSubmitNewPassword" style="width: 100%;"> SUBMIT</button>
                    </div>
                </form>
                <div class="mt-5 text-center alert alert-danger" id="errorBox">
                    <i class="fas fa-times-circle"></i> This Form Has Errors
                </div>
                <div class="mt-5 text-center alert alert-success" id="successBox" style="display: none;">
                    <i class="fas fa-check-circle"></i> Password Change!
                </div>
            </div>
        </div>
        <?php require_once 'loader.php' ?>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://kit.fontawesome.com/0db639a45c.js" crossorigin="anonymous"></script>
<script src="https://www.google.com/recaptcha/api.js?render=6LfjuBodAAAAAD1tqntNDiJZSr1ebjOTcM81NBEm"></script>
<script src="js/admin-component.js"></script>
<script>
    $(document).ready(function() {

        $(document).on('click', '#btnSubmitNewPassword', function() {
            if ($('.is-invalid')[0]) {
                $('#errorBox').show();
            } else {
                $('#btnSubmitNewPassword').prop('disabled', true);
                let datastring = {
                    "p1": $('#newPassword').val(),
                    "p2": $('#newPassword1').val(),
                    "btnSubmitPass": $('#btnSubmitNewPassword').val()
                }
                console.log(datastring);
                $.ajax({
                    url: 'includes/admin-newpassword.inc.php',
                    type: 'POST',
                    data: datastring,
                    dataType: 'json',
                    success: function(data) {

                        if (data.status) {
                            $('#successBox').show();
                            $("#loader").fadeIn();
                            window.setTimeout(function() {
                                window.location.href = 'admin-login.php';
                            }, 5000);

                        } else {
                            alert('error occurs');
                            $('#btnSubmitNewPassword').prop('disabled', false);
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

        $(document).on('keyup', '#newPassword', function() {

            $('#newPasswordFeedback').text('Password must contain atleast 8 characters, 1 small letter, 1 big letter, 1 symbol & 1 number..');
            if (!$('#newPassword').val() || $('#newPassword').val() === "") {
                $('#newPassword').removeClass('is-valid');
                $('#newPassword').addClass('is-invalid');
                $('#newPasswordFeedback').text('Please input new password...');
            } else {
                let datastring = {
                    "newPassword": $('#newPassword').val()
                }
                console.log(datastring);
                $.ajax({
                    url: 'includes/admin-newpassword.inc.php',
                    type: 'POST',
                    data: datastring,
                    dataType: 'json',
                    success: function(data) {

                        if (data.status) {

                            if (!$('#newPassword1').val() || $('#newPassword1').val() === "") {
                                $('#newPassword').removeClass('is-invalid');
                                $('#newPassword').addClass('is-valid');
                            } else {
                                if ($('#newPassword1').val() === $('#newPassword').val()) {
                                    $('#newPassword').removeClass('is-invalid');
                                    $('#newPassword').addClass('is-valid');
                                } else {
                                    $('#newPasswordFeedback').text('Passwords doesn\'t match...');
                                    $('#newPassword').removeClass('is-valid');
                                    $('#newPassword').addClass('is-invalid');
                                }
                            }

                        } else {
                            $('#newPassword').removeClass('is-valid');
                            $('#newPassword').addClass('is-invalid');
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
        $(document).on('keyup', '#newPassword1', function() {

            $('#newPassword1Feedback').text('Passwords doesn\'t match...');
            if (!$('#newPassword1').val() || $('#newPassword1').val() === "") {
                $('#newPassword1').removeClass('is-valid');
                $('#newPassword1').addClass('is-invalid');
                $('#newPassword1Feedback').text('Please input confirm new password...');
            } else {
                let datastring = {
                    "newPassword1": $('#newPassword1').val(),
                    "firstPassword": $('#newPassword').val()
                }
                console.log(datastring);
                $.ajax({
                    url: 'includes/admin-newpassword.inc.php',
                    type: 'POST',
                    data: datastring,
                    dataType: 'json',
                    success: function(data) {

                        if (data.status) {
                            $('#newPassword1').removeClass('is-invalid');
                            $('#newPassword1').addClass('is-valid');
                        } else {
                            $('#newPassword1').removeClass('is-valid');
                            $('#newPassword1').addClass('is-invalid');
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

</html>