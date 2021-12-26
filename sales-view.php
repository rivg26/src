<?php require_once 'head.php' ?>
<?php


if(isset($_GET['salesInvoice'])){
    $data = getSalesData($conn, $_GET['salesInvoice']);
}


?>
<div class="container" style="position: relative;">
    <div class="shadow p-5 mb-5 bg-body rounded printme">
        <div class="text-center">
            <h5 class="display-4 mb-5 mt-3">Sales Details</h5>
        </div>
        <div class="row mt-5 d-flex flex-row justify-content-between">
            <div class="col-md-3 mb-3">
                <label for="exampleInputEmail1" class="form-label">Purchase Date</label>
                <input type="date" class="form-control shadow-none" value= "<?= $data['sales_purchase_date'] ?>"readonly>
            </div>
            <div class="col-md-3 mb-3">
                <label for="exampleInputEmail1" class="form-label">Sales Invoice</label>
                <input type="text" class="form-control shadow-none" value= "<?= $data['sales_invoice'] ?>"  readonly>
            </div>
        </div>
        <div class="row">
            
            <div class="col-md-4 mb-3">
                <label for="exampleInputEmail1" class="form-label">Customer Name</label>
                <input type="text" class="form-control shadow-none" value= "<?= $data['customer_name'] ?>" readonly>
            </div>
            <div class="col-md-4 mb-3">
                <label for="exampleInputEmail1" class="form-label">Encoder Name</label>
                <input type="text" class="form-control shadow-none" value= "<?= $data['emp_name']  ?>" readonly>
            </div>
            <div class="col-md-4 mb-3">
                <label for="exampleInputEmail1" class="form-label">Payment Status</label>
                <input type="text" class="form-control shadow-none" value= "<?= $data['sales_status'] ?>" readonly>
            </div>
        </div>
        <div class="row" id="itemTableContainer"> 
            <div class="col-md-6 mb-3">
                <label for="exampleInputEmail1" class="form-label">Total Quantity</label>
                <input type="text" class="form-control shadow-none" value= "<?= number_format($data['sales_total_quantity'], 2) ?>" readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label for="exampleInputEmail1" class="form-label">Total Amount</label>
                <input type="text" class="form-control shadow-none" value= "<?= number_format($data['sales_total_price'],2) ?>" readonly>
            </div>
        </div>

        <div class="table-responsive mt-5" >
            <table id="itemTable" class="tableDesign table table-striped table-hover align-middle shadow-none">
                <thead class="align-middle">
                    <tr>
                        <th>Sales Invoice</th>
                        <th>Product Name</th>
                        <th>Product Option</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                <?= salesItemTable($conn,$data['sales_invoice']) ?>
                </tbody>
                <tfoot class="no-printme">
                    <tr>
                        <th>Sales Invoice</th>
                        <th>Product Name</th>
                        <th>Product Option</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="text-center mt-5 no-printme">
            <button class="btn btn-lg shadow-none rippleButton ripple no-printme" onclick="window.print();">Print</button>
        </div>
    </div>
    <?php require_once 'loader.php' ?>
</div>
<?php require_once 'footer.php' ?>
<script>
    $(document).ready(function(){
        $('#itemTable').DataTable({
            "searching": false,
            "bPaginate": false,
            "lengthChange": true,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": true,
            "columnDefs": [{
                    targets: [3,4],
                    className: "text-end"
                },
                {
                    targets: [1],
                    className: "text-justify"
                },
                {
                    targets: [0,2],
                    className: "text-center"
                },
            ]
        });
    });
</script>