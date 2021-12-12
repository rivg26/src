<?php
    session_start();
    if(isset($_SESSION['otpPhoneNumber'])){
        $phoneNumber = $_SESSION['otpPhoneNumber'];
        if(isset($_SESSION['redirect'])){
            $redirect = $_SESSION['redirect'];
        }
    }
    else{
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
    <link rel="shortcut icon" type="image/png" href="assets/logo/favicon.ico" />
    <title>OTP | PAREDES PETRON SYSTEM</title>
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
                        <input type="hidden" id="phoneNum" value="<?= $phoneNumber ?>">
                        <input type="hidden" id="redirect" value="<?= $redirect ?>">
                        <input type="text" class="form-control shadow-none" id="otpCode" placeholder="ENTER OTP PIN" maxlength="6" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required>
                        <button class="btn btn-outline-secondary shadow-none" type="button" onClick="getCode();" id="btnGetCode">GET CODE</button>
                    </div>
                    <div class="mb-3 mt-5">
                        <button class="btn btn-lg shadow-none rippleButton ripple" type="button" id="btnGoBack" style="width: 100%;"> GO BACK TO LOGIN PAGE</button>
                    </div>
                </form>
                <div class="mt-5 text-center alert alert-danger" id="errorBox">

                </div>
                <div class="mt-5 text-center alert alert-success" id="sentBox" style="display: none;">
                    Code Sent!
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js?render=6LfjuBodAAAAAD1tqntNDiJZSr1ebjOTcM81NBEm"></script>
<script>
    $(document).ready(function() {
        $(document).on('keyup', '#otpCode', function() {
            if ($(this).val() === "" || $(this).val() === 0) {
                $('#errorBox').css('display', 'block');
                $('#errorBox').text("Please input field");
                $('#otpCode').removeClass('is-valid');
                $('#otpCode').addClass('is-invalid');
                $('#sentBox').hide();
            } else {
                $('#errorBox').css('display', 'none');
                let datastring = {
                    "otpCode": $('#otpCode').val()
                }
                console.log(datastring);
                $.ajax({
                    url: 'includes/admin-otp.inc.php',
                    type: 'POST',
                    data: datastring,
                    dataType: 'json',
                    success: function(data) {

                        if (data.status) {
                           let redirect = $('#redirect').val();
                           window.location.href = redirect;

                        } else {
                            $('#otpCode').removeClass('is-valid');
                            $('#otpCode').addClass('is-invalid');
                            $('#errorBox').css('display', 'block');
                            $('#errorBox').text(data.message);
                            $('#sentBox').hide();
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

        $(document).on('click', '#btnGoBack', function(){
            window.location.href = 'includes/logout.inc.php';
        });
    });
</script>
<script>
    function getCode() {
        $('#errorBox').hide();
        $('#sentBox').hide();
        $('#otpCode').removeClass('is-invalid');
        var number = document.getElementById('phoneNum').value;
        var datastring = {
            "mobileNumber": number,
            "btnGetCode": true
        }
        $.ajax({
            url: 'includes/admin-otp.inc.php',
            type: 'POST',
            data: datastring,
            dataType: 'json',
            success: function(data) {

                if (data.status) {
                    $('#sentBox').show();
                    const fewSeconds = 60;
                    $('#btnGetCode').attr('disabled', true);
                    $('#btnGetCode').removeClass('btn-outline-secondary');
                    $('#btnGetCode').addClass('btn-dark');
                    // $('#btnGetCode').text('Resend Code');
                    setTimeout(() => {
                        $('#btnGetCode').attr('disabled', false);
                        $('#btnGetCode').removeClass('btn-dark');
                        $('#btnGetCode').addClass('btn-outline-secondary');
                    }, fewSeconds * 1000);
                    $('#btnGetCode').text("");
                    $('#btnGetCode').append("<p> </p>");
                    var timeleft = 60;
                    var downloadTimer = setInterval(function() {
                        timeleft--;
                        $('#btnGetCode p').text(timeleft);
                        if (timeleft <= 0)
                            clearInterval(downloadTimer);

                    }, 1000);
                    setTimeout(function() {
                        $('#btnGetCode p').remove();
                        $('#btnGetCode').text('Resend Code');
                    }, 60 * 1000);
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
</script>


</html>