<?php require_once 'head.php' ?>
<?php

if (isset($_GET['rowId'])) {
    $data = getEmployeeDataTable($conn, $_GET['rowId']);
    $generate = $data['emp_number'];
    $firstName = $data['emp_firstname'];
    $middleName = $data['emp_middlename'];
    $lastName = $data['emp_lastname'];
    $birthday = $data['emp_birthday'];
    $gender = $data['emp_gender'];
    $civilStatus = $data['emp_civilstatus'];
    $education = $data['emp_education'];
    $email = $data['emp_email'];
    $phoneNumber = substr($data['emp_phonenumber'], 1);
    $unit = $data['address_unit'];
    $street = $data['address_street'];
    $barangay = $data['address_barangay'];
    $city = $data['address_city'];
    $province = $data['address_province'];
    $picPath = $data['emp_picpath'];
    $checker = "row";
} else {
    $generate = GenerateKey($conn, 'SELECT * FROM employee_table;', 'EMP-', 'emp_number');
    $firstName = "";
    $middleName = "";
    $lastName = "";
    $birthday = "";
    $gender = "";
    $civilStatus = "";
    $education = "";
    $email = "";
    $phoneNumber = "";
    $unit = "";
    $street = "";
    $barangay = "";
    $city = "";
    $province = "";
    $defPath = "assets/admin-img/blank.png";
    $checker = "";
}

?>
<style>
    .imageWrapper {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
    }

    .imageWrapper img {
        width: 23%;
        height: 100%;
    }
</style>

