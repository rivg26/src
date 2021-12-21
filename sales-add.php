<?php require_once 'head.php' ?>
<?php
$data =  getPriceSaleData($conn);
$stocks = getStocks($conn);
?>
<link rel="stylesheet" href="css/magnify.css">
<link rel="stylesheet" href="css/sales-add.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<div class="row" style="position: relative;">
    <div class="row shadow p-5 mb-4 bg-body rounded  mt-3">
        <div class="text-center">
            <h5 class="display-4 mb-5 mt-3">Add Sales</h5>
        </div>
        <div class="mb-3 row">
            <label for="tags" class="col-sm-1 col-form-label" style="font-size: 0.82rem;">Customer Name</label>
            <div class="col-sm-3">
                <input type="text" class="form-control shadow-none" id="tags">
            </div>
            <input type="hidden" id="salesInvoice" value="<?= GenerateKey($conn, 'SELECT * FROM sales_table;', 'SINV-', 'sales_invoice') ?>">
            <button class="col-sm-1 btn btn-success" data-toggle="tooltip" title="Add New Customer" data-bs-placement="right"><i class="fas fa-user-plus"></i> NEW</button>
        </div>
        <fieldset class="border mt-5 p-5  g-5 bg-light">
            <legend class="float-none w-auto">CART</legend>
            <div class="parent">

                <div class="child">
                    <div class="card" style="width: 18rem;">
                        <img src="assets/product-img/50kg.png" data-magnify-src="assets/product-img/50kg.png" class="card-img-top p-5 zoom" alt="..." data-toggle="tooltip" title="<?= $stocks[0]["product_name"] ?>">
                        <div class="card-body">
                            <h5 class="card-title mb-5" id="product1"><?= $stocks[0]["product_name"] ?></h5>
                            <div class="d-flex justify-content-between mt-3">
                                <p class="card-text">PHP <span id="price1"><?= $data[1]['price_final_price'] ?></span></p>
                                <p class="card-text">Stocks: <span id="stocks1"><?= $stocks[0]['total_quantity'] ?></span></p>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input shadow-none getCheck1" type="radio" name="flexRadioDefault" id="check1" value="<?= $data[0]["price_final_price"] ?>">
                                <label class="form-check-label" for="check1">NEW</label>
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input shadow-none getCheck1" type="radio" name="flexRadioDefault" id="check2" value="<?= $data[1]["price_final_price"] ?>" checked>
                                <label class="form-check-label" for="check2">REFILL</label>
                            </div>
                            <div class="input-group mb-4">
                                <span class="input-group-text" id="basic-addon1">Quantity</span>
                                <input type="number" class="form-control shadow-none" id="quantity1" min="1" max="<?= $stocks[0]['total_quantity'] ?>" onkeyup="if(parseInt(this.value)>this.max){ this.value = this.max;}else if(parseInt(this.value) <= 0) {this.value = this.min } return false;" onkeypress="return /^[0-9]*$/.test(event.key)" <?= (int)$stocks[0]['total_quantity'] === 0 ? "disabled" : "" ?>>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div id="quantityFeedback1" class="invalid-feedback">
                                    Please input quantity...
                                </div>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-lg shadow-none rippleButton ripple" id="cart1" <?= (int)$stocks[0]['total_quantity'] === 0 ? "disabled" : "" ?>><i class="fas fa-cart-plus"></i> Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="child">
                    <div class="card" style="width: 18rem;">
                        <img src="assets/product-img/22kg.png" data-magnify-src="assets/product-img/22kg.png" class="card-img-top p-5 zoom" alt="..." data-toggle="tooltip" title="<?= $stocks[1]["product_name"] ?>">
                        <div class="card-body">
                            <h5 class="card-title mb-5" id="product2"><?= $stocks[1]["product_name"] ?></h5>
                            <div class="d-flex justify-content-between mt-3">
                                <p class="card-text">PHP <span id="price2"><?= $data[3]['price_final_price'] ?></span></p>
                                <p class="card-text">Stocks: <span id="stocks2"><?= $stocks[1]['total_quantity'] ?></span></p>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input shadow-none getCheck2" type="radio" name="flexRadioDefault1" id="check3" value="<?= $data[2]["price_final_price"] ?>">
                                <label class="form-check-label" for="check3">NEW</label>
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input shadow-none getCheck2" type="radio" name="flexRadioDefault1" id="check4" value="<?= $data[3]["price_final_price"] ?>" checked>
                                <label class="form-check-label" for="check4">REFILL</label>
                            </div>
                            <div class="input-group mb-4">
                                <span class="input-group-text" id="basic-addon1">Quantity</span>
                                <input type="number" class="form-control shadow-none" id="quantity2" min="1" max="<?= $stocks[1]['total_quantity'] ?>" onkeyup="if(parseInt(this.value)>this.max){ this.value = this.max;}else if(parseInt(this.value) <= 0) {this.value = this.min } return false;" onkeypress="return /^[0-9]*$/.test(event.key)" <?= (int)$stocks[1]['total_quantity'] === 0 ? "disabled" : "" ?>>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div id="quantityFeedback2" class="invalid-feedback">
                                    Please input quantity...
                                </div>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-lg shadow-none rippleButton ripple" id="cart2" <?= (int)$stocks[1]['total_quantity'] === 0 ? "disabled" : "" ?>><i class="fas fa-cart-plus"></i> Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="child">
                    <div class="card" style="width: 18rem;">
                        <img src="assets/product-img/11kg.png" data-magnify-src="assets/product-img/11kg.png" class="card-img-top p-5 zoom" alt="..." data-toggle="tooltip" title="<?= $stocks[2]["product_name"] ?>">
                        <div class="card-body">
                            <h5 class="card-title mb-5" id="product3"><?= $stocks[2]["product_name"] ?></h5>
                            <div class="d-flex justify-content-between mt-3">
                                <p class="card-text">PHP <span id="price3"><?= $data[5]['price_final_price'] ?></span></p>
                                <p class="card-text">Stocks: <span id="stocks3"><?= $stocks[2]['total_quantity'] ?></span></p>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input shadow-none getCheck3" type="radio" name="flexRadioDefault2" id="check5" value="<?= $data[4]["price_final_price"] ?>">
                                <label class="form-check-label" for="check5">NEW</label>
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input shadow-none getCheck3" type="radio" name="flexRadioDefault2" id="check6" value="<?= $data[5]["price_final_price"] ?>" checked>
                                <label class="form-check-label" for="check6">REFILL</label>
                            </div>
                            <div class="input-group mb-4">
                                <span class="input-group-text" id="basic-addon1">Quantity</span>
                                <input type="number" class="form-control shadow-none" id="quantity3" min="1" max="<?= $stocks[2]['total_quantity'] ?>" onkeyup="if(parseInt(this.value)>this.max){ this.value = this.max;}else if(parseInt(this.value) <= 0) {this.value = this.min } return false;" onkeypress="return /^[0-9]*$/.test(event.key)" <?= (int)$stocks[2]['total_quantity'] === 0 ? "disabled" : "" ?>>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div id="quantityFeedback3" class="invalid-feedback">
                                    Please input quantity...
                                </div>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-lg shadow-none rippleButton ripple" id="cart3" <?= (int)$stocks[2]['total_quantity'] === 0 ? "disabled" : "" ?>><i class="fas fa-cart-plus"></i> Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="child">
                    <div class="card" style="width: 18rem;">
                        <img src="assets/product-img/11kg.png" data-magnify-src="assets/product-img/11kg.png" class="card-img-top p-5 zoom" alt="..." data-toggle="tooltip" title="<?= $stocks[3]["product_name"] ?>">
                        <div class="card-body">
                            <h5 class="card-title mb-5" id="product4"><?= $stocks[3]["product_name"] ?></h5>
                            <div class="d-flex justify-content-between mt-3">
                                <p class="card-text">PHP <span id="price4"><?= $data[7]['price_final_price'] ?></span></p>
                                <p class="card-text">Stocks: <span id="stocks4"><?= $stocks[3]['total_quantity'] ?></span></p>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input shadow-none getCheck4" type="radio" name="flexRadioDefault3" id="check7" value="<?= $data[6]["price_final_price"] ?>">
                                <label class="form-check-label" for="check7">NEW</label>
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input shadow-none getCheck4" type="radio" name="flexRadioDefault3" id="check8" value="<?= $data[7]["price_final_price"] ?>" checked>
                                <label class="form-check-label" for="check8">REFILL</label>
                            </div>
                            <div class="input-group mb-4">
                                <span class="input-group-text" id="basic-addon1">Quantity</span>
                                <input type="number" class="form-control shadow-none" id="quantity4" min="1" max="<?= $stocks[3]['total_quantity'] ?>" onkeyup="if(parseInt(this.value)>this.max){ this.value = this.max;}else if(parseInt(this.value) <= 0) {this.value = this.min } return false;" onkeypress="return /^[0-9]*$/.test(event.key)" <?= (int)$stocks[3]['total_quantity'] === 0 ? "disabled" : "" ?>>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div id="quantityFeedback4" class="invalid-feedback">
                                    Please input quantity...
                                </div>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-lg shadow-none rippleButton ripple" id="cart4" <?= (int)$stocks[3]['total_quantity'] === 0 ? "disabled" : "" ?>><i class="fas fa-cart-plus"></i> Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="child">
                    <div class="card" style="width: 18rem;">
                        <img src="assets/product-img/7kg.png" data-magnify-src="assets/product-img/7kg.png" class="card-img-top p-5 zoom" alt="..." data-toggle="tooltip" title="<?= $stocks[4]["product_name"] ?>">
                        <div class="card-body">
                            <h5 class="card-title mb-5" id="product5"><?= $stocks[4]["product_name"] ?></h5>
                            <div class="d-flex justify-content-between mt-3">
                                <p class="card-text">PHP <span id="price5"><?= $data[9]['price_final_price'] ?></span></p>
                                <p class="card-text">Stocks: <span id="stocks5"><?= $stocks[4]['total_quantity'] ?></span></p>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input shadow-none getCheck5" type="radio" name="flexRadioDefault4" id="check9" value="<?= $data[8]["price_final_price"] ?>">
                                <label class="form-check-label" for="check9">NEW</label>
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input shadow-none getCheck5" type="radio" name="flexRadioDefault4" id="check10" value="<?= $data[9]["price_final_price"] ?>" checked>
                                <label class="form-check-label" for="check10">REFILL</label>
                            </div>
                            <div class="input-group mb-4">
                                <span class="input-group-text" id="basic-addon1">Quantity</span>
                                <input type="number" class="form-control shadow-none" id="quantity5" min="1" max="<?= $stocks[4]['total_quantity'] ?>" onkeyup="if(parseInt(this.value)>this.max){ this.value = this.max;}else if(parseInt(this.value) <= 0) {this.value = this.min } return false;" onkeypress="return /^[0-9]*$/.test(event.key)" <?= (int)$stocks[4]['total_quantity'] === 0 ? "disabled" : "" ?>>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div id="quantityFeedback5" class="invalid-feedback">
                                    Please input quantity...
                                </div>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-lg shadow-none rippleButton ripple" id="cart5" <?= (int)$stocks[4]['total_quantity'] === 0 ? "disabled" : "" ?>><i class="fas fa-cart-plus"></i> Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="child">
                    <div class="card" style="width: 18rem;">
                        <img src="assets/product-img/7kg.png" data-magnify-src="assets/product-img/7kg.png" class="card-img-top p-5 zoom" alt="..." data-toggle="tooltip" title="<?= $stocks[5]["product_name"] ?>">
                        <div class="card-body">
                            <h5 class="card-title mb-5" id="product6"><?= $stocks[5]["product_name"] ?></h5>
                            <div class="d-flex justify-content-between mt-3">
                                <p class="card-text">PHP <span id="price6"><?= $data[11]['price_final_price'] ?></span></p>
                                <p class="card-text">Stocks: <span id="stocks6"><?= $stocks[5]['total_quantity'] ?></span></p>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input shadow-none getCheck6" type="radio" name="flexRadioDefault5" id="check11" value="<?= $data[10]["price_final_price"] ?>">
                                <label class="form-check-label" for="check11">NEW</label>
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input shadow-none getCheck6" type="radio" name="flexRadioDefault5" id="check12" value="<?= $data[11]["price_final_price"] ?>" checked>
                                <label class="form-check-label" for="check12">REFILL</label>
                            </div>
                            <div class="input-group mb-4">
                                <span class="input-group-text" id="basic-addon1">Quantity</span>
                                <input type="number" class="form-control shadow-none" id="quantity6" min="1" max="<?= $stocks[5]['total_quantity'] ?>" onkeyup="if(parseInt(this.value)>this.max){ this.value = this.max;}else if(parseInt(this.value) <= 0) {this.value = this.min } return false;" onkeypress="return /^[0-9]*$/.test(event.key)" <?= (int)$stocks[5]['total_quantity'] === 0 ? "disabled" : "" ?>>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div id="quantityFeedback6" class="invalid-feedback">
                                    Please input quantity...
                                </div>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-lg shadow-none rippleButton ripple" id="cart6" <?= (int)$stocks[5]['total_quantity'] === 0 ? "disabled" : "" ?>><i class="fas fa-cart-plus"></i> Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="child">
                    <div class="card" style="width: 18rem;">
                        <img src="assets/product-img/2.7kg.png" data-magnify-src="assets/product-img/2.7kg.png" class="card-img-top p-5 zoom" alt="..." data-toggle="tooltip" title="<?= $stocks[6]["product_name"] ?>">
                        <div class="card-body">
                            <h5 class="card-title mb-5" id="product7"><?= $stocks[6]["product_name"] ?></h5>
                            <div class="d-flex justify-content-between mt-3">
                                <p class="card-text">PHP <span id="price7"><?= $data[13]['price_final_price'] ?></span></p>
                                <p class="card-text">Stocks: <span id="stocks7"><?= $stocks[6]['total_quantity'] ?></span></p>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input shadow-none getCheck7" type="radio" name="flexRadioDefault6" id="check13" value="<?= $data[12]["price_final_price"] ?>">
                                <label class="form-check-label" for="check13">NEW</label>
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input shadow-none getCheck7" type="radio" name="flexRadioDefault6" id="check14" value="<?= $data[13]["price_final_price"] ?>" checked>
                                <label class="form-check-label" for="check14">REFILL</label>
                            </div>
                            <div class="input-group mb-4">
                                <span class="input-group-text" id="basic-addon1">Quantity</span>
                                <input type="number" class="form-control shadow-none" id="quantity7" min="1" max="<?= $stocks[6]['total_quantity'] ?>" onkeyup="if(parseInt(this.value)>this.max){ this.value = this.max;}else if(parseInt(this.value) <= 0) {this.value = this.min } return false;" onkeypress="return /^[0-9]*$/.test(event.key)" <?= (int)$stocks[6]['total_quantity'] === 0 ? "disabled" : "" ?>>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div id="quantityFeedback7" class="invalid-feedback">
                                    Please input quantity...
                                </div>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-lg shadow-none rippleButton ripple" id="cart7" <?= (int)$stocks[6]['total_quantity'] === 0 ? "disabled" : "" ?>><i class="fas fa-cart-plus"></i> Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="child">
                    <div class="card" style="width: 18rem;">
                        <img src="assets/product-img/2.7kg.png" data-magnify-src="assets/product-img/2.7kg.png" class="card-img-top p-5 zoom" alt="..." data-toggle="tooltip" title="<?= $stocks[7]["product_name"] ?>">
                        <div class="card-body">
                            <h5 class="card-title mb-5" id="product8"><?= $stocks[7]["product_name"] ?></h5>
                            <div class="d-flex justify-content-between mt-3">
                                <p class="card-text">PHP <span id="price8"><?= $data[15]['price_final_price'] ?></span></p>
                                <p class="card-text">Stocks: <span id="stocks8"><?= $stocks[7]['total_quantity'] ?></span></p>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input shadow-none getCheck8" type="radio" name="flexRadioDefault7" id="check15" value="<?= $data[14]["price_final_price"] ?>">
                                <label class="form-check-label" for="check15">NEW</label>
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input shadow-none getCheck8" type="radio" name="flexRadioDefault7" id="check16" value="<?= $data[15]["price_final_price"] ?>" checked>
                                <label class="form-check-label" for="check16">REFILL</label>
                            </div>
                            <div class="input-group mb-4">
                                <span class="input-group-text" id="basic-addon1">Quantity</span>
                                <input type="number" class="form-control shadow-none" id="quantity8" min="1" max="<?= $stocks[7]['total_quantity'] ?>" onkeyup="if(parseInt(this.value)>this.max){ this.value = this.max;}else if(parseInt(this.value) <= 0) {this.value = this.min } return false;" onkeypress="return /^[0-9]*$/.test(event.key)" <?= (int)$stocks[7]['total_quantity'] === 0 ? "disabled" : "" ?>>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div id="quantityFeedback8" class="invalid-feedback">
                                    Please input quantity...
                                </div>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-lg shadow-none rippleButton ripple" id="cart8" <?= (int)$stocks[7]['total_quantity'] === 0 ? "disabled" : "" ?>><i class="fas fa-cart-plus"></i> Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </fieldset>
    </div>
    <div class="row shadow p-5 mb-3 bg-body rounded">
        <fieldset class="border p-5 bg-body">
            <legend class="float-none w-auto">CART LIST</legend>
            <div class="table-responsive my-5">
                <table id="customerTable" class="tableDesign table table-striped table-hover align-middle">
                    <thead class="align-middle">
                        <tr>
                            <th>Sales Invoice</th>
                            <th>Product Picture</th>
                            <th>Product Name</th>
                            <th>Buying Option</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <tr>
                            <td>PTR-123</td>
                            <td><img src="assets/product-img/50kg.png" alt=""></td>
                            <td>Petron 50kg</td>
                            <td>Refill</td>
                            <td>1</td>
                            <td>10000</td>
                            <td><button type="button" class="btn btn-danger shadow-none">Remove</button></td>
                        </tr>
                        <tr>
                            <td>PTR-123</td>
                            <td><img src="assets/product-img/11kg.png" alt=""></td>
                            <td>Petron 11kg</td>
                            <td>Refill</td>
                            <td>1</td>
                            <td>900</td>
                            <td><button type="button" class="btn btn-danger shadow-none">Remove</button></td>
                        </tr> -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Sales Invoice</th>
                            <th>Product Picture</th>
                            <th>Product Name</th>
                            <th>Buying Option</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="container px-4">
                <div class="p-3 text-center">
                    <p>
                    <h6 class="display-6" style="font-weight: 400;">Total Price: <span id ="totalPriceOverall" style="font-weight: 100;">0</span></h6>
                    </p>
                </div>
                <div class="p-3 text-end ">
                    <button class="btn btn-lg shadow-none rippleButton ripple ms-3"><i class="fas fa-money-check"></i>
                        CHECK OUT </button>
                </div>
            </div>

        </fieldset>
    </div>
    <?php require_once 'loader.php' ?>
