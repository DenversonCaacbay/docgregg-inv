<?php
    ini_set('display_errors',0);
    error_reporting(E_ALL ^ E_WARNING);
    require('../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $user = $staffbmis->view_single_staff($userdetails['id_admin']);
    $bmis->validate_admin();
    

    //Para di ma access ni Staff yung page
    if ($userdetails['role'] !== 'administrator') {
        // User is not an admin, display an alert
        echo '<script>alert("You are not authorized to access this page as admin.");</script>';
        // Redirect or take appropriate action if needed
        header('Location: admin_dashboard.php');
        exit();
    }
    

?>

<?php 
    include('dashboard_sidebar_start.php');
?>


<!-- Begin Page Content -->

<div class="container-fluid">
    <div class="row mt-5">
        <div class="col-md-12"><h1 class="text-center fw-bold mb-5">Inventory</h1></div>
        <div class="col-md-6">
            <div class="card text-center p-5 mt-3">
                <h4 class="mt-3 fw-bold">Internal Products</h4>
                <a class="btn btn-primary mt-3" href="admin_inventory_internal.php">Visit</a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-center p-5 mt-3">
                <h4 class="mt-3 fw-bold">External Products</h4>
                <a class="btn btn-primary mt-3" href="admin_inventory_external.php">Visit</a>
            </div>
        </div>
    </div>
</div>

