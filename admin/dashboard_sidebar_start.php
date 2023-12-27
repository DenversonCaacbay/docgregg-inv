<!DOCTYPE html>
<html lang="en">

<head>

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
    
    <!-- Custom styles for this template-->
    <link href="../css/sidenav.css" rel="stylesheet">
    <link href="../css/sb-admin-2.css" rel="stylesheet">
    
    <script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>
</head>


<style>
    /* Add this style in your CSS or within a <style> tag in the <head> section */
    li.nav-item {
        /* Add your default background color and text color here */
        background-color: transparent; /* Set the default background color */
        /* color: #ffffff; Set the default text color (white in this case) */
    }

    /* Styles for the 'active' class */
    li.nav-item.active {
        background: rgb(49,32,101);
background: linear-gradient(45deg, rgba(49,32,101,1) 0%, rgba(2,150,190,1) 74%);
        border-radius: 10px;
        margin:8px; /* Set the background color for the active state */
        color: /* Add your primary text color here */ black !important; /* Set the text color for the active state */
    }

    .btn-primary{
        background: #0296be !important;
    }
    .bg-primary{
        background: #0296be !important;
    }
</style>


<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

            <li class="nav-item p-2">
                <div class="card">
                    <img src="../assets/logo.png" width="100" height="100">
                    <div class="sidebar-brand-text">
                        Doc Gregg <br>Veterinary Clinic 
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item" id="dashboard">
                <a class="nav-link text-light" href="admin_dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Menu
            </div>

            <!-- Client List -->
            <li class="nav-item" id="client">
                <a class="nav-link  text-light" href="admin_client.php">
                    <i class="fas fa-users"></i>
                    <span>Client List</span></a>
            </li>

            <!-- Vaccination -->
            <li class="nav-item" id="vaccination">
                <a class="nav-link  text-light" href="admin_vaccination_record.php">
                    <i class="fas fa-users"></i>
                    <span>Vaccination Record</span></a>
            </li>


            <!-- Inventory Management -->
            <li class="nav-item" id="inventory">
                <a class="nav-link  text-light" href="admin_inventory.php">
                    <i class="fas fa-bullhorn"></i>
                    <span>Inventory</span></a>
            </li>

            <!-- Notifications -->
            <li class="nav-item" id="notification">
                <a class="nav-link text-light" href="admin_notification.php">
                    <i class="fas fa-file-word"></i>
                    <span>Notifications</span></a>
            </li>

            <!-- Profile -->
            <li class="nav-item">
                <a class="nav-link  text-light" href="admin_myprofile.php">
                    <i class="fas fa-id-card"></i>
                    <span>My Profile </span></a>
            </li>

            <!-- Help and Support -->
            <li class="nav-item" id="help">
                <a class="nav-link  text-light" href="admin_help.php">
                    <i class="fas fa-file-contract"></i>
                    <span>Help & Support</span></a>
            </li>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - User Information -->
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="logout.php" id="userDropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-light small">Hello <?= $userdetails['firstname']?> <?= $userdetails['surname']?>!</span>
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
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

                        // Remove the 'active' class from all items
                        $('.nav-item').removeClass('active');

                        // Add the 'active' class to the stored active item
                        if (activeItem) {
                            $('#' + activeItem).addClass('active');
                        }

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

                
                <!-- End of Topbar -->