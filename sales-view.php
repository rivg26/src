<?php require_once 'head.php' ?>
<div class="container" style="position: relative;">
    <div class="shadow p-5 mb-5 bg-body rounded printme">
        <div class="text-center">
            <h5 class="display-4 mb-5 mt-3">Sales Details</h5>
        </div>
        <div class="row mt-5">
            <div class="col-md-3 mb-3">
                <label for="exampleInputEmail1" class="form-label">Purchase Date</label>
                <input type="date" class="form-control shadow-none" id="exampleInputEmail1" placeholder="house/unit no.">
            </div>
        </div>
        <div class="row">
            <div class="col-md-5 mb-3">
                <label for="exampleInputEmail1" class="form-label">Sales Invoice</label>
                <input type="text" class="form-control shadow-none" id="exampleInputEmail1" placeholder="house/unit no.">
            </div>
            <div class="col-md-3 mb-3">
                <label for="exampleInputEmail1" class="form-label">Transaction ID</label>
                <input type="text" class="form-control shadow-none" id="exampleInputEmail1" placeholder="house/unit no.">
            </div>
            <div class="col-md-4 mb-3">
                <label for="exampleInputEmail1" class="form-label">Customer Name</label>
                <input type="text" class="form-control shadow-none" id="exampleInputEmail1" placeholder="house/unit no.">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="exampleInputEmail1" class="form-label">Payment Type</label>
                <select class="form-select shadow-none" aria-label="Default select example">
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="exampleInputEmail1" class="form-label">Payment Status</label>
                <select class="form-select shadow-none" aria-label="Default select example">
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="exampleInputEmail1" class="form-label">Total Amount</label>
                <input type="number" class="form-control shadow-none" id="exampleInputEmail1" placeholder="house/unit no.">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="exampleInputEmail1" class="form-label">Remarks</label>
                <textarea class="form-control shadow-none" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
        </div>

        <div class="table-responsive mt-5">
            <table id="productInboundTable" class="tableDesign table table-striped table-hover align-middle shadow-none">
                <thead class="align-middle">
                    <tr>
                        <th>Sales Invoice</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>PTR-123</td>
                        <td>Petron LPG Gasul 50KG Pol Valve</td>
                        <td>11</td>
                        <td>900.00</td>
                    </tr>
                </tbody>
                <tfoot class="no-printme">
                    <tr>
                        <th>Sales Invoice</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                    </tr>
                </tfoot>
            </table>
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