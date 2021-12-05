<?php require_once 'head.php' ?>
<div class="row p-3" style="position: relative;">
    <div class="shadow p-3 mb-5 bg-body rounded">
        <div class="text-center">
            <h5 class="display-4 mb-5 mt-3">Employee List</h5>
        </div>

        <div class="table-responsive my-5 p-5">
            <table id="employeeTable" class="tableDesign table table-striped table-hover align-middle shadow-none">
                <thead class="align-middle">
                    <tr>
                        <th>Employee Number</th>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Email Address</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>EMP-121</td>
                        <td>Gregorio, Ron Ivin</td>
                        <td>09264102938</td>
                        <td>gregorioron26@gmail.com</td>
                        <td class="remarksWrapper">Block 1 Lot 20 Phase 4 Ecotrend Subd. Ligas 3 Bacoor City</td>
                        <td><button type="button" class="btn btn-warning shadow-none"><i class="fas fa-edit"></i></button> <button type="button" class="btn btn-danger shadow-none"><i class="fas fa-trash-alt"></i></button></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Employee Number</th>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Email Address</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <?php require_once 'loader.php' ?>
    </div>

</div>

<?php require_once 'footer.php' ?>

<script>
    $(document).ready(function() {
        // var today = new Date().toLocaleString();
        var today = new Date();
        // today.toLocaleDateString("en-US", options);
        var options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        $('#employeeTable').DataTable({
            "searching": true,
            "bPaginate": true,
            "lengthChange": true,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": true,
            lengthMenu: [5, 10, 25, 50, 100, 200],
            "columnDefs": [
                {
                    targets: [0,1,2,3,5],
                    className: "text-center"
                },
                {
                    orderable: false,
                    targets: [5]
                }
            ],
            dom: 'Bfrtip',
            buttons: [{
                    text: '<i class="fas fa-folder-plus"></i>',
                    titleAttr: 'NEW EMPLOYEE',
                    className: 'btn-warning me-3 shadow-none rounded',
                    action: function(e, dt, node, config) {
                        $("#loader").fadeIn(function() {
                            $("#loader").fadeOut();
                            window.location.href = "employee-add.php";
                        });

                    },

                },
                {
                    text: '<i class="fas fa-file-excel"></i>',
                    extend: 'excel',
                    title: 'Employee List_' + moment().format('MMMM Do YYYY, h:mm:ss a'),
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
                    filename: 'Employee List_' + moment().format('MMMM Do YYYY, h:mm:ss a'),
                    header: 'Employee List',
                    messageTop: 'Date: ' + moment().format('MMMM Do YYYY, h:mm:ss a'),
                    title: 'Employee List',
                    exportOptions: {
                        columns: 'th:not(:last-child):visible',
                    }

                },
                {
                    text: '<i class="fas fa-print"></i>',
                    extend: 'print',
                    titleAttr: 'PRINT',
                    className: 'btn-info me-3 shadow-none rounded',
                    title: 'Employee List_' + moment().format('MMMM Do YYYY, h:mm:ss a'),
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
    });
</script>