<?php
    ini_set('display_errors',0);
    error_reporting(E_ALL ^ E_WARNING);
    require('../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $user = $staffbmis->view_single_staff($userdetails['id_admin']);
    $bmis->validate_admin();

    $view = $staffbmis->view_single_customers();
    $staffbmis->update_customer();
    $staffbmis->delete_customer();

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
                <form method="post">
                    <h3>Customer Information</h3>
                    <label class="mt-3">Name: </label>
                    <input class="form-control" type="text" name="customer_name" value="<?= $view['customer_name'] ?>">
                    <label class="mt-3">Contact:</label>
                    <input class="form-control" type="text" name="customer_contact" value="<?= $view['customer_contact'] ?>">
                    <label class="mt-3">Address:</label>
                    <input class="form-control" type="text"  name="customer_address"  value="<?= $view['customer_address'] ?>">
                    <button class="btn btn-primary mt-3" type="submit" name="update_customer">Update Information</button>
                    <!-- <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Update Information</button> -->
                    <button class="btn btn-danger mt-3" type="submit" name="delete_customer" onclick="return confirm('Are you sure you want to remove this customer?')">Remove Data</button>
                </form>
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

    <!-- Modal Profile-->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update Customer Information</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data"> 
                    <div class="row">
                        <div class="col-md-12 mb-2">
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label> Customer Name: </label>
                                <input type="text" class="form-control" name="fname" value="" required>
                            </div>
                        </div>
                        <div class="col-12"> 
                            <div class="form-group">
                                <label> Customer Contact: </label>
                                <input type="text" class="form-control" name="position" value="" >
                            </div>
                        </div>
                        <div class="col-12"> 
                            <div class="form-group">
                                <label> Address: </label>
                                <input type="text" class="form-control" name="role" value="" >
                            </div>
                        </div>
                        <div class="col-12"><button class="btn btn-primary w-100" style="margin-top: 35px;font-size: 18px; border-radius:5px;" type="submit" name="update_staff"> Save </button></div>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>

<!-- End of Main Content -->
