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

    $staffbmis->create_customer();

    $id_user = $_GET['id_user'];
    $staffbmis->create_pet($id_user);
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

<div class="container-fluid page-container">

    <!-- Page Heading -->

    <div class="d-flex align-items-center">
        <a class="btn btn-primary" href="services.php">Back</a>
        <h1 class="mb-0 ms-4">Add Customer</h1>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form method="post" enctype='multipart/form-data' class="mt-1 p-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="container">
                             <div class="row me-5 mt-3">
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label> Customer Name: </label>
                                    <input type="text" class="form-control" name="customer_name" required>
                                </div>
                            </div>
                            <div class="col-md-6 mt-2">
                                <div class="form-group">
                                    <label> Contact Number: </label>
                                    <input type="number" class="form-control" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==11) return false;"  name="customer_contact" required>
                                </div>
                            </div>
                            <div class="col-md-6 mt-2">
                                <div class="form-group">
                                    <label> Email: </label>
                                    <input type="email" class="form-control"  name="customer_email" required>
                                </div>
                            </div>
                            <div class="col-md-12 mt-2">
                                <div class="form-group">
                                    <label> Address: (Street/Barangay, City, Province)</label>
                                    <input type="text" class="form-control" name="customer_address" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <input type="hidden" class="form-control" value="<?= $userdetails['fname']?> <?= $userdetails['lname']?>" name="staff_name">
                            </div>

                            
                            <div class="mt-3">
                                <input type="submit" class="btn btn-primary w-100 mb-3 p-2" name="create_customer" value="Add Customer" onclick="return confirm('Are you sure you want to Add Customer?')" />
                            </div>
                            
                            
                        </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div> 
</div>

