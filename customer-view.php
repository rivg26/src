<?php require_once 'head.php' ?>
<?php
if (isset($_GET['rowId'])) {
    $data =  getCustomerData($conn, $_GET['rowId']);
    $generate = $data['customer_number'];
    $firstName = $data['customer_first_name'];
    $middleName = $data['customer_middle_name'];
    $lastName = $data['customer_last_name'];
    $phoneNumber = substr($data['customer_phone_number'], 1);
    $customerUnit = $data['cus_address_unit'];
    $customerStreet = $data['cus_address_street'];
    $customerBarangay = $data['cus_address_barangay'];
    $customerCity = $data['cus_address_city'];
    $customerProvince = $data['cus_address_province'];
    $customerLandmark = $data['cus_address_landmark'];
    $customerFullAdress = $data['cus_address_unit'] . ' ' . $data['cus_address_street'] . ' ' . $data['cus_address_barangay'] . ' '. $data['cus_address_city'] . ' '. $data['cus_address_province'];
} else {
    $generate = GenerateKey($conn, 'SELECT * FROM `customer_table`;', 'CUS-', 'customer_number');
    $firstName = "";
    $middleName =  "";
    $lastName = "";
    $phoneNumber = "";
    $customerUnit = "";
    $customerStreet = "";
    $customerBarangay = "";
    $customerCity = "";
    $customerProvince = "";
    $customerLandmark = "";
    $customerFullAdress  = "";
}

