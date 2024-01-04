<?php
    
    ini_set('display_errors',0);
    error_reporting(E_ALL ^ E_WARNING);
    require('../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $bmis->validate_admin();
    $view = $staffbmis->view_user();
    // $bmis->validate_admin();
    // $bmis->delete_bspermit();
    // $view = $bmis->view_bspermit();
    $id_resident = $_GET['id_resident'];
    // $resident = $residentbmis->get_single_bspermit($id_resident);
   
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
        text-align: center;
    }
</style>

<!-- Begin Page Content -->

<div class="container-fluid">

    <!-- Page Heading -->

    <div class="d-flex align-items-center">
        <a class="btn btn-primary" href="admin_client_pet.php">Back</a>
        <h1 class="mb-0 ml-2">Add Record</h1>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="container"  style="margin-top: 5em;">   
                <div class="card" style="margin-bottom: 3em;">     
                    <form method="post" enctype='multipart/form-data' class="mt-1 p-2">
                    <!-- Rest of your form code -->
                        <div class="row mt-3">
                            <div class="col">
                                <div class="form-group">
                                    <label> Pet Name: </label>
                                    <input type="text" class="form-control" name="pet_name" required>
                                </div>
                                <div class="form-group">
                                    <label> Vaccine Taken: </label>
                                    <input type="text" class="form-control" name="pet_name" required>
                                </div>
                                <div class="form-group">
                                    <label> Date Vaccinated: </label>
                                    <input type="text" class="form-control" name="pet_name" required>
                                </div>
                                <div class="form-group">
                                    <label> Next Vaccination: </label>
                                    <input type="text" class="form-control" name="pet_name" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <input type="submit" class="btn btn-primary w-100 mb-3" name="add_pet" value="Submit"/>
                            </div>
                        </div>
                    </form>             
                </div>
            </div>
        </div>
    </div> 
</div>
<!-- End of Main Content -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modalmanager.min.js" integrity="sha512-/HL24m2nmyI2+ccX+dSHphAHqLw60Oj5sK8jf59VWtFWZi9vx7jzoxbZmcBeeTeCUc7z1mTs3LfyXGuBU32t+w==" crossorigin="anonymous"></script>
<!-- responsive tags for screen compatibility -->

