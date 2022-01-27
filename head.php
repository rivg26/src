<?php
require_once 'includes/dbh.inc.php';
require_once 'includes/functions.inc.php';
session_start();

if (isset($_SESSION['empId'])) {
    $data = getSessionEmployeeData($conn, $_SESSION['empId']);
} else {
    header('location: admin-login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PAREDES PETRON SYSTEM</title>

    <!-- using online links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="//malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/buttons/2.0.1/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="css/admin-main.css">
    <link rel="stylesheet" href="css/sidebar-themes.css">
    <link rel="stylesheet" href="css/admin-component.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.css" integrity="sha256-zsz1FbyNCtIE2gIB+IyWV7GbCLyKJDTBRz0qQaBSLxM=" crossorigin="anonymous">
    <link rel="shortcut icon" type="image/png" href="assets/logo/favicon.ico" />

</head>

<body>
    <div class="page-wrapper legacy-theme sidebar-bg bg1 toggled border-radius-on ">
        <nav id="sidebar" class="sidebar-wrapper no-printme">
            <div class="sidebar-content">
                <!-- sidebar-brand  -->
                <div class="sidebar-item sidebar-brand my-2">
                    <img src="img/logo-white.png" class="img-fluid p-5" alt="">
                </div>
                <!-- sidebar-header  -->
                <div class="sidebar-item sidebar-header d-flex flex-nowrap ">
                    <div class="user-pic">
                        <img class="img-responsive img-rounded" src="<?= $data['emp_picpath'] ?>" alt="User picture">
                    </div>
                    <div class="user-info">
                        <span class="user-name"><?= $data['emp_firstname'] ?>
                            <strong><?= $data['emp_lastname'] ?></strong>
                        </span>
                        <span class="user-role"><?= ucfirst($_SESSION['accRole']) ?></span>
                    </div>
                </div>
                <!-- sidebar-menu  -->
                <div class="sidebar-item sidebar-menu">
                    <ul>
                        <li class="header-menu">
                            <span>General</span>
                        </li>
                        <li>
                            <a class="adminNav" link="dashboard" href="">
                                <i class="fa fa-tachometer-alt"></i>
                                <span class="menu-text">Dashboard</span>
                            </a>
                            <!-- <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="#">Dashboard 1
                                            <span class="badge badge-pill badge-success">Pro</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Dashboard 2</a>
                                    </li>
                                    <li>
                                        <a href="#">Dashboard 3</a>
                                    </li>
                                </ul>
                            </div> -->
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="fa fa-shopping-cart"></i>
                                <span class="menu-text">Sales Management</span>
                                <!-- <span class="badge badge-pill badge-danger">3</span> -->
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a class="adminNav" link="sales-add" href="">Add Sales Report</a>
                                    </li>
                                    <li>
                                        <a class="adminNav" link="sales-report" href="">Sales Report</a>
                                    </li>
                                    <li>
                                        <a class="adminNav" link="price-update-report" href="">Price Update Report</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="fas fa-warehouse"></i>
                                <span class="menu-text">Inventory Management</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a class="adminNav" link="product-add" href="">Add Product Inbound</a>
                                    </li>
                                    <li>
                                        <a class="adminNav" link="product-report" href="">Product Inbound Report</a>
                                    </li>
                                    <!-- <li>
                                        <a class="adminNav" link="defective-add" href="">Add Defective Product</a>
                                    </li>
                                    <li>
                                        <a class="adminNav" link="defective-report" href="">Defective Product Report</a>
                                    </li> -->
                                    <li>
                                        <a class="adminNav" link="inventory-report" href="">View Inventory Report</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="" class="adminNav" link="customer-report">
                                <i class="fas fa-users"></i>
                                <span class="menu-text">Customer Management</span>
                            </a>
                        </li>
                        <li>
                            <a href="" class="adminNav" link="delivery-report">
                                <i class="fas fa-truck"></i>
                                <span class="menu-text">Delivery Management</span>
                            </a>
                        </li>
                        <li class="header-menu">
                            <span>Others</span>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="fas fa-user-tie"></i>
                                <span class="menu-text">Employee Management</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a class="adminNav" link="employee-add" href="">Add Employee</a>
                                    </li>
                                    <li>
                                        <a class="adminNav" link="employee-list" href="">Employee List</a>
                                    </li>
                                    <li>
                                        <a class="adminNav" link="expenses-add" href="">Add Expenses</a>
                                    </li>
                                    <li>
                                        <a class="adminNav" link="expenses-report" href="">Expenses Report</a>
                                    </li>
                                    <?= $_SESSION['accRole'] == "admin" ? '<li><a class="adminNav" link="account-management" href="">Account Management</a></li>' : '' ?>
                                </ul>
                            </div>
                        </li>
                        <li class="header-menu">
                            <span>Archive</span>
                        </li>
                        
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="fas fa-file-archive"></i>
                                <span class="menu-text">Manage Archive</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a class="adminNav" link="archive-price-update" href="">Price Update Report Archive</a>
                                    </li>
                                    <li>
                                        <a class="adminNav" link="archive-sales" href="">Sales Report Archive</a>
                                    </li>
                                    <li>
                                        <a class="adminNav" link="archive-product-inbound" href="">Product Inbound Report Archive</a>
                                    </li>
                                    <li>
                                        <a class="adminNav" link="archive-inventory-report" href="">Inventory Report Archive</a>
                                    </li>
                                    <li>
                                        <a class="adminNav" link="archive-customer-list" href="">Customer List Archive</a>
                                    </li>
                                    <li>
                                        <a class="adminNav" link="archive-employee-list" href="">Employee List Archive</a>
                                    </li>
                                    <li>
                                        <a class="adminNav" link="archive-expenses-report" href="">Expenses Report Archive</a>
                                    </li>


                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- sidebar-menu  -->
            </div>
            <!-- sidebar-footer  -->
            <div class="sidebar-footer">
                <div class="dropdown customDropdown">

                    <a class="dropdown-toggle" href="#" data-bs-toggle="dropdown" id="dropdown1" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bell"></i>
                        <span class="badge rounded-pill bg-warning notification">3</span>
                    </a>
                    <div class="dropdown-menu notifications " aria-labelledby="dropdown1">
                        <div class="notifications-header">
                            <i class="fa fa-bell"></i>
                            Notifications
                        </div>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">
                            <div class="notification-content">
                                <div class="icon">
                                    <i class="fas fa-check text-success border border-success"></i>
                                </div>
                                <div class="content">
                                    <div class="notification-detail">Lorem ipsum dolor sit amet consectetur adipisicing
                                        elit. In totam explicabo</div>
                                    <div class="notification-time">
                                        6 minutes ago
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a class="dropdown-item" href="#">
                            <div class="notification-content">
                                <div class="icon">
                                    <i class="fas fa-exclamation text-info border border-info"></i>
                                </div>
                                <div class="content">
                                    <div class="notification-detail">Lorem ipsum dolor sit amet consectetur adipisicing
                                        elit. In totam explicabo</div>
                                    <div class="notification-time">
                                        Today
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a class="dropdown-item" href="#">
                            <div class="notification-content">
                                <div class="icon">
                                    <i class="fas fa-exclamation-triangle text-warning border border-warning"></i>
                                </div>
                                <div class="content">
                                    <div class="notification-detail">Lorem ipsum dolor sit amet consectetur adipisicing
                                        elit. In totam explicabo</div>
                                    <div class="notification-time">
                                        Yesterday
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <!-- <a class="dropdown-item text-center" href="#">View all notifications</a> -->
                    </div>
                </div>

                <div class="dropdown customDropdown">
                    <a class="dropdown-toggle" href="#" data-bs-toggle="dropdown" id="dropdown2" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-cog"></i>
                        <span class="badge-sonar"></span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdown2">
                        <a class="dropdown-item" href="#">Help</a>
                        <a class="dropdown-item" href="#">Setting</a>
                    </div>
                </div>
                <div>
                    <a href="" id="btnLogout" data-bs-toggle="modal" data-bs-target="#logoutModal">
                        <i class="fa fa-power-off"></i>
                    </a>
                </div>

                <div class="pinned-footer">
                    <a href="#">
                        <i class="fas fa-ellipsis-h"></i>
                    </a>
                </div>
            </div>
        </nav>

        <div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirmation <i class="fas fa-question-circle link-warning"></i></h5>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to logout? 
                    </div>

                    <div class="modal-footer">
                        <a href="includes/logout.inc.php" class="btn shadow-none rippleButton ripple" id="punTableDelete">Log Out</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- page-content  -->
        <main class="page-content pt-2">
            <div id="overlay" class="overlay"></div>
            <div class="container-fluid p-5">
                <div class="row no-printme">
                    <div class="form-group col-md-12 mb-0 p-1">
                        <a id="toggle-sidebar" class="btn shadow-none rounded-0" href="#">
                            <span><i class="fas fa-bars"></i></span>
                        </a>
                        <!-- <a id="pin-sidebar" class="btn btn-outline-secondary rounded-0" href="#">
                            <span>Pin Sidebar</span>
                        </a> -->
                    </div>

                </div>
                <hr>