?>
<div class="container" style="position: relative;">

    <div class="row shadow p-5 mb-4 bg-body rounded  mt-3">
        <div class="text-center">
            <h5 class="display-4 mb-5 mt-3 no-printme">Add Customer</h5>
        </div>

        <fieldset class="border mt-5 p-5  g-5 bg-light">
            <legend class="float-none w-auto">Personal Information</legend>
            <div class="row">
                <div class="col-md-5 mb-3">
                    <label for="customerFirstName" class="form-label">First Name*</label>
                    <input type="text" class="form-control shadow-none" id="customerFirstName" placeholder="first name" value="<?= $firstName ?>" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div id="customerFirstNameFeedback" class="invalid-feedback">
                        Please input First Name....
                    </div>
                </div>
                <div class="col-md-5 mb-3">
                    <label for="customerLastName" class="form-label">Last Name*</label>
                    <input type="text" class="form-control shadow-none" id="customerLastName" placeholder="last name" value="<?= $lastName ?>"  onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div id="customerLastNameFeedback" class="invalid-feedback">
                        Please input Last Name....
                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="customerMiddleName" class="form-label">Middle Initial*</label>
                    <input type="text" class="form-control shadow-none" id="customerMiddleName" placeholder="M.I." maxlength="3" value="<?= $middleName ?>"  onkeypress="return /^[a-zA-Z\s.]*$/.test(event.key)" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div id="customerMiddleNameFeedback" class="invalid-feedback">
                        Please input Middle Initial....
                    </div>
                </div>
            </div>
            <div class="row mb-3 d-flex flex-row justify-content-between">
                <div class="col-md-3">
                    <label for="customerPhoneNumber" class="form-label">Phone Number*</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text">+63</span>
                        
                        <?php
                            if(isset($_GET['rowId'])){
                                echo '<input type="text" class="form-control shadow-none" id="customerPhoneNumberUpdate" maxlength="10" value="'.$phoneNumber.'" onkeypress="return /^[0-9]*$/.test(event.key)" required>
                                    <input type="hidden" name="" id="customerPhoneNumberComparison" value="'.$phoneNumber.'" >';
                            }
                            else{
                                echo '<input type="text" class="form-control shadow-none" id="customerPhoneNumber" maxlength="10" onkeypress="return /^[0-9]*$/.test(event.key)" required>';
                            }
                        ?>
                        
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div id="customerPhoneNumberFeedback" class="invalid-feedback">
                            Please input Phone Number....
                        </div>
                    </div>


                </div>
                <div class="col-md-3">
                    <label for="pinInvoice" class="form-label">Customer Number</label>
                    <input type="text" class="form-control shadow-none" id="customerNumber" value="<?= $generate ?>" readonly>
                </div>
            </div>
        </fieldset>

        <fieldset class="border mt-5 p-5  g-5 bg-light">
            <legend class="float-none w-auto">Address</legend>
            <div class="row mb-3">
                <div class="col-md-6 mb-3">
                    <label for="customerUnit" class="form-label">House/Unit No.*</label>
                    <input type="text" class="form-control shadow-none" id="customerUnit" placeholder="house/unit no." value="<?= $customerUnit ?>"  onkeypress="return /^[a-zA-Z\s0-9.,-]*$/.test(event.key)" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div id="customerUnitFeedback" class="invalid-feedback">
                        Please input House/Unit No....
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="customerStreet" class="form-label">Street/Bldg.*</label>
                    <input type="text" class="form-control shadow-none" id="customerStreet" placeholder="street bldg." value="<?= $customerStreet ?>"  onkeypress="return /^[a-zA-Z\s0-9.,-]*$/.test(event.key)" required>
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
                    <input type="text" class="form-control shadow-none" id="customerBarangay" placeholder="barangay" value="<?= $customerBarangay ?>"  onkeypress="return /^[a-zA-Z\s0-9]*$/.test(event.key)" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div id="customerBarangayFeedback" class="invalid-feedback">
                        Please input Barangay...
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="customerCity" class="form-label">Municipality/City*</label>
                    <input type="text" class="form-control shadow-none" id="customerCity" placeholder="municipality/city" value="<?= $customerCity ?>"  onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div id="customerCityFeedback" class="invalid-feedback">
                        Please input Municipality/City...
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="customerProvince" class="form-label">Province*</label>
                    <input type="text" class="form-control shadow-none" id="customerProvince" placeholder="province" value="<?= $customerProvince ?>"  onkeypress="return /^[a-zA-Z\s]*$/.test(event.key)" required>
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
                    <textarea class="form-control shadow-none" placeholder="landmark" id="customerLandmark" style="height: 100px" onkeypress="return /^[a-zA-Z\s0-9.,()]*$/.test(event.key)"><?= $customerLandmark ?></textarea>
                </div>
            </div>
        </fieldset>
        
        <fieldset class="border mt-5 p-5  g-5 bg-light no-printme">
        <legend class="float-none w-auto">Purchase History</legend>

            <table id="customerHistoryTable" class="tableDesign table table-striped table-hover align-middle shadow-none">
                <thead class="align-middle">
                    <tr>
                        <th>Purchase Date</th>
                        <th>Sales Invoice</th>
                        <th>Customer Name</th>
                        <th>Total Quantity</th>
                        <th>Total Amount</th>
                        <th>Payment Status</th>
                        <th>Encoder Name</th>
                    </tr>
                </thead>
                <tbody>
                  <?php echo isset($_GET['rowId'])? customerHistoryTable($conn,$_GET['rowId']) : ''; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Purchase Date</th>
                        <th>Sales Invoice</th>
                        <th>Customer Name</th>
                        <th>Total Quantity</th>
                        <th>Total Amount</th>
                        <th>Payment Status</th>
                        <th>Encoder Name</th>
                    </tr>
                </tfoot>
            </table>
        </fieldset>


        <div class="text-center mt-5 no-printme">
            <?php
                if(isset($_GET['rowId'])){
                    echo '<button type="button" class="btn btn-lg shadow-none rippleButton ripple" data-bs-toggle="modal" data-bs-target="#customerModal" id="btnCustomerUpdate">Update</button>
                        <button type="button" class="btn btn-lg shadow-none rippleButton ripple" id="btnLocation" row.location="'.$customerFullAdress.'">Location</button>
                        <button type="button" class="btn btn-lg shadow-none rippleButton ripple" id="btnLocation" onclick="window.print();">Print</button>';
                }
                else{
                    echo '<button type="button" class="btn btn-lg shadow-none rippleButton ripple" data-bs-toggle="modal" data-bs-target="#customerModal" id="btnCustomerSubmit">Submit</button>';
                }
            ?>
        </div>

        <div class="text-center alert alert-success mt-5" id="successBox" style="display: none;">
            <i class="fas fa-check-circle"></i> Submission Success!
        </div>

        <div class="modal fade" id="customerModal" tabindex="-1" aria-hidden="true">
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
                            if(isset($_GET['rowId'])){
                                echo '<button type="button" class="btn shadow-none rippleButton ripple" id="customerUpdate">Save changes</button>';
                            }
                            else{
                                echo '<button type="button" class="btn shadow-none rippleButton ripple" id="customerSubmit">Save changes</button>';
                            }

                        ?>
                        
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
        $('#customerHistoryTable').DataTable({
            "searching": true,
            "bPaginate": true,
            "lengthChange": true,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": true,
            lengthMenu: [5, 10, 25, 50, 100, 200],
            "columnDefs": [{
                    targets: [3,4],
                    className: "text-end"
                },
                {
                    targets: [1,6],
                    className: "text-justify"
                },
                {
                    targets: [0,2,5],
                    className: "text-center"
                },
            ]
            ,
            dom: 'B<"searchBar">frtip',
            buttons: [
                {
                    text: '<i class="fas fa-file-excel"></i>',
                    extend: 'excel',
                    title: 'Customer History Report_' + moment().format('MMMM Do YYYY, h:mm:ss a'),
                    className: 'btn-success me-3 shadow-none rounded',
                    titleAttr: 'EXCEL',
                    exportOptions: {
                        columns: ':visible',
                    }
                },
                {
                    text: '<i class="fas fa-file-pdf"></i>',
                    extend: 'pdf',
                    titleAttr: 'PDF',
                    orientation: 'portrait',
                    pageSize: 'LEGAL',
                    className: 'btn-danger me-3 shadow-none rounded',
                    filename: 'Customer History Report_' + moment().format('MMMM Do YYYY, h:mm:ss a'),
                    header: 'Customer History Report',
                    messageTop: 'Date: ' + moment().format('MMMM Do YYYY, h:mm:ss a'),
                    title: 'Customer History Report',
                    exportOptions: {
                        columns: ':visible',
                    }

                },
                {
                    text: '<i class="fas fa-print"></i>',
                    extend: 'print',
                    titleAttr: 'PRINT',
                    className: 'btn-info me-3 shadow-none rounded',
                    title: 'Customer History Report_' + moment().format('MMMM Do YYYY, h:mm:ss a'),
                    exportOptions: {
                        columns: ':visible',
                    }

                },
                {
                    extend: 'colvis',
                    className: 'btn-dark me-3 shadow-none rounded-3',
                    text: '<i class="fas fa-columns"></i>',
                    titleAttr: 'COLUMNS VISIBLITY'
                },
                {
                    extend: 'pageLength',
                    className: 'btn-dark shadow-none rounded-3',
                    text: '<i class="fas fa-ruler-vertical"></i>',
                    titleAttr: 'PAGE LENGTH'
                }
            ]
        });
        $(document).on('click' , '#customerUpdate', function(){
            $('#customerUpdate').prop('disabled', true);
            $('input').each(function() {
                if ($(this).val().trim() === "") {
                    $(this).removeClass("is-valid");
                    $(this).addClass("is-invalid");

                } else {
                    $(this).removeClass("is-invalid");
                    $(this).addClass("is-valid");
                }
            });
            if ($('.is-invalid')[0]) {
                $('#customerModal').modal('hide');
                $('#customerUpdate').prop('disabled', false);
            }
            else{
                let datastring = {
                    "customerUpdate": $('#customerUpdate').val(),
                    "customerFirstName": $('#customerFirstName').val(),
                    "customerLastName": $('#customerLastName').val(),
                    "customerMiddleName": $('#customerMiddleName').val(),
                    "customerPhoneNumber": $('#customerPhoneNumberUpdate').val(),
                    "customerUnit": $('#customerUnit').val(),
                    "customerStreet": $('#customerStreet').val(),
                    "customerBarangay": $('#customerBarangay').val(),
                    "customerCity": $('#customerCity').val(),
                    "customerProvince": $('#customerProvince').val(),
                    "customerLandmark": $('#customerLandmark').val(),
                    "customerNumber": $('#customerNumber').val()
                };
                $.ajax({
                    url: 'includes/customer-view.inc.php',
                    type: 'POST',
                    data: datastring,
                    dataType: 'json',
                    success: function(data) {
                        if (data.status) {
                            $('#customerModal').modal('hide');
                            $('#btnCustomerUpdate').prop('disable', true);
                            $('input').prop('disabled', true);
                            $('textarea').prop('disabled', true);
                            $('#btnCustomerUpdate').html("<span class='spinner-border spinner-border-sm ' id = 'loading' role='status' aria-hidden='true'></span>");
                            $('#successBox').show();
                            
                            window.setTimeout(function() {
                                window.location.href = 'customer-list.php';
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

        $(document).on('click', '#customerSubmit', function() {
            $('#customerSubmit').prop('disabled', true);
            $('input').each(function() {
                if ($(this).val().trim() === "") {
                    $(this).removeClass("is-valid");
                    $(this).addClass("is-invalid");

                } else {
                    $(this).removeClass("is-invalid");
                    $(this).addClass("is-valid");
                }
            });

            if ($('.is-invalid')[0]) {
                $('#customerModal').modal('hide');
                $('#customerSubmit').prop('disabled', false);
            } else {
                let datastring = {
                    "customerSubmit": $('#customerSubmit').val(),
                    "customerFirstName": $('#customerFirstName').val(),
                    "customerLastName": $('#customerLastName').val(),
                    "customerMiddleName": $('#customerMiddleName').val(),
                    "customerPhoneNumber": $('#customerPhoneNumber').val(),
                    "customerUnit": $('#customerUnit').val(),
                    "customerStreet": $('#customerStreet').val(),
                    "customerBarangay": $('#customerBarangay').val(),
                    "customerCity": $('#customerCity').val(),
                    "customerProvince": $('#customerProvince').val(),
                    "customerLandmark": $('#customerLandmark').val(),
                    "customerNumber": $('#customerNumber').val()
                };
                $.ajax({
                    url: 'includes/customer-view.inc.php',
                    type: 'POST',
                    data: datastring,
                    dataType: 'json',
                    success: function(data) {
                        if (data.status) {
                            $('#customerModal').modal('hide');
                            $('#btnCustomerSubmit').prop('disable', true);
                            $('input').prop('disabled', true);
                            $('textarea').prop('disabled', true);
                            $('#btnCustomerSubmit').html("<span class='spinner-border spinner-border-sm ' id = 'loading' role='status' aria-hidden='true'></span>");
                            $('#successBox').show();
                            
                            window.setTimeout(function() {
                                window.location.href = 'customer-list.php';
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
        $(document).on('click', '#btnLocation', function() {
            $location = $(this).attr('row.location');
            popupCenter({
                url: 'maps.php?location= ' + $location,
                title: 'Paredes Petron Location',
                w: 900,
                h: 500
            });
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
            if (!$(this).val().trim() || $(this).val().trim() === "") {
                $(this).removeClass('is-valid');
                $(this).addClass('is-invalid');
            } else {
                let datastring = {
                    "phoneNumber": $('#customerPhoneNumber').val(),
                    "sendPhoneNumber": "phoneSent"
                };

                $.ajax({
                    url: 'includes/customer-view.inc.php',
                    type: 'POST',
                    data: datastring,
                    dataType: 'json',
                    success: function(data) {
                        if (data.status) {
                            $('#customerPhoneNumber').removeClass('is-invalid');
                            $('#customerPhoneNumber').addClass('is-valid');
                        } 
                        else if (data.message){
                            $('#customerPhoneNumberFeedback').text('Phone Number Exist....');
                            $('#customerPhoneNumber').removeClass('is-valid');
                            $('#customerPhoneNumber').addClass('is-invalid');
                        }
                        else {
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
        $(document).on('keyup', '#customerPhoneNumberUpdate', function() {
            $('#customerPhoneNumberFeedback').text('Please input Phone Number....');
            if (!$(this).val() || $(this).val() === "") {
                $(this).removeClass('is-valid');
                $(this).addClass('is-invalid');
            } 
            else if($('#customerPhoneNumberUpdate').val() === $('#customerPhoneNumberComparison').val()){
                $(this).removeClass('is-invalid');
                $(this).addClass('is-valid');
            }
            else {
                let datastring = {
                    "phoneNumber": $('#customerPhoneNumberUpdate').val(),
                    "sendPhoneNumber": "phoneSent"
                };

                $.ajax({
                    url: 'includes/customer-view.inc.php',
                    type: 'POST',
                    data: datastring,
                    dataType: 'json',
                    success: function(data) {
                        if (data.status) {
                            $('#customerPhoneNumberUpdate').removeClass('is-invalid');
                            $('#customerPhoneNumberUpdate').addClass('is-valid');
                        } 
                        else if (data.message){
                            $('#customerPhoneNumberFeedback').text('Phone Number Exist....');
                            $('#customerPhoneNumberUpdate').removeClass('is-valid');
                            $('#customerPhoneNumberUpdate').addClass('is-invalid');
                        }
                        else {
                            $('#customerPhoneNumberFeedback').text('Invalid Phone Number....');
                            $('#customerPhoneNumberUpdate').removeClass('is-valid');
                            $('#customerPhoneNumberUpdate').addClass('is-invalid');
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
            if (!$(id).val().trim() || $(id).val().trim() === "") {
                $(id).removeClass('is-valid');
                $(id).addClass('is-invalid');
            } else {
                $(id).removeClass('is-invalid');
                $(id).addClass('is-valid');
            }
        }



    });
</script>