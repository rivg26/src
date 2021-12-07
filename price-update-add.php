<?php require_once 'head.php' ?>
<div class="row" style="position:relative">
    <div class="shadow p-5 mb-5 bg-body rounded">
        <div class="text-center mb-5">
            <h5 class="display-4 mb-5 mt-3 ">Price Update Add</h5>
        </div>
        <div class="container px-4 ">
            <div class="col-md-3 mb-3">
                <label for="punId" class="form-label">Price Update Number</label>
                <input type="text" class="form-control shadow-none" id="pundId" required>
            </div>
            <div class="row g-5 border p-4 mt-5">
                <?php

                for ($x = 1; $x <= 16; $x++) {
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
                                                <option value="PLPG-50" ' . $one . '>PETRON GASUL 50 KILOS</option>
                                                <option value="PLPG-22" ' . $two . '>PETRON GASUL 22 KILOS</option>
                                                <option value="PLPG-11CT" ' . $three . '>PETRON GASUL 11 KILOS Compact-Valve Type ("de salpak")</option>
                                                <option value="PLPG-11PT" ' . $four . '>PETRON GASUL 11 KILOS POL Type ("de roskas")</option>
                                                <option value="PLPG-7CT" ' . $five . '>PETRON GASUL 7 KILOS Compact-Valve Type ("de salpak")</option>
                                                <option value="PLPG-7PT" ' . $six . '>PETRON GASUL 7 KILOS POL Type ("de roskas")</option>
                                                <option value="PLPG-2CT" ' . $seven . '>PETRON GASUL 2.7 KILOS Compact-Valve Type ("de salpak")</option>
                                                <option value="PLPG-2PT" ' . $eight . '>PETRON GASUL 2.7 KILOS POL Type ("de roskas")</option>
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
                                            <input type="number" class="form-control shadow-none" id="pp' . $x . '" required>
                                            <div id="ppFeedback' . $x . '" class="invalid-feedback">
                                                Please input plant price..
                                            </div>
                                        </div>
        
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="fp' . $x . '" class="form-label">Final Price</label>
                                            <input type="number" class="form-control shadow-none" id="fp' . $x . '" required>
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
        </div>

        <div class="text-center mt-3 no-printme ">
            <button class="btn btn-lg shadow-none rippleButton ripple" id="btnPriceUpdateAdd">Submit</button>
        </div>
    </div>
</div>
<?php require_once 'footer.php' ?>
<script>
    $(document).ready(function() {
        $(document).on('click', '#btnPriceUpdateAdd', function() {

        });

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
                } else if (parseInt($('#fp' + e.data.classx).val()) < parseInt($('#pp' + e.data.classx).val())) {
                    $('#fpFeedback' + e.data.classx).text('Factory Price Should Need be lower than Plant Price...');
                    $('#fp' + e.data.classx).removeClass('is-valid');
                    $('#fp' + e.data.classx).addClass('is-invalid');
                } else {
                    $('#fp' + e.data.classx).removeClass('is-invalid');
                    $('#fp' + e.data.classx).addClass('is-valid');
                }
            });

            $(document).on('click', '#btnPriceUpdateAdd', {
                'classx': x
            }, function(e) {
                e.preventDefault();
                if (!$('#pp' + e.data.classx).val() || !$('#fp' + e.data.classx).val()) {
                    if (!$('#pp' + e.data.classx).val() && !$('#fp' + e.data.classx).val()) {
                        $('#fp' + e.data.classx).removeClass('is-valid');
                        $('#fp' + e.data.classx).addClass('is-invalid');
                        $('#pp' + e.data.classx).removeClass('is-valid');
                        $('#pp' + e.data.classx).addClass('is-invalid');
                    } else if (!$('#pp' + e.data.classx).val()) {
                        $('#pp' + e.data.classx).removeClass('is-valid');
                        $('#pp' + e.data.classx).addClass('is-invalid');
                    } else {
                        $('#fp' + e.data.classx).removeClass('is-valid');
                        $('#fp' + e.data.classx).addClass('is-invalid');
                    }
                }

            });
        }


    });
</script>