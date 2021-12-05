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
    <div class="container-fluid">
        <div class="d-flex flex-column align-items-center justify-content-center" style="height: 100vh;">
            <div class="shadow p-5 mb-5 bg-body rounded wrapper">
                <div class="row p-0 m-0">
                    <img src="assets/logo/logo-blue-small.png" alt="" class="img-fluid px-5 mb-5">
                </div>
                <form action="">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control shadow-none" id="forgotUsername" placeholder="ENTER USERNAME">
                        <button class="btn btn-outline-secondary shadow-none" type="button" id="btnForgotPassword">FORGOT PASSWORD</button>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="forgotUsernameFeedback" class="invalid-feedback">
                            Username Doesn't exist...
                        </div>
                    </div>
                    <div class="mb-3 mt-5">
                        <button class="btn btn-lg shadow-none rippleButton ripple" type="button" id="btnGoBack" style="width: 100%;"> GO BACK TO LOGIN PAGE</button>
                    </div>
                </form>
                <div class="mt-5 text-center alert alert-danger" id="errorBox">
                    <i class="fas fa-times-circle"></i> This Form Has Errors
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://kit.fontawesome.com/0db639a45c.js" crossorigin="anonymous"></script>
<script src="https://www.google.com/recaptcha/api.js?render=6LfjuBodAAAAAD1tqntNDiJZSr1ebjOTcM81NBEm"></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '#btnGoBack', function() {
            window.location.href = 'includes/logout.inc.php';
        });

        $(document).on('keyup', '#forgotUsername', function() {
            $('#forgotUsernameFeedback').text('Username Doesn\'t exist!');
            if (!$('#forgotUsername').val() || $('#forgotUsername').val() === "") {
                $('#forgotUsername').removeClass('is-valid');
                $('#forgotUsername').addClass('is-invalid');
                $('#forgotUsernameFeedback').text('Please input username...');
            } else {
                let datastring = {
                    "adminUsername": $('#forgotUsername').val()
                }
                console.log(datastring);
                $.ajax({
                    url: 'includes/admin-forgotpassword.inc.php',
                    type: 'POST',
                    data: datastring,
                    dataType: 'json',
                    success: function(data) {

                        if (data.status) {
                            $('#forgotUsername').removeClass('is-invalid');
                            $('#forgotUsername').addClass('is-valid');
                        } else {
                            $('#forgotUsername').removeClass('is-valid');
                            $('#forgotUsername').addClass('is-invalid');
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

        $(document).on('click', '#btnForgotPassword', function() {
            if ($(".is-invalid")[0]) {
                $('#errorBox').show();
            } else {
                $('#btnForgotPassword').prop('disabled',true);
                let datastring = {
                    "username": $('#forgotUsername').val(),
                    "btnForgot": $('#btnForgotPassword').val()
                }
                console.log(datastring);
                $.ajax({
                    url: 'includes/admin-forgotpassword.inc.php',
                    type: 'POST',
                    data: datastring,
                    dataType: 'json',
                    success: function(data) {

                        if (data.status) {
                            window.location.href = "admin-otp.php";
                        }
                        else{
                            $('#btnForgotPassword').prop('disabled',false);
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