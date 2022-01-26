<?php require_once 'head.php' ?>
<?php 

    if(isset($_GET['rowId'])){
        $generate = $_GET['rowId'];
    }
    else{  
        $generate = newGenerateKey($conn, 'SELECT * FROM price_table', 'PUN-', 'price_pun' , 'SELECT * FROM archive_price_table', 'a_price_pun');
    }
    

?>
<div class="row" >
    <div class="shadow p-5 mb-5 bg-body rounded">
        <div class="text-center mb-5" style="position:relative">
            <h5 class="display-4 mb-5 mt-3 ">Price Update Add</h5>
        </div>
        <div class="container px-4 ">
            <div class="col-md-3 mb-3">
                <label for="punId" class="form-label">Price Update Number</label>
                <input type="text" class="form-control shadow-none" id="pundId" value="<?= $generate ?>" required readonly>
            </div>
            <div class="row g-5 border p-4 mt-5">
                <?php

                for ($x = 1; $x <= 16; $x++) {
                    if(isset($_GET['rowId'])){
                        $data = getPriceUpdateData($conn, $_GET['rowId']);
                        $plantPrice = $data[$x-1]['price_plant_price']; 
                        $finalPrice = $data[$x-1]['price_final_price']; 
                    }
                    else{
                        $plantPrice = "";
                        $finalPrice = "";
                    }
                    $one = "";
                    $two = "";
                    $three = "";
                    $four = "";
                    $five = "";
                    $six = "";
                    $seven = "";
                    $eight = "";
                    if ($x === 1 || $x === 2) {
                        $one = "selected";
                    } elseif ($x === 3 || $x === 4) {
                        $two = "selected";
                    } elseif ($x === 5 || $x === 6) {
                        $three = "selected";
                    } elseif ($x === 7 || $x === 8) {
                        $four = "selected";
                    } elseif ($x === 9 || $x === 10) {
                        $five = "selected";
                    } elseif ($x === 11 || $x === 12) {
                        $six = "selected";
                    } elseif ($x === 13 || $x === 14) {
                        $seven = "selected";
                    } elseif ($x === 15 || $x === 16) {
                        $eight = "selected";
                    }

                    if ($x % 2 === 0) {
                        $select = "selected";
                    } else {
                        $select = "";
                    }
                    echo '                
                        <div class="col-md-6 ">
                            <div class="p-3 border">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="p' . $x . '" class="form-label">Product</label>
                                            <select class="form-select" id="p' . $x . '" disabled>
                                                <option value="1" ' . $one . '>PETRON GASUL 50 KILOS</option>
                                                <option value="2" ' . $two . '>PETRON GASUL 22 KILOS</option>
                                                <option value="3" ' . $three . '>PETRON GASUL 11 KILOS Compact-Valve Type ("de salpak")</option>
                                                <option value="4" ' . $four . '>PETRON GASUL 11 KILOS POL Type ("de roskas")</option>
                                                <option value="5" ' . $five . '>PETRON GASUL 7 KILOS Compact-Valve Type ("de salpak")</option>
                                                <option value="6" ' . $six . '>PETRON GASUL 7 KILOS POL Type ("de roskas")</option>
                                                <option value="7" ' . $seven . '>PETRON GASUL 2.7 KILOS Compact-Valve Type ("de salpak")</option>
                                                <option value="8" ' . $eight . '>PETRON GASUL 2.7 KILOS POL Type ("de roskas")</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="pt' . $x . '" class="form-label">Product Type</label>
                                            <select class="form-select" id="pt' . $x . '" disabled>
                                                <option value="NEW" ' . $select . '>NEW</option>
                                                <option value="REFILL"  ' . $select . '>REFILL</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="pp' . $x . '" class="form-label">Plant Price</label>
                                            <input type="number" class="form-control shadow-none" id="pp' . $x . '"  value= "'.$plantPrice.'" required>
                                            <div id="ppFeedback' . $x . '" class="invalid-feedback">
                                                Please input plant price..
                                            </div>
                                        </div>
        
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="fp' . $x . '" class="form-label">Final Price</label>
                                            <input type="number" class="form-control shadow-none" id="fp' . $x . '" value= "'.$finalPrice.'" required>
                                            <div id="fpFeedback' . $x . '" class="invalid-feedback">
                                                Please input factory price..
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
                }


                ?>
            </div>
            <div class="text-center alert alert-danger my-5" id="errorBox" style="display: none;">
                <i class="fas fa-times-circle"></i> This Form Has Errors
            </div>
            <div class="text-center alert alert-success my-5" id="successBox" style="display: none;">
                <i class="fas fa-check-circle"></i> Price Update Success!
            </div>
        </div>

        <div class="text-center mt-3 no-printme ">

        <?php
                if(isset($_GET['action'])){
                    if($_GET['action'] === "update"){
                        echo '<button class="btn btn-lg shadow-none rippleButton ripple" id = "btnPriceUpdatePrint" onclick="window.print();">Print</button>
                        <button class="btn btn-lg shadow-none rippleButton ripple" id="btnPriceUpdateUpdate">Update</button>';
                    }
                }
                else{
                    echo '<button class="btn btn-lg shadow-none rippleButton ripple" id="btnPriceUpdateAdd">Submit</button>';
                }
        ?>
            
            
        </div>
     
    </div>
    <?php require_once 'loader.php' ?>
