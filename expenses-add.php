<?php require_once 'head.php' ?>
<?php
if (isset($_GET['rowId'])) {
    $data = getExpensesData($conn,$_GET['rowId']);
    $generate = $data['expenses_invoice'];
    $date = $data['expenses_date'];
    $amount = $data['expenses_amount'];
    $category = $data['expenses_category'];
    $description = $data['expenses_description'];
    $empId = $data['expenses_employee_id'];
} else {
    $generate = GenerateKey($conn, 'SELECT * FROM expenses_table;', 'EXP-', 'expenses_invoice');
    $date = date('Y-m-d');
    $amount = "";
    $category = "";
    $description = "";
    $empId = "";
}
?>
<div class="container" style="position: relative;">
    <div class="mx-auto shadow p-5 my-5 bg-white rounded justify-content-center printme">
        <div class="text-center ">
            <h5 class=" display-4 mb-5">Add Expenses</h5>
        </div>

        <div class="row mt-5 mb-4 d-flex flex-row justify-content-between">
            <div class="col-md-3">
                <label for="expDate" class="form-label">Date</label>
                <input type="date" class="form-control shadow-none" id="expDate" value="<?= $date ?>" readonly>
            </div>
            <div class="col-md-3">
                <label for="expControl" class="form-label">Control No.</label>
                <input type="text" class="form-control shadow-none" id="expControl" value="<?= $generate ?>" readonly>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-4 mb-3">
                <label for="expName" class="form-label">Name</label>
                <select class="form-select shadow-none" id="expName">
                    <option value="" selected>---Select employee name---</option>
                    <?= expensesEmployeeSelect($conn,$empId); ?>
                </select>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div id="expNameFeedback" class="invalid-feedback">
                    Please select employee name...
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <label for="expAmount" class="form-label">Amount</label>
                <input type="number" class="form-control shadow-none" id="expAmount" value="<?= $amount ?>">
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div id="expAmountFeedback" class="invalid-feedback">
                    Please input amount...
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <label for="expCategory" class="form-label">Category</label>
                <input type="text" class="form-control shadow-none" id="expCategory" value="<?= $category ?>" onkeypress="return /^[a-zA-Z\s./,-:0-9]*$/.test(event.key)">
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div id="expCategoryFeedback" class="invalid-feedback">
                    Please input category...
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label for="expDescription" class="form-label">Description</label>
                <textarea class="form-control shadow-none" id="expDescription" rows="3"  onkeypress="return /^[a-zA-Z\s./,-:0-9]*$/.test(event.key)"><?= $description ?></textarea>
            </div>
        </div>

        <div class="text-center mt-5 no-printme">
            <?php
            if (isset($_GET['rowId'])) {
                echo '<button class="btn btn-lg shadow-none rippleButton ripple no-printme" onclick="window.print();">Print</button> ';
                echo ' <button class="btn btn-lg shadow-none rippleButton ripple no-printme" id="btnExpUpdate" data-bs-toggle="modal" data-bs-target="#expModal" data-backdrop="false">UPDATE</button>';
            } else {
                echo '<button class="btn btn-lg shadow-none rippleButton ripple no-printme" id="btnExpSubmit" data-bs-toggle="modal" data-bs-target="#expModal" data-backdrop="false">SUBMIT</button>';
            }
            ?>
        </div>

        <div class="text-center alert alert-success mt-5 mb-3" style="display: none;" id="successBox">
            <i class="fas fa-check-circle"></i> Submission Success!
        </div>

        <!-- Modal -->
        <div class="modal fade" id="expModal" tabindex="-1" aria-hidden="true">
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
                            echo '<button type="button" class="btn shadow-none rippleButton ripple" id="expUpdate">Save changes</button>';
                        } else {
                            echo '<button type="button" class="btn shadow-none rippleButton ripple" id="expSubmit">Save changes</button>';
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
        $(document).on('change', '#expName', function() {
            if (!$(this).val() || $(this).val().trim() === "") {
                $(this).removeClass('is-valid').addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid').addClass('is-valid');
            }
        });
        $(document).on('keyup', '#expCategory', function() {
            if (!$(this).val() || $(this).val().trim() === "") {
                $(this).removeClass('is-valid').addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid').addClass('is-valid');
            }
        });
        $(document).on('keyup', '#expAmount', function() {
            if (!$(this).val() || $(this).val().trim() === "") {
                $('#expAmountFeedback').text('Please input amount...');
                $(this).removeClass('is-valid').addClass('is-invalid');
            } else if (parseFloat($(this).val()) <= 0) {
                $('#expAmountFeedback').text('Invalid amount...');
                $(this).removeClass('is-valid').addClass('is-invalid');
            } else {
                $('#expAmountFeedback').text('Please input amount...');
                $(this).removeClass('is-invalid').addClass('is-valid');
            }
        });

        $(document).on('click', '#expSubmit', function() {
            $('#expSubmit').prop('disabled', true);
            $('input').each(function() {
                if ($(this).val().trim() === "") {
                    $(this).removeClass("is-valid").addClass("is-invalid");
                }
            });
            $('select').each(function() {
                if ($(this).val().trim() === "") {
                    $(this).removeClass("is-valid").addClass("is-invalid");
                }
            });

            if ($('.is-invalid')[0]) {
                $('#expModal').modal('hide');
                $('#expSubmit').prop('disabled', false);
            } else {
                let datastring = {
                    "expDate": $('#expDate').val(),
                    "expControl": $('#expControl').val(),
                    "expName": $('#expName').val(),
                    "expAmount": $('#expAmount').val(),
                    "expCategory": $('#expCategory').val(),
                    "expDescription": $('#expDescription').val(),
                    "btnSubmit": $('#expSubmit').val()
                };
                console.log(datastring);
                $.ajax({
                    url: 'includes/expenses-add.inc.php',
                    type: 'POST',
                    data: datastring,
                    dataType: 'json',
                    error: function(error) {
                        console.log(error);
                    },
                    success: function(data) {

                        if (data.status) {
                            $('input').prop('disabled', true);
                            $('#expSubmit').prop('disabled', true);
                            $('#btnExpSubmit').html("<span class='spinner-border spinner-border-sm ' id = 'loading' role='status' aria-hidden='true'></span>");
                            $('#successBox').show();
                            $('#expModal').modal('hide');
                            window.setTimeout(function() {
                                window.location.href = 'expenses-report.php';
                            }, 2000);
                        }

                    }

                });
            }
        });

        $(document).on('click', '#expUpdate', function() {
            $('#expSubmit').prop('disabled', true);
            $('input').each(function() {
                if ($(this).val().trim() === "") {
                    $(this).removeClass("is-valid").addClass("is-invalid");
                }
            });
            $('select').each(function() {
                if ($(this).val().trim() === "") {
                    $(this).removeClass("is-valid").addClass("is-invalid");
                }
            });

            if ($('.is-invalid')[0]) {
                $('#expModal').modal('hide');
                $('#expSubmit').prop('disabled', false);
            } else {
                let datastring = {
                    "expDate": $('#expDate').val(),
                    "expControl": $('#expControl').val(),
                    "expName": $('#expName').val(),
                    "expAmount": $('#expAmount').val(),
                    "expCategory": $('#expCategory').val(),
                    "expDescription": $('#expDescription').val(),
                    "btnUpdate": $('#expUpdate').val()
                };
                console.log(datastring);
                $.ajax({
                    url: 'includes/expenses-add.inc.php',
                    type: 'POST',
                    data: datastring,
                    dataType: 'json',
                    error: function(error) {
                        console.log(error);
                    },
                    success: function(data) {

                        if (data.status) {
                            $('input').prop('disabled', true);
                            $('#expUpdate').prop('disabled', true);
                            $('#btnExpUpdate').html("<span class='spinner-border spinner-border-sm ' id = 'loading' role='status' aria-hidden='true'></span>");
                            $('#successBox').show();
                            $('#expModal').modal('hide');
                            window.setTimeout(function() {
                                window.location.href = 'expenses-report.php';
                            }, 2000);
                        }

                    }

                });
            }
        });

    });
</script>