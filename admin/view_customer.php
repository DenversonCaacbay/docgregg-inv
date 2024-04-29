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
        height: 700px;
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

    @media screen and (max-width: 1580px){
        .form--card{
            height: 500px;
            overflow: auto;
        }
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
                        <?php
                        
                        
                        if (is_array($view) && count($view) > 0) : ?>
                            <?php foreach ($view as $views)  : ?> 
                                <tr>
                                    <td> <?= $views['pet_name'];?> </td>
                                    <td> <?= $views['pet_type'];?> </td>
                                    <td> <?= $views['service_availed'];?> </td>
                                    <td>
                                        <?php foreach (json_decode($views['type_med_equip'], true) as $view): ?>
                                            <a href="#" class="product-link" data-toggle="modal" data-target="#productModal" data-product="<?= htmlspecialchars(json_encode($view), ENT_QUOTES, 'UTF-8'); ?>">
                                                <?= strlen($view) > 10 ? substr($view, 0, 10) . '...' : $view; ?>
                                            </a>
                                            <br>
                                        <?php endforeach; ?>
                                    </td>
                                    <!-- <td><?= implode(', ', json_decode($views['type_med_equip'], true)); ?></td> -->
                                    <td><?= date("M d, Y", strtotime($views['created_at'])); ?> </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="5">No Data Found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            


            <!-- Viewing of Pets -->
        </div>
    </div>

    <!-- Modal Profile-->

</div>

<!-- End of Main Content -->
