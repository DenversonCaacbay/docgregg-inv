<?php
    
    error_reporting(E_ALL ^ E_WARNING);
    ini_set('display_errors',0);
    // require('../classes/resident.class.php');
    require('../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $bmis->validate_admin();
    $view = $staffbmis->view_pet();
    // print_r($view);
    // $bmis->delete_certofres();
    // $view = $bmis->view_certofres();
    // $id_resident = $_GET['id_resident'];
    // $resident = $residentbmis->get_single_certofres($id_resident);
    // $resident = view_certofres();
   
?>

<?php 
    include('dashboard_sidebar_start.php');
?>

<style>
    .container-fluid{
    overflow: hidden;
}
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
        text-align: center;
    }
</style>

<!-- Begin Page Content -->

<div class="container-fluid">

    <!-- Page Heading -->

    <div class="d-flex align-items-center">
        <a class="btn btn-primary" href="admin_client.php">Back</a>
        <h1 class="mb-0 ml-2">Client Pets</h1>
        <!-- <a class="btn btn-primary ml-auto" href="create_client_pet.php">Add Pet</a> -->
    </div>

    <br>
    <?php if(is_array($view) && count($view) > 0): ?>
    <?php foreach($view as $item): ?>
    <div class="container">
        <div class="card p-2 mt-4">
            <div class="row">
                <div class="col-md-3 text-center ">
                    <?php if (is_null($item['pet_picture'])): ?>
                        <img src="../images/placeholder/pet-placeholder.png" width="200">
                    <?php else: ?>
                        <!-- Display pet image here -->
                        <img src="<?= $item['pet_picture'] ?>" class="img-fluid" alt="Modal Image" width="200">
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <h5>Pet Name: <?= $item['pet_name']; ?></h5>
                    <h5>Pet Type: <?= $item['pet_type']; ?></h5>
                    <h5>Sex:  <?= $item['sex'] = $item['sex'] ? $item['sex'] : "---"; ?></h5>
                    <h5>Breed: <?= $item['breed']= $item['breed'] ? $item['breed'] : "---"; ?></h5>
                    <?php 
                        $bdate_format = !empty($item['bdate']) ? date("M d,Y", strtotime($item['bdate'])) : "---";
                    ?>
                    <h5>Birthdate: <?= $bdate_format; ?></h5>
                    <h5>Age: <?= $item['age'] = !empty($item['age']) ? $item['age'] : 0; ?></h5>
 
                </div>
                <div class="col-md-3 ">
                    <form method="post" class="mt-1">
                        <a href="create_vaccination_record.php?pet_id=<?= $item['pet_id']; ?>&id_user=<?= $_GET['id_user']; ?>" class="btn btn-success text-center d-flex ml-auto">Create Vaccination Record</a><br>
                        <a href="view_vaccination_record.php?pet_id=<?= $item['pet_id']; ?>&id_user=<?= $_GET['id_user']; ?>" class="btn btn-primary text-center d-flex ml-auto">View Records</a>
                        <!-- <input type="hidden" name="id_user" value="<?= $item['id_admin']; ?>"> -->
                        <!-- <button class="btn btn-danger" type="submit" name="delete_staff">Remove</button> -->
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php endforeach; ?>
    <?php else: ?>
        <p>No data available.</p>
    <?php endif; ?>
    
    <!-- /.container-fluid -->
    
</div>
<!-- End of Main Content -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modalmanager.min.js" integrity="sha512-/HL24m2nmyI2+ccX+dSHphAHqLw60Oj5sK8jf59VWtFWZi9vx7jzoxbZmcBeeTeCUc7z1mTs3LfyXGuBU32t+w==" crossorigin="anonymous"></script>
<!-- responsive tags for screen compatibility -->
<meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
<!-- custom css --> 
<link href="../BarangaySystem/customcss/regiformstyle.css" rel="stylesheet" type="text/css">
<!-- bootstrap css --> 
<link href="../BarangaySystem/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"> 
<!-- fontawesome icons -->
<script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>
<script src="../BarangaySystem/bootstrap/js/bootstrap.bundle.js" type="text/javascript"> </script>

<?php 
    include('dashboard_sidebar_end.php');
?>
