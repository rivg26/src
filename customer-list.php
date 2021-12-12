<?php require_once 'head.php' ?>
<div class="row p-3" style="position: relative;">
    <div class="shadow p-3 mb-5 bg-body rounded">
        <div class="text-center">
            <h5 class="display-4 mb-5 mt-3">Customer List</h5>
        </div>
        <div class="table-responsive my-5 p-5">
            <div class="category-filter">
                <select id="categoryFilter" class="form-control shadow-none">
                    <option value="">Show All</option>
                    <optgroup label="Sort by Months">
                        <option value='<?php echo "Jan " . date("Y") ?>'>January</option>
                        <option value='<?php echo "Feb " . date("Y") ?>'>February</option>
                        <option value='<?php echo "Mar " . date("Y") ?>'>March</option>
                        <option value='<?php echo "Apr " . date("Y") ?>'>April</option>
                        <option value='<?php echo "May " . date("Y") ?>'>May</option>
                        <option value='<?php echo "Jun " . date("Y") ?>'>June</option>
                        <option value='<?php echo "Jul " . date("Y") ?>'>July</option>
                        <option value='<?php echo "Aug " . date("Y") ?>'>August</option>
                        <option value='<?php echo "Sep " . date("Y") ?>'>September</option>
                        <option value='<?php echo "Oct " . date("Y") ?>'>October</option>
                        <option value='<?php echo "Nov " . date("Y") ?>'>November</option>
                        <option value='<?php echo "Dec " . date("Y") ?>'>December</option>
                    </optgroup>
                    <optgroup label="Sort by Day">
                        <option value="<?= date('d M Y', strtotime(date('Y-m-d'))) ?>">Today</option>
                        <option value="<?= date('d M Y', strtotime("-1 days")) ?>">Yesterday</option>
                    </optgroup>
                </select>
            </div>

            <table id="customerReportTable" class="tableDesign table table-striped table-hover align-middle shadow-none">
                <thead class="align-middle">
                    <tr>
                        <th>Date</th>
                        <th>Customer Number</th>
                        <th>Customer Name</th>
                        <th>Phone Number</th>
                        <th>Address</th>
                        <th>Encoder Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?= customerTable($conn); ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Date</th>
                        <th>Customer Number</th>
                        <th>Customer Name</th>
                        <th>Phone Number</th>
                        <th>Address</th>
                        <th>Encoder Name</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>

            <div class="modal fade" id="customerSendModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Send Text to Customer</h5>
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3 col-5">
                                <label for="customerUnit" class="form-label">Customer Phone Number</label>
                                <input type="text" class="form-control shadow-none" id="customerListPhoneNumber" readonly>
                            </div>
                            <div class="form-floating">
                                <textarea class="form-control shadow-none" maxlength="400" id="customerText" style="height: 100px"></textarea>
                                <label for="customerText">text message</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn shadow-none rippleButton ripple" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#customerConfirmation">Send Text</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="customerConfirmation" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confirmation <i class="fas fa-question-circle link-warning"></i></h5>
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to send text messages?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn shadow-none rippleButton ripple" id="customerUpdate">Send</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php require_once 'loader.php' ?>
    </div>
</div>
<?php require_once 'footer.php' ?>
<script>
    $(document).ready(function() {
        $(document).on('click', '#customerUpdate', function() {
            let datastring = {
                'btnCustomerUpdate': $('#customerUpdate').val(),
                'customerListPhoneNumber': $('#customerListPhoneNumber').val(),
                'customerText': $('#customerText').val()
            };
            console.log(datastring);
            $.ajax({
                url: 'includes/customer-list.inc.php',
                type: 'POST',
                data: datastring,
                dataType: 'json',
                success: function(data) {
                    if (data.status) {
                        $('textarea').prop('disabled', true);
                        // $('#customerUpdate').html("<span class='spinner-border spinner-border-sm ' id = 'loading' role='status' aria-hidden='true'></span>");
                        $('#customerUpdate').prop('disabled', true);
                        $('#customerUpdate').text('Message Sent');
                        window.setTimeout(function() {
                            window.location.reload();
                        }, 1000);
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
        $(document).on('click', '#btnSendText', function() {
            $('#customerListPhoneNumber').val($(this).attr('row.id'));
        });

        $(document).on('click', '#btnEditCustomer', function() {
            let rowId = $(this).attr('row.id');
            $("#loader").fadeIn();
            window.setTimeout(function() {
                $("#loader").fadeOut();
                window.location.href = "customer-view.php?rowId=" + rowId;
            }, 2000);
        });
        $('#customerReportTable').DataTable({
            "searching": true,
            "bPaginate": true,
            "lengthChange": true,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": true,
            lengthMenu: [5, 10, 25, 50, 100, 200],
            "columnDefs": [{
                    targets: [],
                    className: "text-end"
                },
                {
                    targets: [2, 3, 4, 5],
                    className: "text-justify"
                },
                {
                    targets: [0, 1, 6],
                    className: "text-center"
                },
                {
                    orderable: false,
                    targets: [6]
                }
            ],
            dom: 'B<"searchBar">frtip',
            buttons: [{
                    text: '<i class="fas fa-folder-plus"></i>',
                    titleAttr: 'Customer List',
                    className: 'btn-warning me-3 shadow-none rounded',
                    action: function(e, dt, node, config) {
                        $("#loader").fadeIn(function() {
                            $("#loader").fadeOut();
                            window.location.href = "customer-view.php";
                        });

                    },

                },
                {
                    text: '<i class="fas fa-file-excel"></i>',
                    extend: 'excel',
                    title: 'Customer List_' + moment().format('MMMM Do YYYY, h:mm:ss a'),
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
                    filename: 'Customer List_' + moment().format('MMMM Do YYYY, h:mm:ss a'),
                    header: 'Customer List',
                    messageTop: 'Date: ' + moment().format('MMMM Do YYYY, h:mm:ss a'),
                    title: 'Customer List',
                    exportOptions: {
                        columns: 'th:not(:last-child):visible',
                    }

                },
                {
                    text: '<i class="fas fa-print"></i>',
                    extend: 'print',
                    titleAttr: 'PRINT',
                    className: 'btn-info me-3 shadow-none rounded',
                    title: 'Customer List_' + moment().format('MMMM Do YYYY, h:mm:ss a'),
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

        var table = $('#customerReportTable').DataTable();
        $("#customerReportTable_filter.dataTables_filter").append($("#categoryFilter"));

        var categoryIndex = 0;
        $("#customerReportTable th").each(function(i) {
            if ($($(this)).html() == "Date") {
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