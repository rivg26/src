<?php require_once 'head.php' ?>
<div class="container shadow p-3 mb-5 bg-body rounded">
    <div class="text-center">
        <h5 class="display-4 mb-5 mt-3"><i class="fas fa-hands-helping"></i> Help Center</h5>
    </div>
    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button shadow-none" type="button " data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    • Add Product Purchase
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    – On the menu panel, extract Sales Management and select <em>“Add Sales”</em>. Search the name of the customer if registered or click “new” if the customer is new and provide the requirements required for the customer’s information. Select the product, product type and input the quantity to be purchased. After completing the form, click <em>“Submit”</em> to save the purchase details.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    • Adding Customer
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    – Go to Customer Management section in the menu. Click <em>“Add New Customer”</em>, and fill the input requirements with valid data. Click <em>“Submit” </em> at the bottom of the form to save.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    • Edit/Update Customer Information
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    – On the Customer Management section, click <em>“Customer List”</em>. Look or search for the name of the customer to be updated and click <em>“view” </em> with the yellow icon. Click <em>“Update”</em> at the bottom of the form and edit the data to change. Click <em>“Submit”</em> to save changes.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    • Add Product Inbound
                </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    – Go to Inventory Management section in the menu. Click <em>“Add Product Inbound”</em>, and fill the input requirements regarding the supplier and products delivered. Click <em>“Submit”</em> to save the data and to create a Total Inventory Report. You can add more product inbound if the supply includes not only one product type. If the Total Inventory Report is complete, click <em>“Save Table”</em> to save all the product inbounds.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingFive">
                <button class="accordion-button collapsed shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                    • Change Password
                </button>
            </h2>
            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    – Click the Settings icon at the bottom of the Menu Panel. Click <em>“Change Password”</em>, input the old password and the new password to change. Click <em>“Save”</em> to submit.
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5 ">
        
        <div class="card">
            <div class="card-body">
            <p style="font-size: 1.5rem " class=""> <i class="fas fa-id-card"></i> Contact Support: </p>
            <div class="row d-flex flex-row justify-content-center align-items-center text-center">
                <div class="col-md-4"><i class="fas fa-user-tie"></i> Ron Ivin V. Gregorio - 09264102938</div>
                <div class="col-md-4"><i class="fas fa-user-tie"></i> Jhames Sabellano - 09554236069 </div>
                <div class="col-md-4"><i class="fas fa-user-tie"></i> Mary Jane Araza - 09129129642</div>
            </div>
            </div>
        </div>
    </div>
</div>
<?php require_once 'loader.php' ?>
<?php require_once 'footer.php' ?>