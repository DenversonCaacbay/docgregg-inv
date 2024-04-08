<?php
    ini_set('display_errors',0);
    error_reporting(E_ALL ^ E_WARNING);
    require('../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $user = $staffbmis->view_single_staff($userdetails['id_admin']);
    $bmis->validate_admin();
    
    $staffbmis->delete_services();

    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $recordsPerPage = 5; // set the number of records to display per page
    // $view = $staffbmis->view_services_all($page, $recordsPerPage);
    $view = $staffbmis->view_customers($page, $recordsPerPage);
    // $totalRecords = $staffbmis->count_inventory(); // get the total number of records

// Calculate the total number of pages
    $totalPages = ceil($totalRecords / $recordsPerPage);


?>

<?php 
    include('dashboard_sidebar_start.php');
?>

<style>
    thead.sticky {
        position: sticky;
        top: 0;
        z-index: 100;
    }
</style>

<!-- Begin Page Content -->

<div class="container-fluid">

    <!-- Page Heading -->

    
    
    <div class="row">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <a href="services.php" class="btn btn-primary">Back</a>
                <h1 class="ms-2 mt-2">Services</h1>
            </div>
           
        </div>
        <div class="col-md-6"><a href="create_service.php" style="float:right;padding: 10px" class="btn btn-primary">Avail Service</a></div>
    </div>

    <div class="row"> 
        <div class="col-md-4">
            <div class="card p-3 mt-2">
                <h3>Customer Information</h3>
                <label class="mt-3">Name: </label>
                <input class="form-control" type="text">
                <label class="mt-3">Contact:</label>
                <input class="form-control" type="text">
                <label class="mt-3">Address:</label>
                <input class="form-control" type="text">
                <button class="btn btn-primary mt-3">Update Information</button>
                <button class="btn btn-danger mt-3">Remove Data</button>
            </div>
        </div>
        <div class="col-md-8">
            <h3>Availed Services</h3>
            
            <div class="card">
                <div class="card-header bg-primary text-light d-flex justify-content-between">
                    Date: January 1, 1999
                </div>
                <div class="card-body">
                    <h5>Pet Type: Dog</h5>
                    <h5>Treatment : Surgical</h5>
                    <h5>Medicine: Sample Medicine</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- End of Main Content -->
