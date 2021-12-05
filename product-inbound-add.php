<?php require_once 'head.php' ?>

<div class="container " style="position: relative;">
    <div class="mx-auto shadow p-5 my-5 bg-white rounded justify-content-center">
        <div class="text-center ">
            <h5 class=" display-4 mb-5">Add Product Inbound</h5>
        </div>
        <div class="row d-flex flex-row justify-content-between mb-4">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="form-label">Invoice Number</label>
                    <input type="text" class="form-control shadow-none" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="form-label">Date Inbound</label>
                    <input type="date" class="form-control shadow-none" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                </div>
            </div>
        </div>
        <div class="row mb-3">

        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="form-label">Product</label>
                    <select class="form-select shadow-none" aria-label="Default select example">
                        <option selected>Open this select menu</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="form-label">Quantity</label>
                    <input type="number" class="form-control shadow-none" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="form-label">Metric Tons</label>
                    <input type="number" class="form-control shadow-none" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" readonly>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="form-label">Plant Price</label>
                    <input type="number" class="form-control shadow-none" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="form-label">Final Price</label>
                    <input type="number" class="form-control shadow-none" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1" class="form-label">Remarks</label>
                    <textarea class="form-control shadow-none" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <button class="btn btn-lg shadow-none rippleButton ripple" onClick="hello();">SUBMIT</button>
            <button class="btn btn-lg shadow-none rippleButton ripple" >Cancel</button>
        </div>
    </div>
    <?php require_once 'loader.php' ?>
</div>

<script>
    function hello() {
        console.log('hello');
    }
</script>
<?php require_once 'footer.php' ?>