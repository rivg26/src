<?php require_once 'head.php' ?>
<div class="container" style="position: relative;">
    <div class="mx-auto shadow p-5 my-5 bg-white rounded justify-content-center printme">
        <div class="text-center ">
            <h5 class=" display-4 mb-5">Add Defective Product</h5>
        </div>
        <div class="row mt-5 mb-4">
            <div class="col-md-3">
                <label for="exampleInputEmail1" class="form-label">Date</label>
                <input type="date" class="form-control shadow-none" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 mb-3">
                <label for="exampleInputEmail1" class="form-label">Product Invoice Number</label>
                <select class="form-select shadow-none" aria-label="Default select example">
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label for="exampleInputEmail1" class="form-label">Product Name</label>
                <input type="number" class="form-control shadow-none" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
            </div>
            <div class="col-md-3 mb-3">
                <label for="exampleInputEmail1" class="form-label">Quantity</label>
                <input type="number" class="form-control shadow-none" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
            </div>
            <div class="col-md-3 mb-3">
                <label for="exampleInputEmail1" class="form-label">Product Problem</label>
                <select class="form-select shadow-none" aria-label="Default select example">
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label for="exampleFormControlTextarea1" class="form-label">Remarks</label>
                <textarea class="form-control shadow-none" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
        </div>
        <div class="text-center mt-5 no-printme">
            <button class="btn btn-lg shadow-none rippleButton ripple no-printme" onclick="window.print();">Print</button>
            <button class="btn btn-lg shadow-none rippleButton ripple no-printme">SUBMIT</button>
            <button class="btn btn-lg shadow-none rippleButton ripple no-printme">CANCEL</button>
        </div>
    </div>
    <?php require_once 'loader.php' ?>
</div>
<?php require_once 'footer.php' ?>