<?php require_once 'head.php' ?>


<div class="row p-3">
    <div class="d-flex justify-content-center align-items-start flex-row" style="position: relative;display:none; "><?php require_once 'loader.php' ?></div>
    <div class="mx-auto shadow p-5 my-5 bg-white rounded justify-content-center">
        <div class="text-start">
            <h5 class="display-4  mt-3 no-printme">Add Employee</h5>
        </div>
        <div class="mb-5 no-printme">
            &nbsp;
        </div>

        <div class="border p-5 mt-5 position-relative">
            <div class="position-absolute top-0 start-50 translate-middle d-flex flex-row justify-content-center ">
                <div class="d-flex flex-column justify-content-center" style="width: 8%; height: 8%;">
                    <img src="img/me.jpg" class="rounded-circle shadow printmeImg " alt="">
                    <label for="files" class="alert alert-info m-0 p-0 w-50 text-center mt-3 no-printme" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Set Profile Picture"><i class="fas fa-upload"></i> Upload</label>
                    <input type="file" class="form-control form-control-sm mt-3 shadow-none visually-hidden" id="files" name="">
                </div>
            </div>

            <div class="row mt-3 no-printme">
                &nbsp;
            </div>
            <div class="printme">
                <fieldset class="mt-5 p-4 border">
                    <legend class="w-auto float-none">Personal Information</legend>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="mb-4">
                                <label for="exampleInputEmail1" class="form-label">Employee Number</label>
                                <input type="text" class="form-control shadow-none" id="exampleInputEmail1" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-2">
                                <label for="empFirstName" class="form-label">First Name</label>
                                <input type="text" class="form-control shadow-none" id="empFirstName" onkeypress="validateFirstName();">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div id="empFirstNameInvalidFeedback" class="invalid-feedback">
                                    Please choose a username.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-2">
                                <label for="exampleInputEmail1" class="form-label">Middle Name</label>
                                <input type="text" class="form-control shadow-none" id="exampleInputEmail1" aria-describedby="emailHelp">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-2">
                                <label for="exampleInputEmail1" class="form-label">Last Name</label>
                                <input type="text" class="form-control shadow-none" id="exampleInputEmail1" aria-describedby="emailHelp">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-2">
                                <label for="exampleInputEmail1" class="form-label">Birthday</label>
                                <input type="date" class="form-control shadow-none" id="exampleInputEmail1" aria-describedby="emailHelp">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-2">
                                <label for="exampleInputEmail1" class="form-label">Gender</label>
                                <select class="form-select shadow-none" aria-label="Default select example">
                                    <option selected>Open this select menu</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-2">
                                <label for="exampleInputEmail1" class="form-label">Civil Status</label>
                                <select class="form-select shadow-none" aria-label="Default select example">
                                    <option selected>Open this select menu</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-2">
                                <label for="exampleInputEmail1" class="form-label">Educational Attainment</label>
                                <select class="form-select shadow-none" aria-label="Default select example">
                                    <option selected>Open this select menu</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="mt-5 p-4 border">
                    <legend class="w-auto float-none">Contact Information</legend>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="exampleInputEmail1" class="form-label">House/Unit No.*</label>
                            <input type="text" class="form-control shadow-none" id="exampleInputEmail1" placeholder="house/unit no.">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="exampleInputEmail1" class="form-label">Street/Bldg.*</label>
                            <input type="text" class="form-control shadow-none" id="exampleInputEmail1" placeholder="street bldg.">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="region" class="form-label">Region*</label>
                            <select class="form-select shadow-none" id="region" name="region"></select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div id="regionInvalidFeedback" class="invalid-feedback">
                                Please Select Region...
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="exampleInputEmail1" class="form-label">Province*</label>
                            <select class="form-select shadow-none" id="province" name="province"></select>

                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="exampleInputEmail1" class="form-label">Municipality/City*</label>
                            <select class="form-select shadow-none" id="city" name="city"></select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="exampleInputEmail1" class="form-label">Barangay*</label>
                            <select class="form-select shadow-none" id="barangay" name="barangay"></select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="empPhoneNumber" class="form-label">Phone Number*</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">+63</span>
                                <input type="text" class="form-control shadow-none" id="empPhoneNumber" maxlength="10" placeholder="phonenumber" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div id="empPhoneNumberInvalidFeedback" class="invalid-feedback">
                                    Please input phone number
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email Address*</label>
                            <input type="text" class="form-control shadow-none" id="exampleInputEmail1" placeholder="zipcode" pattern="[0-9]*" maxlength="4">
                        </div>
                    </div>
                </fieldset>
                <div class="d-flex justify-content-center flex-row mt-5" >
                    <p class="alert alert-danger p-3 w-50 text-center" style="display: none;">Hello</p>
                </div>
            </div>
            <div class="text-center mt-5 no-printme">
                <?php
                if (isset($_GET['action'])) {
                    if ($_GET['action'] === "adding") {
                        echo '<button class="btn btn-lg shadow-none rippleButton ripple no-printme me-3" id="empSubmit">SUBMIT</button>';
                        echo  '<button class="btn btn-lg shadow-none rippleButton ripple no-printme ms-3">CANCEL</button>';
                    } 
                    else {
                        echo '<button class="btn btn-lg shadow-none rippleButton ripple no-printme mx-2" onclick="window.print();">Print</button>';
                        echo '<button class="btn btn-lg shadow-none rippleButton ripple no-printme mx-2" id="empSubmit">SUBMIT</button>';
                        echo  '<button class="btn btn-lg shadow-none rippleButton ripple no-printme mx-2">CANCEL</button>';
                    }
                }
                ?>

            </div>
            <input type="hidden" id="hiddenProvince"></input>
            <input type="hidden" id="hiddenCity"></input>
            <input type="hidden" id="hiddenBarangay"></input>
        </div>
    </div>

