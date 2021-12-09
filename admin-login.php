<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/admin-component.css">
    <link rel="stylesheet" href="css/admin-login.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Document</title>
</head>

<body>
    <form id="formLogin">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-5 img-Container">
                    <div class="img-Wrapper">
                        <img src="assets/admin-img/petron4.png" alt="" class="img-Banner">
                    </div>
                </div>
                <div class="d-flex flex-column align-items-center justify-content-center col-sm-12 col-md-12 col-lg-7">
                    <div class="shadow p-5 mb-5 bg-body rounded wrapper">
                        <h3 class="ms-2 mb-5">Login to <strong>Paredes Petron LPG</strong></h3>
                        <div class="p-2">
                            <form>
                                <div class="mb-3">
                                    <label for="adminUsername" class="form-label">Username</label>
                                    <input type="text" class="form-control shadow-none " id="adminUsername" placeholder="ENTER USERNAME" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div id="adminUsernameFeedback" class="invalid-feedback">
                                        Username Doesn't exist...
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="adminPassword" class="form-label">Password</label>
                                    <div class="input-group mb-3 show_hide_password0">
                                        <input type="password" class="form-control shadow-none " id="adminPassword" placeholder="ENTER PASSWORD" required>
                                        <span class="input-group-text shadow-none" type="button"><a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a></span>
                                        <div id="adminPasswordFeedback" class="invalid-feedback">
                                            Invalid Password...
                                        </div>
                                    </div>
                                    <div id="accountHelp" class="form-text">Your account is always secured.</div>
                                </div>
                                <div class="mb-4 form-check">
                                    <div class="row ">
                                        <div class="d-flex ">
                                            <!-- <input type="checkbox" class="form-check-input shadow-none ps-2" id="exampleCheck1">
                                            <p class="form-check-label ps-2" for="exampleCheck1">Remember Me</p> -->
                                            <span class="fpass ms-auto ps-2"><a href="admin-forgotpassword.php" class="forgot-pass">Forgot Password?</a></span>
                                        </div>
                                    </div>


                                </div>
                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-lg shadow-none rippleButton ripple" id="btnLogin">LOG IN</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="text-center alert alert-danger wrapper" id="errorBox">
                        <i class="fas fa-times-circle"></i> This Form Has Errors
                    </div>
                </div>
            </div>
        </div>
    </form>

</body>
<script src="https://www.google.com/recaptcha/api.js?render=6LfjuBodAAAAAD1tqntNDiJZSr1ebjOTcM81NBEm"></script>

<script src="https://kit.fontawesome.com/0db639a45c.js" crossorigin="anonymous"></script>
<script src="js/admin-component.js"></script>
<script>
    $(document).ready(function() {

        $(document).on('click', '#btnLogin', function(e) {
            e.preventDefault();
            if (!$('#adminUsername').val() || !$('#adminPassword').val()) {
                if (!$('#adminUsername').val() && !$('#adminPassword').val()) {
                    $('#adminUsername').removeClass('is-valid');
                    $('#adminUsername').addClass('is-invalid');
                    $('#adminUsernameFeedback').text('Please input username...');
                    $('#adminPassword').removeClass('is-valid');
                    $('#adminPassword').addClass('is-invalid');
                    $('#adminPasswordFeedback').text('Please input password...');
                } else if (!$('#adminUsername').val()) {
                    $('#adminUsername').removeClass('is-valid');
                    $('#adminUsername').addClass('is-invalid');
                    $('#adminUsernameFeedback').text('Please input username...');
                }
                else{
                    $('#adminPassword').removeClass('is-valid');
                    $('#adminPassword').addClass('is-invalid');
                    $('#adminPasswordFeedback').text('Please input password...');
                }
            } else if ($(".is-invalid")[0]) {
                $('#errorBox').show();
            } else {
                $('#btnLogin').prop('disabled', true);
                let datastring = {
                    "username": $('#adminUsername').val(),
                    "password": $('#adminPassword').val(),
                    "btnLogin": $('#btnLogin').val()
                }
                console.log(datastring);
                $.ajax({
                    url: 'includes/admin-login.inc.php',
                    type: 'POST',
                    data: datastring,
                    dataType: 'json',
                    success: function(data) {

                        if (data.status) {
                            window.location.href = "admin-otp.php";
                        } else if (data.message === 'accLock') {
                            $('#errorBox').text('Your Account is Locked. You already reach the maximum attempts. To retrieve account, please click forgot password');
                            $('#errorBox').show();
                            $('#btnLogin').prop('disabled', true);
                        } else {
                            $('#adminPasswordFeedback').text('Incorrect Password...');
                            $('#adminPassword').removeClass('is-valid');
                            $('#adminPassword').addClass('is-invalid');
                            $('#btnLogin').prop('disabled', false);
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

        $(document).on('keyup', '#adminPassword', function() {
            if (!$('#adminPassword').val() || $('#adminPassword').val() === "") {
                $('#adminPassword').removeClass('is-valid');
                $('#adminPassword').addClass('is-invalid');
                $('#adminPasswordFeedback').text('Please input password...');
            } else {
                $('#adminPassword').removeClass('is-invalid');
            }
        });

        $(document).on('keyup', '#adminUsername', function() {
            $('#adminUsernameFeedback').text('Username Doesn\'t exist!');
            if (!$('#adminUsername').val() || $('#adminUsername').val() === "") {
                $('#adminUsername').removeClass('is-valid');
                $('#adminUsername').addClass('is-invalid');
                $('#adminUsernameFeedback').text('Please input username...');
            } else {
                let datastring = {
                    "adminUsername": $('#adminUsername').val()
                }
                console.log(datastring);
                $.ajax({
                    url: 'includes/admin-login.inc.php',
                    type: 'POST',
                    data: datastring,
                    dataType: 'json',
                    success: function(data) {

                        if (data.status) {
                            $('#adminUsername').removeClass('is-invalid');
                            $('#adminUsername').addClass('is-valid');
                        } else {
                            $('#adminUsername').removeClass('is-valid');
                            $('#adminUsername').addClass('is-invalid');
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