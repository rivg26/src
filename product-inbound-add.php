<?php require_once 'head.php' ?>
<?php

if (isset($_GET['rowId'])) {
    $data = getProductInboundData($conn, $_GET['rowId']);
    $generate = $data['pin_invoice'];
    $punGen = $data['pin_pun'];
    $date = $data['pin_date'];
    $product = $data['pin_product_id'];
    $productOption = $data['pin_product_option'];
    $quantity = $data['pin_total_quantity'];
    $metricTons = $data['pin_metric_tons'];
    $totalPlantPrice = $data['pin_total_plant_price'];
    $totalFinalPrice = $data['pin_total_final_price'];
    $totalFinalPrice = $data['pin_total_final_price'];
    $remarks = $data['pin_remarks'];
} else {
    $generate = GenerateKey($conn, 'SELECT * FROM `product_inbound_table`;', 'PINV-', 'pin_invoice');
    $pun = getPunInbound($conn);
    $punGen = $pun['price_pun'];
    $date = "";
    $product = "";
    $productOption = "";
    $quantity = "";
    $metricTons = "";
    $totalPlantPrice = "";
    $totalFinalPrice = "";
    $totalFinalPrice = "";
    $remarks = "";
}


?>
<div class="container " style="position: relative;">
    <div class="mx-auto shadow p-5 my-5 bg-white rounded justify-content-center">
        <div class="text-center ">
            <h5 class=" display-4 mb-5">Add Product Inbound</h5>
        </div>
        <div class="row d-flex flex-row justify-content-between mb-4">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="pinInvoice" class="form-label">Invoice Number</label>
                    <input type="text" class="form-control shadow-none" id="pinInvoice" value="<?= $generate  ?>" readonly required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="pinPun" class="form-label">PU Number</label>
                    <input type="text" class="form-control shadow-none" id="pinPun" value="<?= $punGen ?>" readonly required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="pinDate" class="form-label">Date Inbound</label>
                    <input type="date" class="form-control shadow-none" id="pinDate" value="<?= $date ?>">
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div id="pinDateFeedback" class="invalid-feedback">
                        Please input Date...
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">

        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="pinProduct" class="form-label">Product</label>
                    <select class="form-select shadow-none" id="pinProduct">
                        <option value="" selected>---Select Product---</option>
                        <?= printProductOption($conn, $product);  ?>
                    </select>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div id="pinProductFeedback" class="invalid-feedback">
                        Please input Product...
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="pinProductOption" class="form-label">Product Option</label>
                    <select class="form-select shadow-none" id="pinProductOption">
                        <option value="" <?= $productOption == "" ? "selected" : "" ?>>---Select Product Option---</option>
                        <option value="REFILL" <?= $productOption == "REFILL" ? "selected" : "" ?>>REFILL</option>
                        <option value="NEW" <?= $productOption == "NEW" ? "selected" : "" ?>>NEW</option>
                    </select>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div id="pinProductOptionFeedback" class="invalid-feedback">
                        Please input Product...
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="pinQuantity" class="form-label">Quantity</label>
                    <input type="number" class="form-control shadow-none" id="pinQuantity" value="<?= $quantity ?>" placeholder="0" onkeypress="return /^[0-9]*$/.test(event.key)">
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div id="adminUsernameFeedback" class="invalid-feedback">
                        Please input Quantity....
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="pinMetricTon" class="form-label">Metric Tons</label>
                    <input type="number" class="form-control shadow-none" id="pinMetricTon" placeholder="" value="<?= $metricTons ?>" readonly>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="pinPlantPrice" class="form-label">Plant Price</label>
                    <input type="number" class="form-control shadow-none" id="pinPlantPrice" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="pinFinalPrice" class="form-label">Final Price</label>
                    <input type="number" class="form-control shadow-none" id="pinFinalPrice" readonly>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="pinTPlantPrice" class="form-label">Total Plant Price</label>
                    <input type="number" class="form-control shadow-none" id="pinTPlantPrice" value="<?= $totalPlantPrice ?>" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="pinTFinalPrice" class="form-label">Total Final Price</label>
                    <input type="number" class="form-control shadow-none" id="pinTFinalPrice" value="<?= $totalFinalPrice ?>" readonly>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="pinRemarks" class="form-label">Remarks</label>
                    <textarea class="form-control shadow-none" id="pinRemarks" rows="3"><?= $remarks ?></textarea>

                </div>
            </div>
        </div>
        <div class="text-center alert alert-danger my-4" style="display: none;" id="errorBox">
        <i class="fas fa-times-circle"></i> Please fill all the fields...
        </div>
        <div class="text-center alert alert-success my-4" style="display: none;" id="successBox">
        <i class="fas fa-check-circle"></i> Submission Success!
        </div>

        <div class="text-center mt-4">
            <?php

            if (isset($_GET['rowId'])) {
                echo '<button class="btn btn-lg shadow-none rippleButton ripple"  data-bs-toggle="modal" data-bs-target="#pinModal" id= "btnPinSubmit" data-backdrop="false">UPDATE</button>';
            } else {
                echo '<button class="btn btn-lg shadow-none rippleButton ripple"  data-bs-toggle="modal" data-bs-target="#pinModal" id= "btnPinSubmit" data-backdrop="false">SUBMIT</button>';
            }

            ?>

        </div>
        <!-- Modal -->
        <div class="modal fade" id="pinModal" tabindex="-1" aria-hidden="true">
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
                            echo '<button type="button" class="btn shadow-none rippleButton ripple" id="pinUpdate">Save changes</button>';
                        } else {
                            echo '<button type="button" class="btn shadow-none rippleButton ripple" id="pinSubmit">Save changes</button>';
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

        // const urlParams = new URLSearchParams(window.location.search);
        // const myParam = urlParams.get('rowId');
        // if(myParam){
        //     alert('hello');
        // }




        $(document).on('change', '#pinDate', function() {
            if (!$(this).val() || $(this).val() === "") {
                $(this).removeClass('is-valid');
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
                $(this).addClass('is-valid');
            }
        });

        $(document).on('change', '#pinProduct', function() {
            if (!$(this).val() || $(this).val() === "") {
                $(this).removeClass('is-valid');
                $(this).addClass('is-invalid');
                $('#pinPlantPrice').val("");
                $('#pinFinalPrice').val("");
                $('#pinTPlantPrice').val("");
                $('#pinTFinalPrice').val("");
                $('#pinMetricTon').val("");
                $('#pinQuantity').val("");
                $('#pinQuantity').removeClass('is-valid');
                $('#pinQuantity').addClass('is-invalid');
            } else {
                if (!$('#pinProductOption').val() || $('#pinProductOption').val() === "") {
                    $('#pinProduct').removeClass('is-invalid');
                    $('#pinProduct').addClass('is-valid');

                } else {
                    let datastring = {
                        "pinProduct": $('#pinProduct').val(),
                        "pinProductOption": $('#pinProductOption').val(),
                        "pinPun": $('#pinPun').val(),
                        "s1": "product <<< productOption"
                    };
                    console.log(datastring);
                    $.ajax({
                        url: 'includes/product-inbound-add.inc.php',
                        type: 'POST',
                        data: datastring,
                        dataType: 'json',
                        success: function(data) {
                            if (data.status) {
                                $('#pinPlantPrice').val(data.price_plant_price);
                                $('#pinFinalPrice').val(data.price_final_price);
                                $('#pinProduct').removeClass('is-invalid');
                                $('#pinProduct').addClass('is-valid');
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
        $(document).on('change', '#pinProductOption', function() {
            if (!$(this).val() || $(this).val() === "") {
                $(this).removeClass('is-valid');
                $(this).addClass('is-invalid');
                $('#pinPlantPrice').val("");
                $('#pinFinalPrice').val("");
                $('#pinTPlantPrice').val("");
                $('#pinTFinalPrice').val("");
                $('#pinMetricTon').val("");
                $('#pinQuantity').val("");
                $('#pinQuantity').removeClass('is-valid');
                $('#pinQuantity').addClass('is-invalid');
            } else {
                if (!$('#pinProduct').val() || $('#pinProduct').val() === "") {
                    $('#pinProductOption').removeClass('is-invalid');
                    $('#pinProductOption').addClass('is-valid');
                } else {
                    let datastring = {
                        "pinProduct": $('#pinProduct').val(),
                        "pinProductOption": $('#pinProductOption').val(),
                        "pinPun": $('#pinPun').val(),
                        "s1": "product <<< productOption"
                    };
                    $.ajax({
                        url: 'includes/product-inbound-add.inc.php',
                        type: 'POST',
                        data: datastring,
                        dataType: 'json',
                        success: function(data) {
                            if (data.status) {
                                $('#pinPlantPrice').val(data.price_plant_price);
                                $('#pinFinalPrice').val(data.price_final_price);
                                $('#pinProductOption').removeClass('is-invalid');
                                $('#pinProductOption').addClass('is-valid');
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

        $(document).on('keyup', '#pinQuantity', function() {
            if (!$(this).val() || $(this).val() === "" || parseInt($(this).val()) <= 0) {
                $(this).removeClass('is-valid');
                $(this).addClass('is-invalid');
            } else {
                if (!$('#pinPlantPrice').val() && !$('#pinFinalPrice').val()) {
                    $('#pinQuantity').removeClass('is-invalid');
                    $('#pinQuantity').addClass('is-valid');
                } else {

                    let datastring = {
                        "pinProduct": $('#pinProduct').val(),
                        "metric": "get metric ton"
                    };
                    $.ajax({
                        url: 'includes/product-inbound-add.inc.php',
                        type: 'POST',
                        data: datastring,
                        dataType: 'json',
                        success: function(data) {
                            if (data.status) {

                                let plantPrice = parseInt($('#pinQuantity').val()) * parseFloat($('#pinPlantPrice').val());
                                let finalPrice = parseInt($('#pinQuantity').val()) * parseFloat($('#pinFinalPrice').val());
                                let metricTon = (parseFloat($('#pinQuantity').val()) * parseFloat(data.weight) / 1000);
                                $('#pinTPlantPrice').val(plantPrice);
                                $('#pinTFinalPrice').val(finalPrice);
                                $('#pinMetricTon').val(metricTon);
                                $('#pinQuantity').removeClass('is-invalid');
                                $('#pinQuantity').addClass('is-valid');
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




        $(document).on('click', '#pinSubmit', function() {
            $('#pinSubmit').prop('disabled', true);
            if (!$('#pinDate').val() || !$('#pinProduct').val() || !$('#pinProductOption').val() || !$('#pinQuantity').val()) {
                $('#errorBox').show();
                $('#pinModal').modal('hide');
                $('#pinSubmit').prop('disabled', false);
            } else {
                if ($('.is-invalid')[0]) {
                    $('#errorBox').hide();
                    $('#pinModal').modal('hide');
                    $('#pinSubmit').prop('disabled', false);
                } else {

                    let datastring = {
                        "pinInvoice": $('#pinInvoice').val(),
                        "pinProduct": $('#pinProduct').val(),
                        "pinPun": $('#pinPun').val(),
                        "pinDate": $('#pinDate').val(),
                        "pinQuantity": $('#pinQuantity').val(),
                        "pinTPlantPrice": $('#pinTPlantPrice').val(),
                        "pinTFinalPrice": $('#pinTFinalPrice').val(),
                        "pinMetricTon": $('#pinMetricTon').val(),
                        "pinProductOption": $('#pinProductOption').val(),
                        "pinRemarks": $('#pinRemarks').val(),
                        "insertProduct": "insert"
                    };
                    console.log(datastring);
                    $.ajax({
                        url: 'includes/product-inbound-add.inc.php',
                        type: 'POST',
                        data: datastring,
                        dataType: 'json',
                        success: function(data) {
                            if (data.status) {
                                $('#errorBox').hide();
                                $('#pinModal').modal('hide');
                                $('#btnPinSubmit').html("<span class='spinner-border spinner-border-sm ' id = 'loading' role='status' aria-hidden='true'></span>");
                                $('#btnPinSubmit').prop('disabled', true);
                                $('input').prop('disabled', true);
                                $('select').prop('disabled', true);
                                $('#successBox').show();
                                window.setTimeout(function() {
                                    window.location.href = 'product-inbound-report.php';
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

        $(document).on('click', '#pinUpdate', function(){
            $('#pinUpdate').prop('disabled', true);
            if (!$('#pinDate').val() || !$('#pinProduct').val() || !$('#pinProductOption').val() || !$('#pinQuantity').val() || !$('#pinPlantPrice').val() || !$('#pinFinalPrice').val()) {
                $('#errorBox').show();
                $('#pinModal').modal('hide');
                $('#pinSubmit').prop('disabled', false);
            }
            else{
                if ($('.is-invalid')[0]) {
                    $('#errorBox').hide();
                    $('#pinModal').modal('hide');
                    $('#pinUpdate').prop('disabled', false);
                }
                else{
                    
                    let datastring = {
                        "pinInvoice": $('#pinInvoice').val(),
                        "pinProduct": $('#pinProduct').val(),
                        "pinPun": $('#pinPun').val(),
                        "pinDate": $('#pinDate').val(),
                        "pinQuantity": $('#pinQuantity').val(),
                        "pinTPlantPrice": $('#pinTPlantPrice').val(),
                        "pinTFinalPrice": $('#pinTFinalPrice').val(),
                        "pinMetricTon": $('#pinMetricTon').val(),
                        "pinProductOption": $('#pinProductOption').val(),
                        "pinRemarks": $('#pinRemarks').val(),
                        "updateProduct": "update"
                    };
                    console.log(datastring);
                    $.ajax({
                        url: 'includes/product-inbound-add.inc.php',
                        type: 'POST',
                        data: datastring,
                        dataType: 'json',
                        success: function(data) {
                            if (data.status) {
                                $('#errorBox').hide();
                                $('#pinModal').modal('hide');
                                $('#btnPinSubmit').html("<span class='spinner-border spinner-border-sm ' id = 'loading' role='status' aria-hidden='true'></span>");
                                $('#btnPinSubmit').prop('disabled', true);
                                $('input').prop('disabled', true);
                                $('select').prop('disabled', true);
                                $('#successBox').show();
                                window.setTimeout(function() {
                                    window.location.href = 'product-inbound-report.php';
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

    });
</script>