</div>

<?php require_once 'footer.php' ?>
<script src="https://f001.backblazeb2.com/file/buonzz-assets/jquery.ph-locations-v1.0.0.js"></script>
<script>
    $(document).ready(function() {

        $(document).on('click', '#empSubmit', function() {
            alert($('#hiddenProvince').val());
        });



        var my_handlers = {

            fill_provinces: function() {

                var region_code = $(this).val();
                $('#province').ph_locations('fetch_list', [{
                    "region_code": region_code

                }]);

            },

            fill_cities: function() {

                var province_code = $(this).val();
                $('#city').ph_locations('fetch_list', [{
                    "province_code": province_code
                }]);
                let selected_caption = $("#province option:selected").text();

                // the hidden field will contain the name of the region, not the code
                $('#hiddenProvince').val(selected_caption);

            },


            fill_barangays: function() {

                var city_code = $(this).val();
                $('#barangay').ph_locations('fetch_list', [{
                    "city_code": city_code
                }]);

                let selected_caption = $("#city option:selected").text();
                $('#hiddenCity').val(selected_caption)
            }
        };

        $(function() {
            $('#region').on('change', my_handlers.fill_provinces);
            $('#province').on('change', my_handlers.fill_cities);
            $('#city').on('change', my_handlers.fill_barangays);

            $('#region').ph_locations({
                'location_type': 'regions'
            });
            $('#province').ph_locations({
                'location_type': 'provinces'
            });
            $('#city').ph_locations({
                'location_type': 'cities'
            });
            $('#barangay').ph_locations({
                'location_type': 'barangays'
            });

            $('#region').ph_locations('fetch_list');
        });

        $(function() {

            $('#barangay').on('change', function() {

                // we are getting the text() here, not val()
                var selected_caption = $("#barangay option:selected").text();

                // the hidden field will contain the name of the region, not the code
                $('#hiddenBarangay').val(selected_caption);

            }).ph_locations('fetch_list');

        });

        $(document).on('keyup', '#empFirstName', function() {
            if (!$(this).val() || $(this).val() === "") {
                $(this).removeClass('is-valid');
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
                $(this).addClass('is-valid');
            }
        });
        $(document).on('change', '#region', function() {
            $(this).removeClass('is-invalid');
            $(this).addClass('is-valid');
        });

        $(document).on('keyup', '#empPhoneNumber', function() {
            if (!$(this).val() || $(this).val() === "") {
                $(this).removeClass('is-valid');
                $(this).addClass('is-invalid');
            } else {
                // '&empPhoneNumber='
                let datastring = "empPhoneNumber=" + $('#empPhoneNumber').val();
                console.log(datastring)
                $.ajax({
                    url: 'includes/employee-add.inc.php',
                    type: 'POST',
                    data: datastring,
                    dataType: 'json',
                    success: function(data) {
                        if (data.status) {
                            $('#empPhoneNumber').removeClass('is-invalid');
                            $('#empPhoneNumber').addClass('is-valid');
                        } else {
                            $('#empPhoneNumber').removeClass('is-valid');
                            $('#empPhoneNumber').addClass('is-invalid');
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