<div class="row p-3">
    <div class="d-flex justify-content-center align-items-start flex-row" style="position: relative;display:none; "><?php require_once 'loader.php' ?></div>
    <div class="mx-auto shadow p-5 my-5 bg-white rounded justify-content-center">
        <div class="text-start">
            <h5 class="display-4  mt-3 no-printme">Add Employee</h5>
        </div>
        <div class="mb-5 no-printme">
            &nbsp;
        </div>
        <div class="mb-5 no-printme">
            &nbsp;
        </div>
        <div class="border p-5 mt-5 position-relative">
            <form action="includes/upload.inc.php" method="post" id="picupload" class="a-form" enctype="multipart/form-data">
                <div class="position-absolute top-0 start-50 translate-middle d-flex flex-row justify-content-center ">
                    <div class="imageWrapper">
                        <img src="<?= isset($_GET['rowId']) ?  $picPath : $defPath ?>" class="rounded-circle shadow printmeImg " id="imagesrc" alt="profile picture">
                        <?php
                        if (!isset($_GET['rowId'])) {
                            echo '<label for="files" class="alert alert-info m-0 p-0 w-25 text-center mt-3 no-printme" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Set Profile Picture"><i class="fas fa-upload"></i> UPLOAD</label>
                                <input type="file" class="form-control form-control-sm mt-3 shadow-none visually-hidden uploadfile" id="files" name="uploadfile">';
                        }
                        ?>
                    </div>
                </div>
            </form>
            <div class="row mt-3 no-printme">
                &nbsp;
            </div>
            <div class="printme">
                <fieldset class="mt-5 p-4 border">
                    <legend class="w-auto float-none">Personal Information</legend>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="mb-4">
                                <label for="empNumber" class="form-label">Employee Number</label>
                                <input type="text" class="form-control shadow-none" id="empNumber" value="<?= $generate ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-2">
                                <label for="empFirstName" class="form-label">First Name*</label>
                                <input type="text" class="form-control shadow-none" id="empFirstName" value="<?= $firstName ?>" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div id="empFirstNameInvalidFeedback" class="invalid-feedback">
                                    Please input first name....
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-2">
                                <label for="empMiddleName" class="form-label">Middle Name*</label>
                                <input type="text" class="form-control shadow-none" id="empMiddleName" value="<?= $middleName ?>" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div id="empMiddleNameInvalidFeedback" class="invalid-feedback">
                                    Please input middle name....
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-2">
                                <label for="empLastName" class="form-label">Last Name*</label>
                                <input type="text" class="form-control shadow-none" id="empLastName" value="<?= $lastName ?>" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div id="empLastNameInvalidFeedback" class="invalid-feedback">
                                    Please input last name....
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="mb-2">
                                <label for="empBirthday" class="form-label">Birthday*</label>
                                <input type="date" class="form-control shadow-none" value="<?= $birthday ?>" id="empBirthday">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div id="empBirthdayInvalidFeedback" class="invalid-feedback">
                                    Please input birthday....
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="mb-2">
                                <label for="empAge" class="form-label">Age*</label>
                                <input type="text" class="form-control shadow-none" id="empAge" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-2">
                                <label for="empGender" class="form-label">Gender*</label>
                                <select class="form-select shadow-none" id="empGender">
                                    <option value="" <?= $gender == "" ? "selected" : '' ?>>---Select Gender---</option>
                                    <option value="male" <?= $gender == "male" ? "selected" : '' ?>>Male</option>
                                    <option value="female" <?= $gender == "female" ? "selected" : '' ?>>Female</option>
                                    <option value="binary" <?= $gender == "binary" ? "selected" : '' ?>>Binary</option>
                                </select>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div id="empGenderInvalidFeedback" class="invalid-feedback">
                                    Please input gender....
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-2">
                                <label for="empCivilStatus" class="form-label">Civil Status*</label>
                                <select class="form-select shadow-none" id="empCivilStatus">
                                    <option value="" <?= $civilStatus == "" ? "selected" : '' ?>>---Select Civil Status---</option>
                                    <option value="single" <?= $civilStatus == "single" ? "selected" : '' ?>>Single</option>
                                    <option value="married" <?= $civilStatus == "married" ? "selected" : '' ?>>Married</option>
                                    <option value="widowed" <?= $civilStatus == "widowed" ? "selected" : '' ?>>Widowed</option>
                                    <option value="divorce" <?= $civilStatus == "divorce" ? "selected" : '' ?>>Divorce</option>
                                </select>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div id="empCivilStatusInvalidFeedback" class="invalid-feedback">
                                    Please input civil status....
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-2">
                                <label for="empEducation" class="form-label">Educational Attainment*</label>
                                <select class="form-select shadow-none" id="empEducation">
                                    <option value="" <?= $education == "" ? "selected" : '' ?>>---Select---</option>
                                    <option value="elementary" <?= $education == "elementary" ? "selected" : '' ?>>Elementary</option>
                                    <option value="highschool" <?= $education == "highschool" ? "selected" : '' ?>>High School Graduate</option>
                                    <option value="college grad" <?= $education == "college grad" ? "selected" : '' ?>>College Graduate</option>
                                    <option value="college undergrad" <?= $education == "college undergrad" ? "selected" : '' ?>>College UnderGrad</option>
                                    <option value="masteral" <?= $education == "masteral" ? "selected" : '' ?>>Masteral</option>
                                </select>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div id="empEducationInvalidFeedback" class="invalid-feedback">
                                    Please input educational attainment....
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="mt-5 p-4 border">
                    <legend class="w-auto float-none">Contact Information</legend>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="empUnit" class="form-label">House/Unit No.*</label>
                            <input type="text" class="form-control shadow-none" value="<?= $unit ?>" id="empUnit" placeholder="house/unit no." onkeypress="return /^[a-zA-Z\s0-9.,-]*$/.test(event.key)">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div id="empUnitInvalidFeedback" class="invalid-feedback">
                                Please input house/unit no...
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="empStreet" class="form-label">Street/Bldg.*</label>
                            <input type="text" class="form-control shadow-none" value="<?= $street ?>" id="empStreet" placeholder="street bldg." onkeypress="return /^[a-zA-Z\s0-9.,-]*$/.test(event.key)">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div id="empStreetInvalidFeedback" class="invalid-feedback">
                                Please input street/bldg...
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="empProvince" class="form-label">Province*</label>
                            <input type="text" class="form-control shadow-none" value="<?= $province ?>" id="empProvince" placeholder="province" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div id="empProvinceInvalidFeedback" class="invalid-feedback">
                                Please input province...
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="empCity" class="form-label">Municipality/City*</label>
                            <input type="text" class="form-control shadow-none" value="<?= $city ?>" id="empCity" placeholder="municipality/city" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div id="empCityInvalidFeedback" class="invalid-feedback">
                                Please input municipality/city...
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="empBarangay" class="form-label">Barangay*</label>
                            <input type="text" class="form-control shadow-none" value="<?= $barangay ?>" id="empBarangay" placeholder="barangay" onkeypress="return /^[a-zA-Z\s0-9]*$/.test(event.key)">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div id="empBarangayInvalidFeedback" class="invalid-feedback">
                                Please input barangay...
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="empPhoneNumber" class="form-label">Phone Number*</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">+63</span>

                                <?php
                                if (isset($_GET['rowId'])) {
                                    echo '<input type="text" class="form-control shadow-none" value="' . $phoneNumber . '" id="empUpdatePhoneNumber" maxlength="10" placeholder="phonenumber" required onkeypress="return /^[0-9]*$/.test(event.key)">';
                                } else {
                                    echo '<input type="text" class="form-control shadow-none" value="' . $phoneNumber . '" id="empPhoneNumber" maxlength="10" placeholder="phonenumber" required onkeypress="return /^[0-9]*$/.test(event.key)">';
                                }

                                ?>

                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div id="empPhoneNumberInvalidFeedback" class="invalid-feedback">
                                    Please input phone number
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="empEmail" class="form-label">Email Address</label>
                            <?php
                            if (isset($_GET['rowId'])) {
                                echo '<input type="email" class="form-control shadow-none" value="' . $email . '" id="empUpdateEmail" placeholder="email address" >';
                            } else {
                                echo '<input type="email" class="form-control shadow-none" value="' . $email . '" id="empEmail" placeholder="email address" >';
                            }

                            ?>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div id="empEmailInvalidFeedback" class="invalid-feedback">
                                Please input email...
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" id="empPicPath">
                            <input type="hidden" id="empChecker" value="<?= $checker ?>">
                            <?php
                            if (isset($_GET['rowId'])) {
                                echo '<input type="hidden" id="empLastPhoneNumber" value="' . $phoneNumber . '">';
                                echo '<input type="hidden" id="empLastEmail" value="' . $email . '">';
                            }
                            ?>
                        </div>
                    </div>
                </fieldset>
                <div class="d-flex justify-content-center flex-row mt-5">
                    <p class="alert alert-danger p-3 w-50 text-center" id="errorBox" style="display: none;"><i class="fas fa-times-circle"></i> </p>
                    <p class="alert alert-success p-3 w-50 text-center" id="successBox" style="display: none;"><i class="fas fa-check-circle"></i> Submission Success!</p>
                </div>
            </div>
            <div class="text-center mt-5 no-printme">
                <?php
                if (isset($_GET['rowId'])) {
                    echo '<button class="btn btn-lg shadow-none rippleButton ripple no-printme mx-2" onclick="window.print();">Print</button>';
                    echo '<button class="btn btn-lg shadow-none rippleButton ripple no-printme mx-2" data-bs-toggle="modal" data-bs-target="#empModal" id="btnEmpUpdate" data-backdrop="false">UPDATE</button>';
                } else {
                    echo '<button class="btn btn-lg shadow-none rippleButton ripple no-printme me-3"  data-bs-toggle="modal" data-bs-target="#empModal" id= "btnEmpSubmit" data-backdrop="false">SUBMIT</button>';
                }
                ?>

            </div>


            <!-- Modal -->
            <div class="modal fade" id="empModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confirmation <i class="fas fa-question-circle link-warning"></i></h5>
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to submit?
                        </div>
                        <div class="modal-footer">
                            <?php

                            if (isset($_GET['rowId'])) {
                                echo '<button type="button" class="btn shadow-none rippleButton ripple" id="empUpdate">Save changes</button>';
                            } else {
                                echo '<button type="button" class="btn shadow-none rippleButton ripple" id="empSubmit">Save changes</button>';
                            }

                            ?>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

