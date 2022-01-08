<?php require_once 'head.php' ?>
<style>
    @font-face {
        font-family: Dashboard;
        src: url('assets/fonts/Dashboard-Regular.ttf');
    }

    .weightFont {
        font-family: Dashboard;
        color: #fff;
    }

    p {
        color: #fff;
    }

    .moneySize {
        color: #00ff00;
    }

    .htmlembed-page-title{
        display: none !important;
    }

    @media only screen and (max-width: 1920px) {
        .img-size {
            width: 7rem;
            height: 5.6rem;
        }

        .quantitySize {
            font-size: 1.5rem;
            font-weight: 500;
        }

    }

    @media only screen and (max-width: 1400px) {
        p {
            font-size: 0.5rem;
        }

        .img-size {
            width: 5rem;
            height: 6rem;
        }

        .moneySize {
            font-size: 0.6rem;
        }

        .typeSize {
            font-size: 0.8rem;
        }
    }
</style>
<div class="container-fluid" style="position: relative; ">
    <div class="row">
        <div class="col-md-6 d-flex flex-column align-items-center justify-content-center ">
            <div class="container px-4 ">
                <div class="row gx-5 mb-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4 rounded-start" style="background-color: #2a2a72;">
                                <div class="row mt-3 mb-2">
                                    <img src="assets/logo/gas-icon.png" class="img-size" alt="">
                                </div>
                                <div class="row text-center">
                                    <p class="weightFont">50KG</p>
                                </div>
                            </div>
                            <div class="col-md-8 rounded-end" style="background-color: #2a2a72;opacity: 90%;">
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <p class="mb-1 typeSize">REFILL</p>
                                        <p class="moneySize">₱ 2,200.00</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1 typeSize">NEW</p>
                                        <p class="moneySize">₱ 3,200.00</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="text-center">
                                        <p class="mb-1 typeSize">Total Quantity</p>
                                        <p class="mb-0 link-info quantitySize">50 <i class="fas fa-caret-up"></i></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4 rounded-start" style="background-color: #1b2f33;">
                                <div class="row mt-3 mb-2">
                                    <img src="assets/logo/gas-icon.png" class="img-size" alt="">
                                </div>
                                <div class="row text-center">
                                    <p class="weightFont">22KG</p>
                                </div>
                            </div>
                            <div class="col-md-8 rounded-end" style="background-color: #1b2f33;opacity: 90%;">
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <p class="mb-1 typeSize">REFILL</p>
                                        <p class="moneySize">₱ 2,200.00</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1 typeSize">NEW</p>
                                        <p class="moneySize">₱ 3,200.00</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="text-center">
                                        <p class="mb-1 typeSize">Total Quantity</p>
                                        <p class="mb-0 link-warning quantitySize">5 <i class="fas fa-caret-down"></i></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row gx-5 mb-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4 rounded-start" style="background-color: #28231c;">
                                <div class="row mt-3 mb-2">
                                    <img src="assets/logo/gas-icon.png" class="img-size" alt="">
                                </div>
                                <div class="row text-center">
                                    <p class="weightFont">11KG CVT</p>
                                </div>
                            </div>
                            <div class="col-md-8 rounded-end" style="background-color: #28231c;opacity: 90%;">
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <p class="mb-1 typeSize">REFILL</p>
                                        <p class="moneySize">₱ 2,200.00</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1 typeSize">NEW</p>
                                        <p class="moneySize">₱ 3,200.00</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="text-center">
                                        <p class="mb-1 typeSize">Total Quantity</p>
                                        <p class="mb-0 link-danger quantitySize">0 <i class="fas fa-caret-down"></i></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4 rounded-start" style="background-color: #2d232e;">
                                <div class="row mt-3 mb-2">
                                    <img src="assets/logo/gas-icon.png" class="img-size" alt="">
                                </div>
                                <div class="row text-center">
                                    <p class="weightFont">11KG PVT</p>
                                </div>
                            </div>
                            <div class="col-md-8 rounded-end" style="background-color: #2d232e;opacity: 90%;">
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <p class="mb-1 typeSize">REFILL</p>
                                        <p class="moneySize">₱ 2,200.00</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1 typeSize">NEW</p>
                                        <p class="moneySize">₱ 3,200.00</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="text-center">
                                        <p class="mb-1 typeSize">Total Quantity</p>
                                        <p class="mb-0 link-warning quantitySize">5 <i class="fas fa-caret-down"></i></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row gx-5 mb-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4 rounded-start" style="background-color: #3f292b;">
                                <div class="row mt-3 mb-2">
                                    <img src="assets/logo/gas-icon.png" class="img-size" alt="">
                                </div>
                                <div class="row text-center">
                                    <p class="weightFont">7KG CVT</p>
                                </div>
                            </div>
                            <div class="col-md-8 rounded-end" style="background-color: #3f292b;opacity: 90%;">
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <p class="mb-1 typeSize">REFILL</p>
                                        <p class="moneySize">₱ 2,200.00</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1 typeSize">NEW</p>
                                        <p class="moneySize">₱ 3,200.00</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="text-center">
                                        <p class="mb-1 typeSize">Total Quantity</p>
                                        <p class="mb-0 link-warning quantitySize">5 <i class="fas fa-caret-down"></i></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4 rounded-start" style="background-color: #03012c;">
                                <div class="row mt-3 mb-2">
                                    <img src="assets/logo/gas-icon.png" class="img-size" alt="">
                                </div>
                                <div class="row text-center">
                                    <p class="weightFont">7KG PVT</p>
                                </div>
                            </div>
                            <div class="col-md-8 rounded-end" style="background-color: #03012c;opacity: 90%;">
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <p class="mb-1 typeSize">REFILL</p>
                                        <p class="moneySize">₱ 2,200.00</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1 typeSize">NEW</p>
                                        <p class="moneySize">₱ 3,200.00</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="text-center">
                                        <p class="mb-1 typeSize">Total Quantity</p>
                                        <p class="mb-0 link-info quantitySize">100 <i class="fas fa-caret-up"></i></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row gx-5">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4 rounded-start" style="background-color: #1f0318;">
                                <div class="row mt-3 mb-2">
                                    <img src="assets/logo/gas-icon.png" class="img-size" alt="">
                                </div>
                                <div class="row text-center">
                                    <p class="weightFont">2.7KG CVT</p>
                                </div>
                            </div>
                            <div class="col-md-8 rounded-end" style="background-color: #1f0318;opacity: 90%;">
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <p class="mb-1 typeSize">REFILL</p>
                                        <p class="moneySize">₱ 2,200.00</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1 typeSize">NEW</p>
                                        <p class="moneySize">₱ 3,200.00</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="text-center">
                                        <p class="mb-1 typeSize">Total Quantity</p>
                                        <p class="mb-0 link-info quantitySize">500 <i class="fas fa-caret-up"></i></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4 rounded-start" style="background-color: #20063b;">
                                <div class="row mt-3 mb-2">
                                    <img src="assets/logo/gas-icon.png" class="img-size" alt="">
                                </div>
                                <div class="row text-center">
                                    <p class="weightFont">2.7KG PVT</p>
                                </div>
                            </div>
                            <div class="col-md-8 rounded-end" style="background-color: #20063b;opacity: 90%;">
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <p class="mb-1 typeSize">REFILL</p>
                                        <p class="moneySize">₱ 2,200.00</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1 typeSize">NEW</p>
                                        <p class="moneySize">₱ 3,200.00</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="text-center">
                                        <p class="mb-1 typeSize">Total Quantity</p>
                                        <p class="mb-0 link-info quantitySize">800 <i class="fas fa-caret-up"></i></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 ">
            <div class="row">
                <div class="col-md-12">
                    <iframe src="https://calendar.google.com/calendar/embed?height=600&amp;wkst=1&amp;bgcolor=%23f5f5f5&amp;ctz=Asia%2FManila&amp;src=Z3JlZ29yaW9yb24yNkBnbWFpbC5jb20&amp;src=YWRkcmVzc2Jvb2sjY29udGFjdHNAZ3JvdXAudi5jYWxlbmRhci5nb29nbGUuY29t&amp;src=Y2xhc3Nyb29tMTEzODgzNDE2ODQ1MjQyMTU5NDA4QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&amp;src=ZW4ucGhpbGlwcGluZXMjaG9saWRheUBncm91cC52LmNhbGVuZGFyLmdvb2dsZS5jb20&amp;src=Y3ZzdS5lZHUucGhfY2xhc3Nyb29tMjM5ZDk5NzJAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ&amp;color=%23039BE5&amp;color=%2333B679&amp;color=%230047a8&amp;color=%230B8043&amp;color=%23c26401&amp;showTitle=0" style="border:solid 1px #777;" width="750" height="300" frameborder="0" scrolling="yes" class="rounded"></iframe>
                </div>

            </div>
        </div>
    </div>
    <?php require_once 'loader.php' ?>
</div>
<?php require_once 'footer.php' ?>