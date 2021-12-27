<?php require_once 'head.php' ?>
<?php

date_default_timezone_set('Asia/Hong_Kong');
$today = date('d M Y', strtotime(date('Y-m-d')));
$yesterday = date('d M Y', strtotime("-1 days"));
$year = date("Y");


?>
<div class="row" style="position:relative">
    <div class="shadow p-5 mb-5 bg-body rounded">
        <div class="text-center">
            <h5 class="display-4 mb-5 mt-3">Delivery Report</h5>
        </div>

        <div class="table-responsive my-5 p-5">
            <div class="category-filter">
                <select id="categoryFilter" class="form-control shadow-none">
                    <option value="">Show All</option>
                    <optgroup label="Sort by Months">
                        <option value='<?php echo "Jan " . $year ?>'>January</option>
                        <option value='<?php echo "Feb " . $year ?>'>February</option>
                        <option value='<?php echo "Mar " . $year ?>'>March</option>
                        <option value='<?php echo "Apr " . $year ?>'>April</option>
                        <option value='<?php echo "May " . $year ?>'>May</option>
                        <option value='<?php echo "Jun " . $year ?>'>June</option>
                        <option value='<?php echo "Jul " . $year ?>'>July</option>
                        <option value='<?php echo "Aug " . $year ?>'>August</option>
                        <option value='<?php echo "Sep " . $year ?>'>September</option>
                        <option value='<?php echo "Oct " . $year ?>'>October</option>
                        <option value='<?php echo "Nov " . $year ?>'>November</option>
                        <option value='<?php echo "Dec " . $year ?>'>December</option>
                    </optgroup>
                    <optgroup label="Sort by Day">
                        <option value="<?= $today ?>" selected>Today</option>
                        <option value="<?= $yesterday ?>">Yesterday</option>
                    </optgroup>
                </select>
            </div>

            <table id="deliveryTable" class="tableDesign table table-striped table-hover align-middle shadow-none">
                <thead class="align-middle">
                    <tr>
                        <th>Delivery Date</th>
                        <th>Sales Invoice</th>
                        <th>Customer Name</th>
                        <th>Delivery Status</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>
                    <?= deliveryTable($conn); ?>

                </tbody>
                <tfoot>
                    <tr>
                        <th>Delivery Date</th>
                        <th>Sales Invoice</th>
                        <th>Customer Name</th>
                        <th>Delivery Status</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="deliveryModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delivery Confirmation <i class="fas fa-question-circle link-warning"></i></h5>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="deliveryQuestionBox">
                        Are you sure you it is delivered?
                    </div>
                    <div class="modal-body" id="deliverySuccessBox" style="display:none">
                        <div class="text-center alert alert-success"><i class="fas fa-check-circle"></i>Delivery Status Updated...</div>
                    </div>
                    <div class="modal-body" id="deliveryErrorBox" style="display:none">
                        <div class="text-center alert alert-danger"><i class="fas fa-times-circle"></i> Invalid Process...</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn shadow-none rippleButton ripple" id="btnDeliverySave">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="cancelModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirmation Cancellation <i class="fas fa-question-circle link-warning"></i></h5>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="cancelQuestionBox">
                        Are you sure you want to cancel it?
                    </div>
                    <div class="modal-body" id="cancelSuccessBox" style="display:none">
                        <div class="text-center alert alert-success"><i class="fas fa-check-circle"></i>Delivery Status Updated...</div>
                    </div>
                    <div class="modal-body" id="cancelErrorBox" style="display:none">
                        <div class="text-center alert alert-danger"><i class="fas fa-times-circle"></i> Invalid Process...</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn shadow-none rippleButton ripple" id="btnDeliveryCancel">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="salesInvoiceValue">
        <input type="hidden" id="statusValue">
        <?php require_once 'loader.php' ?>
    </div>
