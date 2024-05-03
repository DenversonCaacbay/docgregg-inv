<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="../assets/logo.png">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Doc Gregg Veterinary Clinic</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
       
    <!-- Custom styles for this template-->
    <link href="../../../css/sidenav.css" rel="stylesheet">
    <link href="../../../css/sb-admin-2.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="../../../css/pagestyle.css" />
    
    <script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Place this at the end of your HTML body -->

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- SweetAlert 2 JS (including dependencies) -->
    <script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>

    <script src="../../../js/services_search.js"></script>
    <script src="../../../js/inventory_search.js"></script>
</head>


<style>
    /* Add this style in your CSS or within a <style> tag in the <head> section */
    body::-webkit-scrollbar {
    display: none;
    }
    .btn-primary{
        background: #0296be !important;
    }
    .bg-primary{
        background: #0296be !important;
    }
    .sidebar{
        width: 240px !important;
        height: 100vh !important;
        /* overflow-: auto !important; */
    }
    .sidebar .active{
        background: #191970;
        border-radius: 10px;
        /* opacity: 0.8; */
    }
    .fas{
        color: #fff !important;
        font-size: 14px !important;
    }
    label{
        font-weight: 500;
        font-size: 18px;
        /* color: #0296be; */
    }

    .btn-primary{
        background:  #0296be !important;

    }
    .table th{
        background: #0296be;
        color: white;
    }
    .logo{
        width:80px;
        height: 80px;
    }
    .sss .sidebar-brand-text{
        font-size: 17px;
    }
    .nav-item{
        padding: 0;
    }
    #logout.nav-item:last-child{
        bottom: 0;
        position: absolute;
        background: #fff !important;
        
        border-radius: 10px;
        padding: 0;
    }
    #logout.nav-item:last-child .nav-link{
        text-align:center;
        letter-spacing: 2px;
        color: #0296be !important;
    }
    thead.sticky {
        position: sticky;
        top: 0;
        z-index: 100;
    }
    @media only screen and (max-width: 1280px) { 
        .logo{
            width:60px;
            height: 60px;
        }
    }
    @media only screen and (max-width: 767px) { 
        .logo{
            display:none;
        }
        .sss{
            padding: 0;
        }
        .sidebar{
            display:none;
        }
        .sidebar-heading{
            text-align:left;
        }
        .nav-link{
            margin:auto;
        }
        
    }

</style>


