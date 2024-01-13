<?php
    
    error_reporting(E_ALL ^ E_WARNING);
    ini_set('display_errors',0);
    require('../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $user = $staffbmis->view_single_staff($userdetails['id_admin']);
    $staffbmis->update_staff($userdetails['id_admin']);
    $staffbmis->update_password($userdetails['id_admin']);
    // $bmis->validate_admin();
    // $bmis->delete_brgyid();
    // $view = $bmis->view_brgyid();
    // $id_resident = $_GET['id_resident'];
    // $resident = $residentbmis->get_single_certofres($id_resident);
    // print_r($user);
   
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
    .form-check{
        margin-left: 20px;
    }
</style>

<!-- Begin Page Content -->

<div class="container-fluid">

    <!-- Page Heading -->

    <div class="row"> 
        <div class="col-12"> 
            <h1> My Profile</h1>
        </div>
    </div>


<!-- Begin Page Content -->

<div class="container-fluid">

    <!-- Page Heading -->
                
    <div class="row"> 
        <div class="col-md-6"> 
            <div class="card">
                <div class="card-header bg-primary text-white">Profile Details</div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data"> 
                        <div class="row">
                            <div class="col-md-12">
                                <?php if (empty($user['picture'])): ?>
                                    <img id="blah" src="../assets/placeholder/user-placeholder.png" width="100" alt="User Picture">
                                <?php else: ?>
                                    <img id="blah" src="<?= $user['picture']?>" width="100" alt="User Picture">
                                <?php endif; ?>
                                <br>
                            </div>
                            <div class="col-md-12 mb-2">
                                <div class="custom-file form-group">
                                    <input type="file" onchange="readURL(this);" value="<?= $user['new_picture']?>" class="custom-file-input" id="customFile" name="new_picture">
                                    <label class="custom-file-label" for="customFile">Choose File Photo</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label> First Name: </label>
                                    <input type="text" class="form-control" name="fname" value="<?= $user['fname']; ?>" required>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label> Last Name: </label>
                                    <input type="text" class="form-control" name="lname" value="<?= $user['lname']; ?>" required>
                                </div>
                            </div>

                            <!-- <div class="col-4">
                                <div class="form-group">
                                    <label> Middle Initial: </label>
                                    <input type="text" class="form-control" name="mi" value="<?= $user['mi']; ?>" required>
                                </div>
                            </div> -->
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Email: </label>
                                    <input type="text" class="form-control" name="email" value="<?= $user['email']; ?>" required>
                                </div>
                            </div>

                            <div class="col"> 
                                <div class="form-group">
                                    <label> Role: </label>
                                    <input type="text" class="form-control" name="role" value="<?= $user['role']; ?>" readonly>
                                </div>
                            </div>
                        </div>

                            <!-- <a href="admin_inventory.php" class="btn btn-danger" style="width: 120px; font-size: 18px; border-radius:5px; margin-left:35%;"> Back </a> -->
                        <button class="btn btn-primary w-100 mt-3" style="font-size: 18px; border-radius:5px;" type="submit" name="update_staff"> Update </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">Change Password</div>
            <div class="card-body p-3">
               <form method="post">
                    <div class="form-group">
                        <label> New Password </label>
                        <input type="password" class="form-control" id="newPassword" placeholder="New Password" name="new_password" required>
                    </div>
                    <div class="form-group">
                        <label> Confirm Password </label>
                        <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password" name="confirm_password" required>
                    </div>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" onclick="togglePasswordVisibility()" type="checkbox" role="switch" id="showPasswordCheckbox">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Show Password</label>
                    </div>
                    <!-- <input type="hidden" name="email" value="<?php echo $user['id_admin']; ?>"> -->
                    <button class="btn btn-primary w-100 mt-3" style="font-size: 18px; border-radius:5px;" type="submit" name="update_password">Update Password</button>
                </form> 
            </div>
            
        </div>
    </div>
    </div>


</div>
    
    <!-- /.container-fluid -->
    
</div>
<script>
    function togglePasswordVisibility() {
        var newPasswordInput = document.getElementById('newPassword');
        var confirmPasswordInput = document.getElementById('confirmPassword');
        var showPasswordCheckbox = document.getElementById('showPasswordCheckbox');

        if (showPasswordCheckbox.checked) {
            newPasswordInput.type = 'text';
            confirmPasswordInput.type = 'text';
        } else {
            newPasswordInput.type = 'password';
            confirmPasswordInput.type = 'password';
        }
    }
</script>
        <!-- <script>
            function myFunction() {
                var x = document.getElementById("myInput");
                    if (x.type === "password") {
                        x.type = "text";
                    } else {
                        x.type = "password";
                }
            }
        </script> -->
<!-- End of Main Content -->

<?php 
    include('dashboard_sidebar_end.php');
?>
