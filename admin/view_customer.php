<?php
    ini_set('display_errors',0);
    error_reporting(E_ALL ^ E_WARNING);
    require('../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $user = $staffbmis->view_single_staff($userdetails['id_admin']);
    $bmis->validate_admin();

    $view_profile = $staffbmis->view_single_customers();
    $view = $staffbmis->view_customer_services();

    $staffbmis->update_customer();
    $staffbmis->delete_customer();

?>

<?php 
    include('dashboard_sidebar_start.php');
?>
<link rel="stylesheet" href="../css/inventory.css">
<style>
    thead.sticky {
        position: sticky;
        top: 0;
        z-index: 100;
    }
    .services--btn{
        display:flex;
        align-items:center;
        align-content: center;
        justify-content:end;
    }
    .service--card{
        height:100%;
        overflow-x: auto;
    }
    .form--card{
        height: 100%;
        overflow: auto;
    }
    th,td{
        /* justify-content: center; */
        align-content: center;
    }
    @media screen and (max-width: 1280px) {
        .form--card{
            height: 400px;
            overflow: auto;
        }
    }

    @media screen and (max-width: 1536px){
        .service--card{
            height:80%;
        } 
    }
    /* @media screen and (max-width: 1280px){
        .service--card{
            height:70vh;
        } 
    } */
    @media screen and (max-width: 1024px){
        .service--card{
            height:80%;
        } 
    }
    @media screen and (max-width: 768px){
        .service--card{
            height:100%;
        } 
    }
</style>

<!-- Begin Page Content -->

<div class="container-fluid customer--container">

    <!-- Page Heading -->

    
    
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <a href="services.php" class="btn btn-primary">Back</a>
                <a href="create_service.php?id=<?= $_GET['id'] ?>" class="btn btn-primary">Avail Service</a>
            </div>
        </div>
    </div>

    <div class="row"> 
        <div class="col-md-4">
            <div class="card p-3 mt-2">
                <form method="post">
                    <h3>Customer Information</h3>
                    <label>Name: </label>
                    <input class="form-control" type="text" name="customer_name" value="<?= $view_profile['customer_name'] ?>">
                    <label class="mt-3">Contact:</label>
                    <input class="form-control" type="text" name="customer_contact" value="<?= $view_profile['customer_contact'] ?>">
                    <label class="mt-3">Email:</label>
                    <input class="form-control" type="text" name="customer_email" value="<?= $view_profile['customer_email'] ?>">
                    <label class="mt-3">Address:</label>
                    <input class="form-control" type="text"  name="customer_address"  value="<?= $view_profile['customer_address'] ?>">
                    <div class="d-flex">
                        
                        <!-- <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Update Information</button> -->
                        <button class="btn btn-danger mt-3 w-100 me-3 " type="submit" name="delete_customer" onclick="return confirm('Are you sure you want to remove this customer?')">Remove Data</button>
                        <button class="btn btn-primary mt-3 w-100 " type="submit" name="update_customer">Update</button>
                    </div>
                    
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <h3>Availed Services</h3>
                <div class="form--card">
                    <table class="table table-bordered">
                        <thead>
                            <th>Pet Name</th>
                            <th>Pet Type</th>
                            <th>Service</th>
                            <th>Type / Medicine / Equipment</th>
                            <th>Date</th>
                        </thead>
                        <tbody>
                        <?php if(is_array($view) && count($view) > 0) {?>
                            <?php foreach($view as $view) {?>
                                <tr>
                                    <td> <?= $view['pet_name'];?> </td>
                                    <td> <?= $view['pet_type'];?> </td>
                                    <td> <?= $view['service_availed'];?> </td>
                                    <td><?= $view['type_med_equip'];?> </td>
                                    <td><?= date("M d, Y", strtotime($view['created_at'])); ?> </td>
                                </tr>
                            <?php }?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="9">No Data Found</td>
                                </tr>
                            <?php } ?> 
                        </tbody>
                    </table>
            </div>
            


            <!-- Viewing of Pets -->
            <!-- <div class="service--card">
                <?php if(is_array($view) && count($view) > 0) {?>
                    <?php foreach($view as $view) {?>
                        <div class="card mt-3">
                            <div class="card-header bg-primary text-light d-flex justify-content-between">
                                Date: <?= date("F d, Y", strtotime($view['created_at'])) ?>
                            </div>
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h5>Pet Name: <?= $view['pet_name'] ?></h5>
                                        <h5>Pet Type: <?= $view['pet_type'] ?></h5>
                                    </div>
                                    <div class="ms-5">
                                        <h5>Breed: <?= $view['breed'] ?></h5>
                                        <h5>Sex: <?= $view['sex'] ?></h5>
                                    </div>
                                    
                                </div>
                                
                                <button class="btn btn-primary">View Records</button>
                            </div>
                        </div>
                <?php }?>
                <?php } else { ?>
                    <tr>
                        <td colspan="9">No Data Found</td>
                    </tr>
                <?php } ?>
            </div> -->
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