</div>

<?php require_once 'footer.php' ?>
<script>
    $(document).ready(function() {

        $(window).on('load', function() {
            if ($('#empChecker').val() === "row") {
                var x = new Date($("#empBirthday").val());
                var Cnow = new Date();
                $('#empAge').val(Cnow.getFullYear() - x.getFullYear());
            }
        });

        $('.uploadfile').change(function(e) {
            var formData = new FormData($('#picupload')[0]);
            //codes in AJAX for uploading of picture
            $.ajax({
                type: 'POST',
                url: 'upload.inc.php',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                error: function(data) {
                    console.log(data)
                },
                success: function(result) {
                    if (result.ok) {
                        $('#imagesrc').attr("src", result.temp_path);
                        $('#empPicPath').val(result.temp_path);
                        console.log(result.temp_path);
                    } else {
                        if (result.error == "file_type") {
                            alert('Upload valid images. Only PNG and JPEG are allowed.')
                        } else if (result.error == "file_size") {
                            alert('Image size exceeds 2MB');
                        } else if (result.error == "file_dimension") {
                            alert('Image dimension should be within 2048 X 1600');
                        } else {
                            alert('Error encountered while trying to upload the picture!');
                        }
                    }
                }
            });
            return false;
        });

        $(document).on('click', '#empSubmit', function() {
            $('input').not('#empPicPath, #files , #empChecker').each(function() {
                if ($(this).val().trim() === "") {
                    $(this).removeClass("is-valid");
                    $(this).addClass("is-invalid");

                }
            });
            $('select').each(function() {
                if ($(this).val().trim() == "") {
                    $(this).removeClass("is-valid");
                    $(this).addClass("is-invalid");
                }
            });
            if ($('#empPicPath').val() == "") {
                $('#errorBox').html('Please upload profile image...');
                $('#errorBox').show();
                $('#empModal').modal('hide');
            } else {
                if ($('.is-invalid')[0]) {
                    $('#empModal').modal('hide');
                    $('#errorBox').hide();
                } else {
                    let datastring = {
                        'empNumber': $('#empNumber').val(),
                        'empFirstName': $('#empFirstName').val(),
                        'empMiddleName': $('#empMiddleName').val(),
                        'empLastName': $('#empLastName').val(),
                        'empBirthday': $('#empBirthday').val(),
                        'empGender': $('#empGender').val(),
                        'empCivilStatus': $('#empCivilStatus').val(),
                        'empEducation': $('#empEducation').val(),
                        'empUnit': $('#empUnit').val(),
                        'empStreet': $('#empStreet').val(),
                        'empProvince': $('#empProvince').val(),
                        'empCity': $('#empCity').val(),
                        'empBarangay': $('#empBarangay').val(),
                        'empPhoneNumber': $('#empPhoneNumber').val(),
                        'empEmail': $('#empEmail').val(),
                        'empPicPath': $('#empPicPath').val(),
                        'btnSubmit': $('#empSubmit').val()

                    };
                    console.log(datastring)
                    $.ajax({
                        url: 'includes/employee-add.inc.php',
                        type: 'POST',
                        data: datastring,
                        dataType: 'json',
                        error: function(error) {
                            console.log(error)
                        },
                        success: function(data) {
                            if (data.status) {
                                $('#errorBox').hide();
                                $('buttons').prop('disabled', true);
                                $('input').prop('disabled', true);
                                $('#successBox').show();
                                $('#btnEmpSubmit').html("<span class='spinner-border spinner-border-sm ' id = 'loading' role='status' aria-hidden='true'></span>");
                                $('#empModal').modal('hide');
                                window.setTimeout(function() {
                                    window.location.href = 'employee-list.php';
                                }, 2000);
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
            }


        });

        $(document).on('click', '#empUpdate', function() {
            $('#empUpdate').prop('disabled',true);
            $('input').not('#empPicPath, #files , #empChecker, #empLastEmail, #empLastPhoneNumber').each(function() {
                if ($(this).val().trim() === "") {
                    $(this).removeClass("is-valid");
                    $(this).addClass("is-invalid");

                }
            });
            $('select').each(function() {
                if ($(this).val().trim() == "") {
                    $(this).removeClass("is-valid");
                    $(this).addClass("is-invalid");
                }
            });
            if ($('.is-invalid')[0]) {
                $('#empUpdate').prop('disabled',false);
                $('#empModal').modal('hide');
                $('#errorBox').hide();
            } else {
                let datastring = {
                    'empNumber': $('#empNumber').val(),
                    'empFirstName': $('#empFirstName').val(),
                    'empMiddleName': $('#empMiddleName').val(),
                    'empLastName': $('#empLastName').val(),
                    'empBirthday': $('#empBirthday').val(),
                    'empGender': $('#empGender').val(),
                    'empCivilStatus': $('#empCivilStatus').val(),
                    'empEducation': $('#empEducation').val(),
                    'empUnit': $('#empUnit').val(),
                    'empStreet': $('#empStreet').val(),
                    'empProvince': $('#empProvince').val(),
                    'empCity': $('#empCity').val(),
                    'empBarangay': $('#empBarangay').val(),
                    'empPhoneNumber': $('#empUpdatePhoneNumber').val(),
                    'empEmail': $('#empUpdateEmail').val(),
                    'btnUpdate': $('#empUpdate').val()

                };
                console.log(datastring)
                $.ajax({
                    url: 'includes/employee-add.inc.php',
                    type: 'POST',
                    data: datastring,
                    dataType: 'json',
                    error: function(error) {
                        console.log(error)
                    },
                    success: function(data) {
                        if (data.status) {
                            $('#errorBox').hide();
                            $('buttons').prop('disabled', true);
                            $('input').prop('disabled', true);
                            $('#successBox').show();
                            $('#btnEmpUpdate').html("<span class='spinner-border spinner-border-sm ' id = 'loading' role='status' aria-hidden='true'></span>");
                            $('#empModal').modal('hide');
                            window.setTimeout(function() {
                                window.location.href = 'employee-list.php';
                            }, 2000);
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

        $(document).on('keyup', '#empFirstName', function() {
            if ($(this).val().trim() == "" || !$(this).val()) {
                $(this).removeClass("is-valid").addClass("is-invalid");
            } else {
                $(this).removeClass("is-invalid").addClass("is-valid");
            }
        });
        $(document).on('keyup', '#empMiddleName', function() {
            if ($(this).val().trim() == "" || !$(this).val()) {
                $(this).removeClass("is-valid").addClass("is-invalid");
            } else {
                $(this).removeClass("is-invalid").addClass("is-valid");
            }
        });
        $(document).on('keyup', '#empLastName', function() {
            if ($(this).val().trim() == "" || !$(this).val()) {
                $(this).removeClass("is-valid").addClass("is-invalid");
            } else {
                $(this).removeClass("is-invalid").addClass("is-valid");
            }
        });
        $(document).on('change', '#empGender', function() {
            if ($(this).val().trim() == "" || !$(this).val()) {
                $(this).removeClass("is-valid").addClass("is-invalid");
            } else {
                $(this).removeClass("is-invalid").addClass("is-valid");
            }
        });
        $(document).on('change', '#empCivilStatus', function() {
            if ($(this).val().trim() == "" || !$(this).val()) {
                $(this).removeClass("is-valid").addClass("is-invalid");
            } else {
                $(this).removeClass("is-invalid").addClass("is-valid");
            }
        });
        $(document).on('change', '#empEducation', function() {
            if ($(this).val().trim() == "" || !$(this).val()) {
                $(this).removeClass("is-valid").addClass("is-invalid");
            } else {
                $(this).removeClass("is-invalid").addClass("is-valid");
            }
        });
        $(document).on('keyup', '#empUnit', function() {
            if ($(this).val().trim() == "" || !$(this).val()) {
                $(this).removeClass("is-valid").addClass("is-invalid");
            } else {
                $(this).removeClass("is-invalid").addClass("is-valid");
            }
        });
        $(document).on('keyup', '#empStreet', function() {
            if ($(this).val().trim() == "" || !$(this).val()) {
                $(this).removeClass("is-valid").addClass("is-invalid");
            } else {
                $(this).removeClass("is-invalid").addClass("is-valid");
            }
        });
        $(document).on('keyup', '#empProvince', function() {
            if ($(this).val().trim() == "" || !$(this).val()) {
                $(this).removeClass("is-valid").addClass("is-invalid");
            } else {
                $(this).removeClass("is-invalid").addClass("is-valid");
            }
        });
        $(document).on('keyup', '#empCity', function() {
            if ($(this).val().trim() == "" || !$(this).val()) {
                $(this).removeClass("is-valid").addClass("is-invalid");
            } else {
                $(this).removeClass("is-invalid").addClass("is-valid");
            }
        });
        $(document).on('keyup', '#empBarangay', function() {
            if ($(this).val().trim() == "" || !$(this).val()) {
                $(this).removeClass("is-valid").addClass("is-invalid");
            } else {
                $(this).removeClass("is-invalid").addClass("is-valid");
            }
        });


        $(document).on('keyup', '#empEmail', function() {
            if ($(this).val().trim() == "" || !$(this).val()) {
                $('#empEmailInvalidFeedback').text('Please input email address...');
                $(this).removeClass("is-valid").addClass("is-invalid");
            } else {

                let datastring = {
                    "validateEmail": "EmailTest",
                    "empEmail": $('#empEmail').val()
                }
                console.log(datastring)
                $.ajax({
                    url: 'includes/employee-add.inc.php',
                    type: 'POST',
                    data: datastring,
                    dataType: 'json',
                    error: function(error) {
                        console.log(error)
                    },
                    success: function(data) {
                        if (data.status) {
                            $('#empEmail').removeClass("is-invalid").addClass("is-valid");
                        } else {
                            if (data.message == "invalid") {
                                $('#empEmailInvalidFeedback').text('Please input valid email address...');
                                $('#empEmail').removeClass("is-valid").addClass("is-invalid");
                            } else {
                                $('#empEmailInvalidFeedback').text('Email already exist...');
                                $('#empEmail').removeClass("is-valid").addClass("is-invalid");
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
        $(document).on('keyup', '#empUpdateEmail', function() {
            if ($(this).val().trim() == "" || !$(this).val()) {
                $('#empEmailInvalidFeedback').text('Please input email address...');
                $(this).removeClass("is-valid").addClass("is-invalid");
            } else if ($('#empUpdateEmail').val() == $('#empLastEmail').val()) {
                $('#empUpdateEmail').removeClass("is-invalid").addClass("is-valid");
            } else {

                let datastring = {
                    "validateEmail": "EmailTest",
                    "empEmail": $('#empUpdateEmail').val()
                }
                console.log(datastring)
                $.ajax({
                    url: 'includes/employee-add.inc.php',
                    type: 'POST',
                    data: datastring,
                    dataType: 'json',
                    error: function(error) {
                        console.log(error)
                    },
                    success: function(data) {
                        if (data.status) {
                            $('#empUpdateEmail').removeClass("is-invalid").addClass("is-valid");
                        } else {
                            if (data.message == "invalid") {
                                $('#empEmailInvalidFeedback').text('Please input valid email address...');
                                $('#empUpdateEmail').removeClass("is-valid").addClass("is-invalid");
                            } else {
                                $('#empEmailInvalidFeedback').text('Email already exist...');
                                $('#empUpdateEmail').removeClass("is-valid").addClass("is-invalid");
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

        $(document).on('change', '#empBirthday', function() {
            var x = new Date($("#empBirthday").val());
            var Cnow = new Date();
            if ($("#empBirthday").val() == "" || !$('#empBirthday').val()) {
                $('#empAge').removeClass('is-valid').addClass('is-invalid');
                $('#empBirthday').removeClass('is-valid').addClass('is-invalid');
                $('#empBirthdayInvalidFeedback').text('Please input birthday...');
            } else if (Cnow.getFullYear() - x.getFullYear() < 18) {
                $('#empAge').removeClass('is-valid').addClass('is-invalid');
                $('#empBirthdayInvalidFeedback').text('Invalid Age...');
                $('#empBirthday').removeClass('is-valid').addClass('is-invalid');
            } else if (x.getFullYear() < 1950) {
                $('#empAge').removeClass('is-valid').addClass('is-invalid');
                $('#empBirthdayInvalidFeedback').text('Invalid Date...');
                $('#empBirthday').removeClass('is-valid').addClass('is-invalid');
            } else {
                $('#empAge').removeClass('is-invalid').addClass('is-valid');
                $('#empAge').val(Cnow.getFullYear() - x.getFullYear());
                $('#empBirthday').removeClass('is-invalid').addClass('is-valid');
            }
        });






        $(document).on('keyup', '#empPhoneNumber', function() {
            if (!$(this).val() || $(this).val().trim() === "") {
                $('#empPhoneNumberInvalidFeedback').text('Please input phone number...');
                $(this).removeClass('is-valid');
                $(this).addClass('is-invalid');
            } else {
                // '&empPhoneNumber='
                let datastring = {
                    "empPhoneNumber": $('#empPhoneNumber').val(),
                    "validatePhone": "test"
                };
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
                            if (data.message == "invalid") {
                                $('#empPhoneNumberInvalidFeedback').text('Invalid Phone Number...');

                            } else {
                                $('#empPhoneNumberInvalidFeedback').text('Phone Number already exist...');
                            }
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

        $(document).on('keyup', '#empUpdatePhoneNumber', function() {
            if (!$(this).val() || $(this).val().trim() === "") {
                $('#empPhoneNumberInvalidFeedback').text('Please input phone number...');
                $(this).removeClass('is-valid');
                $(this).addClass('is-invalid');
            } else if ($('#empUpdatePhoneNumber').val() == $('#empLastPhoneNumber').val()) {
                $('#empUpdatePhoneNumber').removeClass('is-invalid').addClass('is-valid');
            } else {
                // '&empPhoneNumber='
                let datastring = {
                    "empPhoneNumber": $('#empUpdatePhoneNumber').val(),
                    "validatePhone": "test"
                };
                console.log(datastring)
                $.ajax({
                    url: 'includes/employee-add.inc.php',
                    type: 'POST',
                    data: datastring,
                    dataType: 'json',
                    success: function(data) {
                        if (data.status) {
                            $('#empUpdatePhoneNumber').removeClass('is-invalid');
                            $('#empUpdatePhoneNumber').addClass('is-valid');
                        } else {
                            if (data.message == "invalid") {
                                $('#empPhoneNumberInvalidFeedback').text('Invalid Phone Number...');

                            } else {
                                $('#empPhoneNumberInvalidFeedback').text('Phone Number already exist...');
                            }
                            $('#empUpdatePhoneNumber').removeClass('is-valid');
                            $('#empUpdatePhoneNumber').addClass('is-invalid');
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