<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php
            $userdetails = $bmis->get_userdata();
            $userRole = $userdetails['role'];

            $user_picture = $user['picture'];
        ?>

    <ul class="navbar-nav sidebar p-2 sidebar-dark  shadow accordion" id="accordionSidebar">
        <div class="card sss m-1">
            <img class="logo" src="../../../assets/logo.png">
            <div class="sidebar-brand-text">
                Doc Gregg <br>Veterinary Clinic
            </div>
        </div>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">
        <?php if ($userRole === 'administrator') : ?>
        <!-- Nav Item - Dashboard -->
        <li class="nav-item" id="dashboard">
            <a class="nav-link text-light" href="../../admin_dashboard.php">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Menu
        </div>

        
            <!-- Admin sees all items -->
            <li class="nav-item" id="client">
                <a class="nav-link text-light" href="../../services.php">
                    <i class="fas fa-users"></i>
                    <span>Services</span>
                </a>
            </li>
            <li class="nav-item dropdown"  id="inventory">
                <a class="nav-link" href="../../admin_inventory.php" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="d-flex justify-content-between align-items-center">
                    <div><i class="fas fa-clipboard-list"></i>
                    <span>Inventory</span></div>
                    <i class="fas fa-chevron-down"></i>
                </div>    
                
                    
                </a>
                <ul class="dropdown-menu ms-2 text-center">
                    <li><a class="dropdown-item" href="../../admin_inventory.php">All Products</a></li>
                    <li><a class="dropdown-item" href="../../admin_inventory_internal.php">Internal Inventory</a></li>
                    <li><a class="dropdown-item" href="../../admin_inventory_external.php">External Inventory</a></li>
                    <!-- <li><a class="dropdown-item" href="admin_inventory_both.php">Both Internal / External</a></li> -->
                    <li><a class="dropdown-item" href="../../create_inventory.php">Add Products</a></li>
                </ul>
            </li>
            <li class="nav-item" id="sales">
                <a class="nav-link text-light" href="../../admin_product_sale.php">
                    <i class="fas fa-cart-plus"></i>
                    <span>Product Sales</span>
                </a>
            </li>
            <li class="nav-item" id="staff">
                <a class="nav-link text-light" href="../../admin_staff_list.php">
                <i class="fas fa-users"></i>
                    <span>Staff List</span>
                </a>
            </li>
            <li class="nav-item" id="reports">
                <a class="nav-link text-light" href="../../admin_reports_logs.php">
                <i class="fas fa-flag"></i>
                    <span>Logs & Reports</span>
                </a>
            </li>
            <!-- ... Other sidebar elements ... -->
        <?php elseif ($userRole === 'Staff') : ?>
            <!-- Staff sees specific items -->
            <li class="nav-item" id="client">
                <a class="nav-link text-light" href="../../services.php">
                    <i class="fas fa-users"></i>
                    <span>Services</span>
                </a>
            </li>
            <li class="nav-item" id="sales">
                <a class="nav-link text-light" href="../../admin_product_sale.php">
                <i class="fas fa-cart-plus"></i>
                    <span>Product Sales</span>
                </a>
            </li>
        <?php endif; ?>
        <!-- ... Other sidebar elements ... -->
        <li class="nav-item" id="help">
            <a class="nav-link text-light" href="../../admin_help.php">
                <i class="fas fa-file-contract"></i>
                <span>Help & Support</span>
            </a>
        </li>
        <li class="nav-item" id="logout">
            <a class="nav-link text-light" href="../../logout.php">
                <span class="fw-bold">Logout</span>
            </a>
        </li>
    </ul>




        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow fixed-navbar">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow d-sm-none">
                        </li>
                        <li class="nav-item mt-4">
                        <?php if ($userRole === 'administrator') : ?>
                            <?php $lowInventoryCount = $staffbmis->count_low_inventory(); ?>
                            
                                <a href="admin_low_inventory.php" style="position: relative;">
                                    <i class="fas fa-bell" style="font-size: 30px;color: #0296be !important;"></i>
                                    <?php if($lowInventoryCount > 0) : ?>
                                    <span class="badge badge-danger" style="font-size:10px; position: absolute; top: -5; left: -5;"><?php echo $lowInventoryCount; ?></span>
                                </a>&nbsp;
                            <?php endif; ?>
                        <?php endif; ?>
                        </li>

                        <!-- Nav Item - User Information -->
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="../../admin_myprofile.php" id="userDropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                
                                <?php if (empty($user_picture)): ?>
                                    <img src="../../assets/placeholder/user-placeholder.png" class="rounded-circle mr-2" style="width: 30px;" alt="User Picture"> <h6 class="mr-2 mt-2 d-lg-inline text-primary"><?= ucfirst($userdetails['role']) ?>: <?= $userdetails['fname']?> <?= $userdetails['lname']?></h6>
                                <?php else: ?>
                                    <img src="../../<?= $user_picture ?>" class="rounded-circle mr-2" style="width: 30px;"  alt="User Picture"> <h6 class="mr-2 mt-2 d-lg-inline text-primary"><?= ucfirst($userdetails['role']) ?>: <?= $userdetails['fname']?> <?= $userdetails['lname']?></h6>
                                <?php endif; ?>
                                </a>
                            </li>
                        </li>
                    </ul>
                </nav>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // Retrieve the active item from localStorage
        var activeItem = localStorage.getItem('activeNavItem');
        // Set the default active item to 'dashboard' if not already set
        if (!activeItem) {
            activeItem = 'dashboard';
            localStorage.setItem('activeNavItem', activeItem);
        }
        // Remove the 'active' class from all items
        $('.nav-item').removeClass('active');
        // Add the 'active' class to the stored active item
        $('#' + activeItem).addClass('active');
        // Add a click event handler to all the navigation items
        $('.nav-item').on('click', function () {
            // Remove the 'active' class from all items
            $('.nav-item').removeClass('active');
            // Add the 'active' class to the clicked item
            $(this).addClass('active');
            // Store the id of the clicked item in localStorage
            localStorage.setItem('activeNavItem', $(this).attr('id'));
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var sidebar = document.querySelector('.sidebar');
        var sidebarToggleTop = document.getElementById('sidebarToggleTop');

        // Function to check if the viewport is in desktop view
        function isDesktopView() {
            return window.innerWidth > 768; // Adjust the threshold as needed
        }

        // Function to update the sidebar visibility based on viewport
        function updateSidebarVisibility() {
            if (isDesktopView()) {
                sidebar.style.display = 'block';
                sidebar.style.width = '150px';
            } else {
                sidebar.style.display = 'none';
            }
        }

        // Function to save sidebar state in local storage
        function saveSidebarState(state) {
            localStorage.setItem('sidebarState', state);
        }

        // Function to get sidebar state from local storage
        function getSidebarState() {
            return localStorage.getItem('sidebarState');
        }

        // Initial update on page load
        updateSidebarVisibility();

        // Check local storage for sidebar state
        var storedSidebarState = getSidebarState();
        if (storedSidebarState === 'open') {
            sidebar.style.display = 'block';
            sidebar.style.width = '150px';
        }

        // Event listener for button click
        sidebarToggleTop.addEventListener('click', function () {
            if (sidebar.style.display === 'none' || sidebar.style.display === '') {
                sidebar.style.display = 'block';
                sidebar.style.width = '150px';
                saveSidebarState('open');
            } else {
                sidebar.style.display = 'none';
                saveSidebarState('closed');
            }
        });

        // Event listener for window resize to handle responsive changes
        window.addEventListener('resize', function () {
            updateSidebarVisibility();
        });
    });
</script>



                
                <!-- End of Topbar -->