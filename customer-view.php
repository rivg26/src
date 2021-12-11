<?php require_once 'head.php' ?>
<div class="container" style="position: relative;">

    <div class="row shadow p-5 mb-4 bg-body rounded  mt-3">
        <div class="text-center">
            <h5 class="display-4 mb-5 mt-3">Add Customer</h5>
        </div>
        <fieldset class="border mt-5 p-5  g-5 bg-light">
            <legend class="float-none w-auto">Personal Information</legend>
            <div class="row">
                <div class="col-md-5 mb-3">
                    <label for="customerFirstName" class="form-label">First Name*</label>
                    <input type="text" class="form-control shadow-none" id="customerFirstName" placeholder="first name" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div id="customerFirstNameFeedback" class="invalid-feedback">
                        Please input First Name....
                    </div>
                </div>
                <div class="col-md-5 mb-3">
                    <label for="customerLastName" class="form-label">Last Name*</label>
                    <input type="text" class="form-control shadow-none" id="customerLastName" placeholder="last name" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div id="customerLastNameFeedback" class="invalid-feedback">
                        Please input Last Name....
                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="customerMiddleName" class="form-label">Middle Initial*</label>
                    <input type="text" class="form-control shadow-none" id="customerMiddleName" placeholder="M.I." maxlength="3" onkeypress="return /^[a-zA-Z\s.]*$/.test(event.key)">
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div id="customerMiddleNameFeedback" class="invalid-feedback">
                        Please input Middle Initial....
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="customerPhoneNumber" class="form-label">Phone Number*</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text">+63</span>
                        <input type="text" class="form-control shadow-none" id="customerPhoneNumber" maxlength="10" onkeypress="return /^[0-9]*$/.test(event.key)">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="customerPhoneNumberFeedback" class="invalid-feedback">
                            Please input Phone Number....
                        </div>
                    </div>


                </div>
            </div>
        </fieldset>
        <fieldset class="border mt-5 p-5  g-5 bg-light">
            <legend class="float-none w-auto">Address</legend>
            <div class="row mb-3">
                <div class="col-md-6 mb-3">
                    <label for="customerUnit" class="form-label">House/Unit No.*</label>
                    <input type="text" class="form-control shadow-none" id="customerUnit" placeholder="house/unit no." onkeypress="return /^[a-zA-Z\s0-9.,-]*$/.test(event.key)">
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div id="customerUnitFeedback" class="invalid-feedback">
                        Please input House/Unit No....
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="customerStreet" class="form-label">Street/Bldg.*</label>
                    <input type="text" class="form-control shadow-none" id="customerStreet" placeholder="street bldg." onkeypress="return /^[a-zA-Z\s0-9.,-]*$/.test(event.key)">
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div id="customerStreetFeedback" class="invalid-feedback">
                        Please input Street/Bldg...
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4 mb-3">
                    <label for="customerBarangay" class="form-label">Barangay*</label>
                    <input type="text" class="form-control shadow-none" id="customerBarangay" placeholder="barangay" onkeypress="return /^[a-zA-Z\s0-9]*$/.test(event.key)">
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div id="customerBarangayFeedback" class="invalid-feedback">
                        Please input Barangay...
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="customerCity" class="form-label">Municipality/City*</label>
                    <input type="text" class="form-control shadow-none" id="customerCity" placeholder="municipality/city" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div id="customerCityFeedback" class="invalid-feedback">
                        Please input Municipality/City...
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="customerProvince" class="form-label">Province*</label>
                    <input type="text" class="form-control shadow-none" id="customerProvince" placeholder="province" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div id="customerProvinceFeedback" class="invalid-feedback">
                        Please input Province...
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="customerLandmark" class="form-label">Landmark</label>
                    <textarea class="form-control shadow-none" placeholder="landmark" id="customerLandmark" style="height: 100px" onkeypress="return /^[a-zA-Z\s0-9.,()]*$/.test(event.key)"></textarea>
                </div>
            </div>
        </fieldset>


        <div class="text-center mt-5">
            <button type="button" class="btn btn-lg shadow-none rippleButton ripple" data-bs-toggle="modal" data-bs-target="#customerModal" id="btnCustomerSubmit">Submit</button>
            <button type="button" class="btn btn-lg shadow-none rippleButton ripple" id="btnLocation" >Location</button>
        </div>


        <div class="modal fade" id="customerModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirmation <i class="fas fa-question-circle link-warning"></i></h5>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn shadow-none rippleButton ripple" id="customerSubmit">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once 'loader.php' ?>
</div>
<?php require_once 'footer.php' ?>
<script>
    $(document).ready(function() {

        $(document).on('click', '#customerSubmit', function(){
            
        });


        const popupCenter = ({
            url,
            title,
            w,
            h
        }) => {
            // Fixes dual-screen position                             Most browsers      Firefox
            const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screenX;
            const dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screenY;

            const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
            const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

            const systemZoom = width / window.screen.availWidth;
            const left = (width - w) / 2 / systemZoom + dualScreenLeft
            const top = (height - h) / 2 / systemZoom + dualScreenTop
            const newWindow = window.open(url, title,
                `
                scrollbars=yes,
                width=${w / systemZoom}, 
                height=${h / systemZoom}, 
                top=${top}, 
                left=${left}
                `
                        )

            if (window.focus) newWindow.focus();
        }
        $(document).on('click','#btnLocation', function(){
            popupCenter({url: 'maps.php?location= Sm Bacoor', title: 'Paredes Petron Location', w: 900, h: 500});  
        });
        $(document).on('keyup', '#customerFirstName', function() {
            validation('#customerFirstName');
        });
        $(document).on('keyup', '#customerLastName', function() {
            validation('#customerLastName');
        });
        $(document).on('keyup', '#customerMiddleName', function() {
            validation('#customerMiddleName');
        });
        $(document).on('keyup', '#customerUnit', function() {
            validation('#customerUnit');
        });
        $(document).on('keyup', '#customerStreet', function() {
            validation('#customerStreet');
        });
        $(document).on('keyup', '#customerBarangay', function() {
            validation('#customerBarangay');
        });
        $(document).on('keyup', '#customerCity', function() {
            validation('#customerCity');
        });
        $(document).on('keyup', '#customerProvince', function() {
            validation('#customerProvince');
        });
        $(document).on('keyup', '#customerPhoneNumber', function() {
            $('#customerPhoneNumberFeedback').text('Please input Phone Number....');
            if (!$(this).val() || $(this).val() === "") {
                $(this).removeClass('is-valid');
                $(this).addClass('is-invalid');
            } else {
                let datastring = {
                    "phoneNumber": $('#customerPhoneNumber').val(),
                    "sendPhoneNumber": "phoneSent"
                };
                console.log(datastring);
                $.ajax({
                    url: 'includes/customer-view.inc.php',
                    type: 'POST',
                    data: datastring,
                    dataType: 'json',
                    success: function(data) {
                        if (data.status) {
                            $('#customerPhoneNumber').removeClass('is-invalid');
                            $('#customerPhoneNumber').addClass('is-valid');
                        } else {
                            $('#customerPhoneNumberFeedback').text('Invalid Phone Number....');
                            $('#customerPhoneNumber').removeClass('is-valid');
                            $('#customerPhoneNumber').addClass('is-invalid');
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


        function validation(id) {
            if (!$(id).val() || $(id).val() === "") {
                $(id).removeClass('is-valid');
                $(id).addClass('is-invalid');
            } else {
                $(id).removeClass('is-invalid');
                $(id).addClass('is-valid');
            }
        }



    });
</script>