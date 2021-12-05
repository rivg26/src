<?php require_once 'head.php' ?>
<div class="container">
    <div class="shadow p-5 mb-5 bg-body rounded">
        <div class="text-center">
            <h5 class="display-4 mb-5 mt-3">View Delivery</h5>
        </div>
        <div class="row d-flex align-items-center flex-column justify-content-center ">
            <div class="col-md-5 mt-4">
                <label for="exampleInputEmail1" class="form-label">Date</label>
                <input type="date" class="form-control shadow-none" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
            </div>
            <div class="col-md-5 mt-2">
                <label for="exampleInputEmail1" class="form-label">Sales Invoice</label>
                <input type="text" class="form-control shadow-none" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
            </div>
            <div class="col-md-5 mt-2">
                <label for="exampleInputEmail1" class="form-label">Transaction Number</label>
                <input type="text" class="form-control shadow-none" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
            </div>
            <div class="col-md-5 mt-2">
                <label for="exampleInputEmail1" class="form-label">Delivery Status</label>
                <select class="form-select shadow-none" aria-label="Default select example">
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
        </div>
        <div class="text-center mt-5">
            <button class="btn btn-lg shadow-none rippleButton ripple no-printme">SUBMIT</button>
            <button class="btn btn-lg shadow-none rippleButton ripple no-printme">CANCEL</button>
        </div>
    </div>
</div>
<?php require_once 'footer.php' ?>