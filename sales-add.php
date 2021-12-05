<?php require_once 'head.php' ?>
<link rel="stylesheet" href="css/magnify.css">
<link rel="stylesheet" href="css/sales-add.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<div class="row">
    <div class="row shadow p-5 mb-4 bg-body rounded  mt-3">
        <div class="text-center">
            <h5 class="display-4 mb-5 mt-3">Add Sales</h5>
        </div>
        <div class="mb-3 row">
            <label for="tags" class="col-sm-1 col-form-label" style="font-size: 0.82rem;">Customer Name</label>
            <div class="col-sm-3">
                <input type="text" class="form-control shadow-none" id="tags">
            </div>
            <button class="col-sm-1 btn btn-success" data-toggle="tooltip" title="Add New Customer" data-bs-placement="right"><i class="fas fa-user-plus"></i> NEW</button>
        </div>
        <fieldset class="border mt-5 p-5  g-5 bg-light">
            <legend class="float-none w-auto">CART</legend>
            <div class="parent">
                <div class="child">
                    <div class="card" style="width: 18rem;">
                        <img src="assets/product-img/50kg.png" data-magnify-src="assets/product-img/50kg.png" class="card-img-top p-5 zoom" alt="..." data-toggle="tooltip" title="PETRON GASUL 50 KILOS ">
                        <div class="card-body">
                            <h5 class="card-title mb-5">PETRON GASUL 50 KILOS</h5>
                            <div class="d-flex justify-content-between mt-3">
                                <p class="card-text">PHP 993.00</p>
                                <p class="card-text">Stocks: 95</p>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input " type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Refill Tank
                                </label>
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    New Set Tank
                                </label>
                            </div>
                            <div class="input-group mb-4">
                                <span class="input-group-text" id="basic-addon1">Quantity</span>
                                <input type="number" class="form-control shadow-none" placeholder="" aria-label="" aria-describedby="" max="3" min="1">
                            </div>
                            <div class="text-center">
                                <button class="btn btn-lg shadow-none rippleButton ripple"><i class="fas fa-cart-plus"></i> Add toCart</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="child">
                    <div class="card" style="width: 18rem;">
                        <img src="assets/product-img/22kg.png" class="card-img-top p-5 zoom" alt="..." data-magnify-src="assets/product-img/22kg.png" data-toggle="tooltip" title="PETRON GASUL 22 KILOS">
                        <div class="card-body">
                            <h5 class="card-title mb-5">PETRON GASUL 22 KILOS</h5>
                            <div class="d-flex justify-content-between mt-3">
                                <p class="card-text">PHP 993.00</p>
                                <p class="card-text">Stocks: 95</p>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Refill Tank
                                </label>
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    New Set Tank
                                </label>
                            </div>
                            <div class="input-group mb-4">
                                <span class="input-group-text" id="basic-addon1">Quantity</span>
                                <input type="number" class="form-control shadow-none" placeholder="" aria-label="" aria-describedby="" max="3" min="1">
                            </div>
                            <div class="text-center">
                                <button class="btn btn-lg shadow-none rippleButton ripple"><i class="fas fa-cart-plus"></i> Add to
                                    Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="child">
                    <div class="card" style="width: 18rem;">
                        <img src="assets/product-img/11kg.png" data-magnify-src="assets/product-img/11kg.png" class="card-img-top p-5 zoom" alt="..." data-toggle="tooltip" title="PETRON GASUL 11 KILOS Compact-Valve Type ('de salpak')">
                        <div class="card-body">
                            <h5 class="card-title mb-5">PETRON GASUL 11 KILOS Compact-Valve Type ("de salpak")</h5>
                            <div class="d-flex justify-content-between mt-3">
                                <p class="card-text">PHP 993.00</p>
                                <p class="card-text">Stocks: 95</p>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Refill Tank
                                </label>
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    New Set Tank
                                </label>
                            </div>
                            <div class="input-group mb-4">
                                <span class="input-group-text" id="basic-addon1">Quantity</span>
                                <input type="number" class="form-control shadow-none" placeholder="" aria-label="" aria-describedby="" max="3" min="1">
                            </div>
                            <div class="text-center">
                                <button class="btn btn-lg shadow-none rippleButton ripple"> <i class="fas fa-cart-plus"></i> Add to
                                    Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="child">
                    <div class="card" style="width: 18rem;">
                        <img src="assets/product-img/11kg.png" data-magnify-src="assets/product-img/11kg.png" class="card-img-top p-5 zoom" alt="..." data-toggle="tooltip" title="PETRON GASUL 11 KILOS POL Type ('de roskas')">
                        <div class="card-body">
                            <h5 class="card-title mb-5">PETRON GASUL 11 KILOS POL Type ("de roskas")</h5>
                            <div class="d-flex justify-content-between mt-3">
                                <p class="card-text">PHP 993.00</p>
                                <p class="card-text">Stocks: 95</p>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Refill Tank
                                </label>
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    New Set Tank
                                </label>
                            </div>
                            <div class="input-group mb-4">
                                <span class="input-group-text" id="basic-addon1">Quantity</span>
                                <input type="number" class="form-control shadow-none" placeholder="" aria-label="" aria-describedby="" max="3" min="1">
                            </div>
                            <div class="text-center">
                                <button class="btn btn-lg shadow-none rippleButton ripple"> <i class="fas fa-cart-plus"></i> Add to
                                    Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="child">
                    <div class="card" style="width: 18rem;">
                        <img src="assets/product-img/7kg.png" data-magnify-src="assets/product-img/7kg.png" class="card-img-top p-5 zoom" alt="..." data-toggle="tooltip" title="PETRON GASUL 7 KILOS Compact-Valve Type ('de salpak')">
                        <div class="card-body">
                            <h5 class="card-title mb-5">PETRON GASUL 7 KILOS Compact-Valve Type ("de salpak")</h5>
                            <div class="d-flex justify-content-between mt-3">
                                <p class="card-text">PHP 993.00</p>
                                <p class="card-text">Stocks: 95</p>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Refill Tank
                                </label>
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    New Set Tank
                                </label>
                            </div>
                            <div class="input-group mb-4">
                                <span class="input-group-text" id="basic-addon1">Quantity</span>
                                <input type="number" class="form-control shadow-none" placeholder="" aria-label="" aria-describedby="" max="3" min="1">
                            </div>
                            <div class="text-center">
                                <button class="btn btn-lg shadow-none rippleButton ripple"><i class="fas fa-cart-plus"></i> Add to
                                    Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="child">
                    <div class="card" style="width: 18rem;">
                        <img src="assets/product-img/7kg.png" data-magnify-src="assets/product-img/7kg.png" class="card-img-top p-5 zoom" alt="..." data-toggle="tooltip" title="PETRON GASUL 7 KILOS POL Type ('de roskas')">
                        <div class="card-body">
                            <h5 class="card-title mb-5">PETRON GASUL 7 KILOS POL Type ("de roskas")</h5>
                            <div class="d-flex justify-content-between mt-3">
                                <p class="card-text">PHP 993.00</p>
                                <p class="card-text">Stocks: 95</p>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Refill Tank
                                </label>
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    New Set Tank
                                </label>
                            </div>
                            <div class="input-group mb-4">
                                <span class="input-group-text" id="basic-addon1">Quantity</span>
                                <input type="number" class="form-control shadow-none" placeholder="" aria-label="" aria-describedby="" max="3" min="1">
                            </div>
                            <div class="text-center">
                                <button class="btn btn-lg shadow-none rippleButton ripple"><i class="fas fa-cart-plus"></i> Add to
                                    Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="child">
                    <div class="card" style="width: 18rem;">
                        <img src="assets/product-img/2.7kg.png" data-magnify-src="assets/product-img/2.7kg.png" class="card-img-top p-5 zoom" alt="..." data-toggle="tooltip" title="PETRON GASUL 2.7 KILOS Compact-Valve Type ('de salpak')">
                        <div class="card-body">
                            <h5 class="card-title mb-5">PETRON GASUL 2.7 KILOS Compact-Valve Type ("de salpak")</h5>
                            <div class="d-flex justify-content-between mt-3">
                                <p class="card-text">PHP 993.00</p>
                                <p class="card-text">Stocks: 95</p>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Refill Tank
                                </label>
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    New Set Tank
                                </label>
                            </div>
                            <div class="input-group mb-4">
                                <span class="input-group-text" id="basic-addon1">Quantity</span>
                                <input type="number" class="form-control shadow-none" placeholder="" aria-label="" aria-describedby="" max="3" min="1">
                            </div>
                            <div class="text-center">
                                <button class="btn btn-lg shadow-none rippleButton ripple"><i class="fas fa-cart-plus"></i> Add to
                                    Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="child">
                    <div class="card" style="width: 18rem;">
                        <img src="assets/product-img/2.7kg.png" data-magnify-src="assets/product-img/2.7kg.png" class="card-img-top p-5 zoom" alt="..." data-toggle="tooltip" title="PETRON GASUL 2.7 KILOS POL Type ('de roskas')">
                        <div class="card-body">
                            <h5 class="card-title mb-5">PETRON GASUL 2.7 KILOS POL Type ("de roskas")</h5>
                            <div class="d-flex justify-content-between mt-3">
                                <p class="card-text">PHP 993.00</p>
                                <p class="card-text">Stocks: 95</p>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Refill Tank
                                </label>
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    New Set Tank
                                </label>
                            </div>
                            <div class="input-group mb-4">
                                <span class="input-group-text" id="basic-addon1">Quantity</span>
                                <input type="number" class="form-control shadow-none" placeholder="" aria-label="" aria-describedby="" max="3" min="1">
                            </div>
                            <div class="text-center">
                                <button class="btn btn-lg shadow-none rippleButton ripple" id="addToCart"> <i class="fas fa-cart-plus"></i> Add to Cart </button>
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
                            <th class="noExport">Product Picture</th>
                            <th>Product Name</th>
                            <th>Buying Option</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th class="noExport"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>PTR-123</td>
                            <td class="noExport"><img src="assets/product-img/50kg.png" alt=""></td>
                            <td>Petron 50kg</td>
                            <td>Refill</td>
                            <td>1</td>
                            <td>10000</td>
                            <td class="noExport"><button type="button" class="btn btn-danger shadow-none">Remove</button></td>
                        </tr>
                        <tr>
                            <td>PTR-123</td>
                            <td class="noExport"><img src="assets/product-img/11kg.png" alt=""></td>
                            <td>Petron 11kg</td>
                            <td>Refill</td>
                            <td>1</td>
                            <td>900</td>
                            <td class="noExport"><button type="button" class="btn btn-danger shadow-none">Remove</button></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="noExport">
                            <th>Sales Invoice</th>
                            <th class="noExport">Product Picture</th>
                            <th>Product Name</th>
                            <th>Buying Option</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th class="noExport"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="container px-4">
                <div class="p-3 text-center">
                    <p>
                    <h6 class="display-6" style="font-weight: 400;">Total Price: <span style="font-weight: 100;"> 10,000</span></h6>
                    </p>
                </div>
                <div class="p-3 text-end ">
                    <button class="btn btn-lg shadow-none rippleButton ripple ms-3"><i class="fas fa-money-check"></i>
                        CHECK OUT </button>
                </div>
            </div>

        </fieldset>
    </div>
</div>
<?php require_once 'footer.php' ?>

<script src="js/magnify.js"></script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script>
    $(document).ready(function() {
        $('.zoom').magnify();
        var today = new Date().toLocaleString();
        $('[data-toggle="tooltip"]').tooltip();

        $("[type='number']").keypress(function(evt) {
            evt.preventDefault();
        });
        $(document).on('click', '#addToCart', function() {
            alert('hello')

        });
        $('#customerTable').DataTable({
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
        $(function() {
            var availableTags = [
                "09264102938 - Ron Ivin V. Gregorio",
                "09129129642 - Mary Jane Araza",
            ];
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