</div>
<?php require_once 'footer.php' ?>

<script src="js/magnify.js"></script>
<script src="//code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script>
    $(document).ready(function() {

        for (let x = 1; x <= 8; x++) {
            $(document).on('change', '.getCheck' + x, {
                "classx": x
            }, function(e) {
                e.preventDefault();
                $('#price' + e.data.classx).text($('.getCheck' + e.data.classx + ':checked').val());
            });
            $(document).on('keyup', '#quantity' + x, {
                "classx": x
            }, function() {
                if ($(this).val() === "" || parseInt($(this).val()) === 0) {
                    $('#quantityFeedback' + e.data.classx).text('Please input quantity...');
                    $(this).removeClass('is-valid');
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).addClass('is-valid');
                }
            });
            $(document).on('click', '#cart' + x, {
                "classx": x
            }, function(e) {
                e.preventDefault();
                $("#loader").fadeIn();
                if (!$('#quantity' + e.data.classx).val() || $('#quantity' + e.data.classx).val() === "") {
                    $('#quantityFeedback' + e.data.classx).text('Please input quantity...');
                    $('#quantity' + e.data.classx).removeClass('is-valid');
                    $('#quantity' + e.data.classx).addClass('is-invalid');
                    $("#loader").fadeOut();
                } else if (parseInt($('#stocks' + e.data.classx).text()) === 0) {
                    $('#quantityFeedback' + e.data.classx).text('Out of Stocks...');
                    $('#quantity' + e.data.classx).removeClass('is-valid');
                    $('#quantity' + e.data.classx).addClass('is-invalid');
                    $("#loader").fadeOut();
                } else if (parseInt($('#stocks' + e.data.classx).text()) < parseInt($('#quantity' + e.data.classx).val())) {
                    $('#quantityFeedback' + e.data.classx).text('Insufficient Stocks...');
                    $('#quantity' + e.data.classx).removeClass('is-valid');
                    $('#quantity' + e.data.classx).addClass('is-invalid');
                    $("#loader").fadeOut();
                } else {
                    var checker = false;
                    $("#customerTable tbody tr").each(function(i, el) {
                        var dProduct = $(el).children().eq(2).text();
                        var dOption = $(el).children().eq(3).text();
                        var dQuantity = $(el).children().eq(4).text();
                        var dPrice = $(el).children().eq(5).text();
                        if ($('#product' + e.data.classx).text() === dProduct && $('.getCheck' + e.data.classx + ':checked').next().text() === dOption) {
                            $(this).children(":eq(4)").text(parseInt(dQuantity) + parseInt($('#quantity' + e.data.classx).val()));
                            $(this).children(":eq(5)").text(parseInt($(this).children(":eq(5)").text()) + parseInt($('#quantity' + e.data.classx).val()) * parseFloat($('#price' + e.data.classx).text()));
                            $('#stocks' + e.data.classx).html(parseInt($('#stocks' + e.data.classx).text()) - parseInt($('#quantity' + e.data.classx).val()));
                            $('#totalPriceOverall').html(parseFloat($('#totalPriceOverall').text()) + (parseInt($('#quantity' + e.data.classx).val()) * parseFloat($('#price' + e.data.classx).text())));
                            $("#loader").fadeOut();
                            checker = true;
                        }

                    });
                    if (!checker) {
                        var image = "";
                        if (e.data.classx === 1) {
                            image = "assets/product-img/50kg.png";
                        } else if (e.data.classx === 2) {
                            image = "assets/product-img/22kg.png";
                        } else if (e.data.classx === 3) {
                            image = "assets/product-img/11kg.png";
                        } else if (e.data.classx === 4) {
                            image = "assets/product-img/11kg.png";
                        } else if (e.data.classx === 5) {
                            image = "assets/product-img/7kg.png";
                        } else if (e.data.classx === 6) {
                            image = "assets/product-img/7kg.png";
                        } else if (e.data.classx === 7) {
                            image = "assets/product-img/2.7kg.png";
                        } else {
                            image = "assets/product-img/2.7kg.png";
                        }
                        var price = parseInt($('#quantity' + e.data.classx).val()) * parseFloat($('#price' + e.data.classx).text());

                        $('#stocks' + e.data.classx).html(parseInt($('#stocks' + e.data.classx).text()) - parseInt($('#quantity' + e.data.classx).val()));

                        $('#totalPriceOverall').html(parseFloat($('#totalPriceOverall').text()) + (parseInt($('#quantity' + e.data.classx).val()) * parseFloat($('#price' + e.data.classx).text())));

                        customerTable.row.add($('<tr class = "item" ><td>' + $('#salesInvoice').val() + '</td>' + '<td><img src="' + image + '" alt=""></td><td class = "tdProduct">' + $('#product' + e.data.classx).text() + '</td><td>' + $('.getCheck' + e.data.classx + ':checked').next().text() + '</td><td class = "tdQuantity">' + $('#quantity' + e.data.classx).val() + '</td><td class = "tdPrice">' + price + '</td>' + '<td><button type="button" class="btn btn-danger shadow-none deleteRow">Remove</button></td></tr>')).draw();
                        
                        $("#loader").fadeOut();
                    }

                }
            });
            $('#customerTable tbody').on('click', '.deleteRow', {
                "classx": x
            }, function(e) {
                e.preventDefault();
                $("#loader").fadeIn();
                if ($(this).parents('tr').children().eq(2).text() === $('#product' + e.data.classx).text()) {
                    $('#stocks' + e.data.classx).html(parseInt($(this).parents('tr').children().eq(4).text()) + parseInt($('#stocks' + e.data.classx).text()));
                    $('#totalPriceOverall').html(parseFloat($('#totalPriceOverall').text()) - parseFloat($(this).parents('tr').children().eq(5).text()));
                }
                customerTable.row($(this).parents('tr')).remove().draw();
                $("#loader").fadeOut();
            });
        }



        $('.zoom').magnify();
        var today = new Date().toLocaleString();
        $('[data-toggle="tooltip"]').tooltip();

        // $("[type='number']").keypress(function(evt) {
        //     evt.preventDefault();
        // });
        $(document).on('click', '#addToCart', function() {
            alert('hello')

        });
        var customerTable = $('#customerTable').DataTable({
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": true,
            lengthMenu: [5, 10],
            "columnDefs": [{
                    targets: [4, 5],
                    className: "text-end"
                },
                {
                    targets: [2, 3],
                    className: "text-justify"
                },
                {
                    targets: [6],
                    className: "text-center"
                },
                {
                    orderable: false,
                    targets: [0, 1, 6]
                }
            ]
        });


        var availableTags = [];

        $(window).on('load', function() {

            let datastring = {
                "gettingCustomerName": "get"
            };

            $.ajax({
                url: 'includes/sales-add.inc.php',
                type: 'POST',
                data: datastring,
                dataType: 'json',
                success: function(data) {

                    if (data.status) {
                        for (let x = 0; x < data.customerInfo.length; x++) {
                            var tags = data.customerInfo[x]['customer_phone_number'] + ' - ' + data.customerInfo[x]['customer_first_name'] + ' ' + data.customerInfo[x]['customer_middle_name'] + ' ' + data.customerInfo[x]['customer_last_name'];
                            availableTags.push(tags);
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


        });
        $(function() {
            $("#tags").autocomplete({
                source: availableTags
            });
        });
        $(document).on('change', '#tags', function() {

            let tagVal = $('#tags').val();
            let phoneNumber = tagVal.substr(0, 10);
            let name = tagVal.substr(14, tagVal.length);
            console.log(phoneNumber)
            console.log(name)
        });
    });
</script>