</div>
<?php require_once 'footer.php' ?>
<script>
    $(document).ready(function() {


        for (let x = 1; x <= 16; x++) {

            $(document).on('keyup', '#pp' + x, {
                'classx': x
            }, function(e) {
                e.preventDefault();
                if (!$('#pp' + e.data.classx).val() || parseInt($('#pp' + e.data.classx).val()) <= 0) {
                    $('#pp' + e.data.classx).removeClass('is-valid');
                    $('#pp' + e.data.classx).addClass('is-invalid');
                } else {
                    $('#pp' + e.data.classx).removeClass('is-invalid');
                    $('#pp' + e.data.classx).addClass('is-valid');
                }
            });

            $(document).on('keyup', '#fp' + x, {
                'classx': x
            }, function(e) {
                e.preventDefault();
                if (!$('#fp' + e.data.classx).val() || parseInt($('#fp' + e.data.classx).val()) <= 0) {
                    $('#fpFeedback' + e.data.classx).text('Please input factory price..');
                    $('#fp' + e.data.classx).removeClass('is-valid');
                    $('#fp' + e.data.classx).addClass('is-invalid');
                } else if (parseInt($('#fp' + e.data.classx).val()) < parseInt($('#pp' + e.data.classx)
                        .val())) {
                    $('#fpFeedback' + e.data.classx).text(
                        'Factory Price Should Need be lower than Plant Price...');
                    $('#fp' + e.data.classx).removeClass('is-valid');
                    $('#fp' + e.data.classx).addClass('is-invalid');
                } else {
                    $('#fp' + e.data.classx).removeClass('is-invalid');
                    $('#fp' + e.data.classx).addClass('is-valid');
                }
            });


        }
        $(document).on('click', '#btnPriceUpdateAdd', function(e) {
            e.preventDefault();
            $('#btnPriceUpdateAdd').prop('disabled', true);
            for (var j = 1; j <= 16; j++) {
                if (!$('#pp' + j).val() || !$('#fp' + j).val()) {
                    if (!$('#pp' + j).val() && !$('#fp' + j).val()) {
                        $('#fp' + j).removeClass('is-valid');
                        $('#fp' + j).addClass('is-invalid');
                        $('#pp' + j).removeClass('is-valid');
                        $('#pp' + j).addClass('is-invalid');
                    } else if (!$('#pp' + j).val()) {
                        $('#pp' + j).removeClass('is-valid');
                        $('#pp' + j).addClass('is-invalid');
                    } else {
                        $('#fp' + j).removeClass('is-valid');
                        $('#fp' + j).addClass('is-invalid');
                    }
                    $('#btnPriceUpdateAdd').prop('disabled', false);
                }

            }
            if (!$('.is-invalid')[0]) {
                var ppArray = [];
                var fpArray = [];
                var productArray = [];
                var pTypeArray = [];
                for (var x = 1; x <= 16; x++) {
                    ppArray[x - 1] = $('#pp' + x).val();
                    fpArray[x - 1] = $('#fp' + x).val();
                    productArray[x - 1] = $('#p' + x).val();
                    pTypeArray[x - 1] = $('#pt' + x).val();
                }
                let datastring = {
                    "pp": ppArray,
                    "fp": fpArray,
                    "product": productArray,
                    "pt": pTypeArray,
                    "punId": $('#pundId').val(),
                    "btnPriceUpdateAdd": $('#btnPriceUpdateAdd').val()
                }
                console.log(datastring);
                
                $.ajax({
                    url: 'includes/price-update-add.inc.php',
                    type: 'POST',
                    data: datastring,
                    dataType: 'json',
                    success: function(data) {

                        if (data.status) {
                            $('#btnPriceUpdateAdd').html("<span class='spinner-border spinner-border-sm ' id = 'loading' role='status' aria-hidden='true'></span>");
                            $('#btnPriceUpdateAdd').prop('disabled', true);
                            for(let x = 1; x <= 16; x++){
                                $('#pp' + x).prop('disabled',true);
                                $('#fp' + x).prop('disabled',true);
                            }
                            $('#successBox').show();
                            window.setTimeout(function() {
                                window.location.href = 'price-update-report.php';
                            }, 3000);
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
            else{
                $('#btnPriceUpdateAdd').prop('disabled', false);
            }
        });

        $(document).on('click', '#btnPriceUpdateUpdate', function(e) {
            e.preventDefault();
            $('#btnPriceUpdateUpdate').prop('disabled', true);
            for (var j = 1; j <= 16; j++) {
                if (!$('#pp' + j).val() || !$('#fp' + j).val()) {
                    if (!$('#pp' + j).val() && !$('#fp' + j).val()) {
                        $('#fp' + j).removeClass('is-valid');
                        $('#fp' + j).addClass('is-invalid');
                        $('#pp' + j).removeClass('is-valid');
                        $('#pp' + j).addClass('is-invalid');
                    } else if (!$('#pp' + j).val()  ) {
                        $('#pp' + j).removeClass('is-valid');
                        $('#pp' + j).addClass('is-invalid');
                    } else {
                        $('#fp' + j).removeClass('is-valid');
                        $('#fp' + j).addClass('is-invalid');
                    }
                    $('#btnPriceUpdateUpdate').prop('disabled', false);
                }
                if(parseInt($('#fp' + j).val()) <= parseInt($('#pp' + j).val())){
                    $('#fp' + j).removeClass('is-valid');
                    $('#fp' + j).addClass('is-invalid');
                    $('#fpFeedback' + j).text('Factory Price Should Need be lower than Plant Price...');
                }

            }
            if (!$('.is-invalid')[0]) {
                var ppArray = [];
                var fpArray = [];
                var productArray = [];
                var pTypeArray = [];
                for (var x = 1; x <= 16; x++) {
                    ppArray[x - 1] = $('#pp' + x).val();
                    fpArray[x - 1] = $('#fp' + x).val();
                    productArray[x - 1] = $('#p' + x).val();
                    pTypeArray[x - 1] = $('#pt' + x).val();
                }
                let datastring = {
                    "pp": ppArray,
                    "fp": fpArray,
                    "product": productArray,
                    "pt": pTypeArray,
                    "punId": $('#pundId').val(),
                    "btnPriceUpdateUpdate": $('#btnPriceUpdateUpdate').val()
                }
                console.log(datastring);
                
                $.ajax({
                    url: 'includes/price-update-add.inc.php',
                    type: 'POST',
                    data: datastring,
                    dataType: 'json',
                    success: function(data) {

                        if (data.status) {
                            $('#btnPriceUpdateUpdate').html("<span class='spinner-border spinner-border-sm ' id = 'loading' role='status' aria-hidden='true'></span>");
                            $('#btnPriceUpdateUpdate').prop('disabled', true);
                            $('#btnPriceUpdatePrint').prop('disabled', true);
                            for(let x = 1; x <= 16; x++){
                                $('#pp' + x).prop('disabled',true);
                                $('#fp' + x).prop('disabled',true);
                            }
                            $('#successBox').show();
                            window.setTimeout(function() {
                                window.location.href = 'price-update-report.php';
                            }, 3000);
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
            else{
                $('#btnPriceUpdateUpdate').prop('disabled', false);
            }
        });

        


    });
</script>