<?php
    
    error_reporting(E_ALL ^ E_WARNING);
    ini_set('display_errors',0);
    require('classes/resident.class.php');
    $userdetails = $bmis->get_userdata();
    $user = $residentbmis->get_single_resident($userdetails['id_user']);
    $residentbmis->update_resident($userdetails['id_user']);
    // $bmis->validate_admin();
    // $bmis->delete_brgyid();
    // $view = $bmis->view_brgyid();
    // $id_resident = $_GET['id_resident'];
    // $resident = $residentbmis->get_single_certofres($id_resident);
    print_r($user);
   
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

    <div class="row"> 
        <div class=""> 
            <h1> My Profile</h1>
        </div>
    </div>

    <br><br>

<!-- Begin Page Content -->

<div class="container-fluid">

    <!-- Page Heading -->
                
    <div class="row"> 
        <div class="col-md-2"> </div> 
        <div class="col-md-8"> 
            <div class="card">
                <div class="card-header bg-primary text-white">Profile Details</div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data"> 
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label> First Name: </label>
                                    <input type="text" class="form-control" name="fname" value="<?= $user['fname']; ?>" required>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label> Last Name: </label>
                                    <input type="text" class="form-control" name="lname" value="<?= $user['lname']; ?>" required>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label> Middle Initial: </label>
                                    <input type="text" class="form-control" name="mi" value="<?= $user['mi']; ?>" required>
                                </div>
                            </div>
                            
                            <div class="col">
                                <div class="form-group">
                                    <label>Email: </label>
                                    <input type="text" class="form-control" name="email" value="<?= $user['email']; ?>" required>
                                </div>
                            </div>

                            <div class="col"> 
                                <div class="form-group">
                                    <label> Role: </label>
                                    <input type="text" class="form-control" name="role" value="<?= $user['role']; ?>" required>
                                </div>
                            </div>
                        </div>



                    <br>
                    <hr>

                            <a href="admin_inventory.php" class="btn btn-danger" style="width: 120px; font-size: 18px; border-radius:5px; margin-left:35%;"> Back </a>
                        <button class="btn btn-primary" style="width: 120px; font-size: 18px; border-radius:5px;" type="submit" name="update_resident"> Update </button>
                    </form>
                </div>
            </div>
            <div class="col-md-2"> </div>
        </div>
    </div>

</div>
    
    <!-- /.container-fluid -->
    
</div>
<!-- End of Main Content -->

<?php 
    include('dashboard_sidebar_end.php');
?>
