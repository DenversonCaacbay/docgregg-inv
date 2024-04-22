<?php
    
    // ini_set('display_errors',0);
    error_reporting(E_ALL ^ E_WARNING);
    require('../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $user = $staffbmis->view_single_staff($userdetails['id_admin']);
    $bmis->validate_admin();
    $view = $staffbmis->view_user();
    // $bmis->validate_admin();
    // $bmis->delete_bspermit();
    // $view = $bmis->view_bspermit();

    $staffbmis->create_service();

    $pets = $staffbmis->view_customer_pets();
    // print_r($pets);
    $id_user = $_GET['id_user'];
    $staffbmis->create_pet($id_user);
    // echo $id_user;
    // $resident = $residentbmis->get_single_bspermit($id_resident);
    // if ($userdetails['role'] !== 'administrator') {
    //     // User is not an admin, display an alert
    //     echo '<script>alert("You are not authorized to access this page as admin.");</script>';
    //     // Redirect or take appropriate action if needed
    //     header('Location: admin_dashboard.php');
    //     exit();
    // }
?>

<?php 
    include('dashboard_sidebar_start.php');
?>


<style>
    .input-icons i {
        position: absolute;
    }
        
    .input-icons {
        width: 30%;
        margin-bottom: 10px;
        margin-left: 34%;
    }
        
    .icon {
        padding: 10px;
        min-width: 40px;
    }
    .form-control{
        text-align: left;
    }
</style>

<!-- Begin Page Content -->

<div class="container-fluid">

    <!-- Page Heading -->

    <div class="d-flex align-items-center">
        <a class="btn btn-primary" href="view_customer.php?id=<?= $_GET['id'] ?>">Back</a>
        <h1 class="mb-0 ms-4">Avail Service</h1>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form method="post" enctype='multipart/form-data' class="mt-1 p-2" onsubmit="return validateForm()">
            <div class="row">
                <div class="col-md-4">
                    <label>Pet: </label>
                    <input type="text" class="form-control" name="pet" />
                    <label class="mt-3">Select Service:</label>
                    <select class="form-select">
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>

                    </select>
                    <label class="mt-3">Select Type:</label>
                    <select class="form-select">
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>

                    </select>
                    <label class="mt-3">Select Medicine / Equipment:</label>
                    <select class="form-select">
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>

                    </select>
                    <button class="btn btn-primary w-100 mt-3">Avail Service</button>
                </div>
                <div class="col-md-8">
                    <table class="table table-border">
                        <thead>
                            <th>Pet</th>
                            <th>Service</th>
                            <th>Type</th>
                            <th>Medicine / Equipment</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>John</td>
                                <td>Treatment</td>
                                <td>Surgical</td>
                                <td>Syringe</td>
                            </tr>
                            <tr>
                                <td>John1 (Another Pet)</td>
                                <td>Treatment</td>
                                <td>Medicine</td>
                                <td>Novibac</td>
                            </tr>
                        </tbody>
                        
                    </table>
                </div>
            </div>
            </form>
        </div>
    </div> 
</div>





<!-- End of Main Content -->
