<?php
    ini_set('display_errors',0);
    error_reporting(E_ALL ^ E_WARNING);
    require('../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $bmis->validate_admin();
    $view = $staffbmis->view_single_user();
    // print_r($view);
    // $staffbmis->create_staff();
    // $upstaff = $staffbmis->update_staff();
    // $staffbmis->delete_staff();
    $staffcount = $staffbmis->count_user();
    

?>

<?php 
    include('dashboard_sidebar_start.php');
?>

<!-- Begin Page Content -->

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-flex align-items-center">
    <a class="btn btn-primary" href="admin_client.php">Back</a>
    <h1 class="mb-0 ml-2">Client Information</h1>
</div>


    

    <div class="container">
        <div class="row">
            <div clas="card p-2">
                <form method="post" enctype="multipart/form-data"> 
                    <div class="row">
                        <div class="col-12 text-center mb-3">   
                            <img id="blah" src="../images/placeholder/user-placeholder.png" class="" alt="User Picture" width="150">
                            <!-- <img src="<?= $user['picture'] ?>" class="img-fluid" alt="Modal Image" width="100"> -->
                        </div>                          
                        <div class="col-md-4">
                            <div class="form-group">
                                <label> First Name: </label>
                                <input type="text" class="form-control" name="fname" value="<?= $view['fname'] ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label> Last Name: </label>
                                <input type="text" class="form-control" name="lname" value="<?= $view['lname'] ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label> Middle Initial: </label>
                                <input type="text" class="form-control" name="mi" value="<?= $view['mi'] ?>" required>
                            </div>
                        </div>    
                        <div class="col-md-4">
                            <div class="form-group">
                                <label> Sex </label>
                                <input type="text" class="form-control" name="sex" value="<?= $view['sex'] ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label> Address </label>
                                <input type="text" class="form-control" name="address" value="<?= $view['address'] ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label> Contact Number </label>
                                <input type="text" class="form-control" name="contact" value="<?= $view['contact'] ?>" required>
                            </div>
                        </div>  
                        <div class="col-md-4">
                            <div class="form-group">
                                <label> Birthdate </label>
                                <input type="text" class="form-control" name="birthdate" value="<?= $view['birthdate'] ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label> Nationality </label>
                                <input type="text" class="form-control" name="nationality" value="<?= $view['nationality'] ?>" required>
                            </div>
                        </div>                           
                        <div class="col">
                            <div class="form-group">
                                <label>Email: </label>
                                <input type="text" class="form-control" name="email" value="<?= $view['email'] ?>" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>   
        </div>
    </div>
</div>
<!-- End of Main Content -->