</div>
<?php require_once 'footer.php' ?>
<script>
    $(document).ready(function() {

        $(document).on('click', '#btnDelivered', function() {
            let rowId = $(this).attr('row.id');
            $('#salesInvoiceValue').val(rowId);
            // let getStatus = deliveryTable.row($(this).closest('tr')).data();
            // $('#statusValue').val(getStatus[3]);
        });
        $(document).on('click', '#btnCancel', function() {
            let rowId = $(this).attr('row.id');
            $('#salesInvoiceValue').val(rowId);
            // let getStatus = deliveryTable.row($(this).closest('tr')).data();
            // $('#statusValue').val(getStatus[3]);
        });

        $(document).on('click', '#btnDeliverySave', function() {
            let datastring = {
                "btnDeliverySave": $('#btnDeliverySave').val(),
                "salesInvoice": $('#salesInvoiceValue').val()
            };

            $.ajax({
                url: 'includes/delivery-report.inc.php',
                type: 'POST',
                data: datastring,
                dataType: 'json',
                error: function(request, error) {
                    console.log(error);
                },
                success: function(data) {

                    if (data.status) {
                        $('button').prop('disabled', true);
                        $('#deliveryQuestionBox').hide();
                        $('#deliverySuccessBox').show();
                        $('#btnDeliverySave').html("<span class='spinner-border spinner-border-sm ' id = 'loading' role='status' aria-hidden='true'></span>");
                        window.setTimeout(function() {
                            location.reload();
                        }, 1200);
                    } else {
                        $('button').prop('disabled', true);
                        $('#deliveryQuestionBox').hide();
                        $('#deliveryErrorBox').show();
                        $('#btnDeliverySave').html("<span class='spinner-border spinner-border-sm ' id = 'loading' role='status' aria-hidden='true'></span>");
                        window.setTimeout(function() {
                            location.reload();
                        }, 1200);
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

        $(document).on('click', '#btnDeliveryCancel', function(){
           
            let datastring = {
                "btnDeliveryCancel": $('#btnDeliveryCancel').val(),
                "salesInvoice": $('#salesInvoiceValue').val()
            };
            console.log(datastring)
            $.ajax({
                url: 'includes/delivery-report.inc.php',
                type: 'POST',
                data: datastring,
                dataType: 'json',
                error: function(request, error) {
                    console.log(error);
                },
                success: function(data) {

                    if (data.status) {
                        $('button').prop('disabled', true);
                        $('#cancelQuestionBox').hide();
                        $('#cancelSuccessBox').show();
                        $('#btnDeliveryCancel').html("<span class='spinner-border spinner-border-sm ' id = 'loading' role='status' aria-hidden='true'></span>");
                        window.setTimeout(function() {
                            location.reload();
                        }, 1200);
                        
                    } else {
                        $('button').prop('disabled', true);
                        $('#cancelQuestionBox').hide();
                        $('#cancelErrorBox').show();
                        $('#btnDeliveryCancel').html("<span class='spinner-border spinner-border-sm ' id = 'loading' role='status' aria-hidden='true'></span>");
                        window.setTimeout(function() {
                            location.reload();
                        }, 1200);
                        
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




        const popupCenter = ({
            url,
            title,
            w,
            h
        }) => {
            // Fixes dual-screen position                             Most browsers      Firefox
            const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screenX;
            const dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screenY;

            const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
            const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

            const systemZoom = width / window.screen.availWidth;
            const left = (width - w) / 2 / systemZoom + dualScreenLeft
            const top = (height - h) / 2 / systemZoom + dualScreenTop
            const newWindow = window.open(url, title,
                `
                scrollbars=yes,
                width=${w / systemZoom}, 
                height=${h / systemZoom}, 
                top=${top}, 
                left=${left}
                `
            )

            if (window.focus) newWindow.focus();
        }
        $(document).on('click', '#viewLocation', function() {
            $location = $(this).attr('row.location');
            popupCenter({
                url: 'maps.php?location= ' + $location,
                title: 'Paredes Petron Location',
                w: 900,
                h: 500
            });
        });

        var deliveryTable = $('#deliveryTable').DataTable({
            "searching": true,
            "bPaginate": true,
            "lengthChange": true,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": true,
            lengthMenu: [5, 10, 25, 50, 100, 200],
            "columnDefs": [
                // {
                //     targets: [],
                //     className: "text-end"
                // },
                // {
                //     targets: [],
                //     className: "text-justify"
                // },
                {
                    targets: [0, 1, 2, 3, 4],
                    className: "text-center"
                },
                {
                    orderable: false,
                    targets: [4]
                }
            ],
            dom: 'B<"searchBar">frtip',
            buttons: [
                // {
                //     text: '<i class="fas fa-folder-plus"></i>',
                //     titleAttr: 'NEW INBOUND',
                //     className: 'btn-warning me-3 shadow-none rounded',
                //     action: function(e, dt, node, config) {
                //         $("#loader").fadeIn(function() {
                //             $("#loader").fadeOut();
                //             window.location.href = "delivery-view.php";
                //         });

                //     },

                // },
                {
                    text: '<i class="fas fa-file-excel"></i>',
                    extend: 'excel',
                    title: 'Delivery Report_' + moment().format('MMMM Do YYYY, h:mm:ss a'),
                    className: 'btn-success me-3 shadow-none rounded',
                    titleAttr: 'EXCEL',
                    exportOptions: {
                        columns: 'th:not(:last-child):visible',
                    }
                },
                {
                    text: '<i class="fas fa-file-pdf"></i>',
                    extend: 'pdf',
                    titleAttr: 'PDF',
                    orientation: 'portrait',
                    pageSize: 'LEGAL',
                    className: 'btn-danger me-3 shadow-none rounded',
                    filename: 'Delivery Report_' + moment().format('MMMM Do YYYY, h:mm:ss a'),
                    header: 'Delivery Report',
                    messageTop: 'Date: ' + moment().format('MMMM Do YYYY, h:mm:ss a'),
                    title: 'Delivery Report',
                    exportOptions: {
                        columns: 'th:not(:last-child):visible',
                    }

                },
                {
                    text: '<i class="fas fa-print"></i>',
                    extend: 'print',
                    titleAttr: 'PRINT',
                    className: 'btn-info me-3 shadow-none rounded',
                    title: 'Delivery Report_' + moment().format('MMMM Do YYYY, h:mm:ss a'),
                    exportOptions: {
                        columns: 'th:not(:last-child):visible',
                    }

                },
                {
                    extend: 'colvis',
                    className: 'btn-dark me-3 shadow-none rounded-3',
                    text: '<i class="fas fa-columns"></i>',
                    titleAttr: 'COLUMNS VISIBLITY'
                },
                {
                    extend: 'pageLength',
                    className: 'btn-dark shadow-none rounded-3',
                    text: '<i class="fas fa-ruler-vertical"></i>',
                    titleAttr: 'PAGE LENGTH'
                }
            ]
        });
        var table = $('#deliveryTable').DataTable();
        $("#deliveryTable_filter.dataTables_filter").append($("#categoryFilter"));

        var categoryIndex = 0;
        $("#deliveryTable th").each(function(i) {
            if ($($(this)).html() == "Delivery Date") {
                categoryIndex = i;
                return false;
            }
        });

        //Use the built in datatables API to filter the existing rows by the Category column
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var selectedItem = $('#categoryFilter').val()
                var category = data[categoryIndex];
                if (selectedItem === "" || category.includes(selectedItem)) {
                    return true;
                }
                return false;
            }
        );

        //Set the change event for the Category Filter dropdown to redraw the datatable each time
        //a user selects a new filter.
        $("#categoryFilter").change(function(e) {
            table.draw();
        });

        table.draw();
    });
</script>