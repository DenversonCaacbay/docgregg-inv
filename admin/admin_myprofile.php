<?php
    
    error_reporting(E_ALL ^ E_WARNING);
    ini_set('display_errors',0);
    require('../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    
    $user = $staffbmis->view_single_staff($userdetails['id_admin']);
    $staffbmis->update_staff($userdetails['id_admin']);
    $staffbmis->update_password($userdetails['id_admin']);
   
?>

<?php 
    include('dashboard_sidebar_start.php');
?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>


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
        <div class="col-md-4 mt-3">
            <?php if (empty($user['picture'])): ?>
                <img id="blah" src="../assets/placeholder/user-placeholder.png" class="img-fluid mt-5" width="300" alt="User Picture">
            <?php else: ?>
                <img id="blah" src="<?= $user['picture']?>" class="img-fluid rounded mt-5" width="300"  alt="User Picture" data-bs-toggle="modal" data-bs-target="#changeProf">
            <?php endif; ?>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary mt-2 w-100" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Update Profile
            </button>
            <button type="button" class="btn btn-primary mt-2 w-100" data-bs-toggle="modal" data-bs-target="#changePass">
            Change Password
            </button>


<!-- Modal Picture-->
<div class="modal fade" id="changeProf" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Picture</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form method="post" enctype="multipart/form-data">
    <!-- <div class="custom-file form-group">
        <input type="file" onchange="readURL(this);" class="custom-file-input" id="customFile" name="new_picture">
        <label class="custom-file-label" for="customFile">Choose File Photo</label>
    </div> -->
    <input type="file"  onchange="readURL(this, 'blah');" class="form-control" name="new_picture" required>
    <div class="cropper-container mt-3 w-50">
        <!-- Use a default image placeholder -->
        <img id="cropper-image" src="../assets/placeholder/user-placeholder.png" class="mt-5" alt="User Picture">
    </div>
    <!-- Hidden input field to store the cropped image data -->
    <input type="hidden" id="cropped-image" name="cropped_image">
    <div class="col-6" hidden>
                    <div class="form-group">
                        <label> First Name: </label>
                        <input type="text" class="form-control" name="fname" value="<?= $user['fname']; ?>">
                    </div>
                </div>
                <div class="col-6" hidden>
                    <div class="form-group">
                        <label> Last Name: </label>
                        <input type="text" class="form-control" name="lname" value="<?= $user['lname']; ?>">
                    </div>
                </div>
                <div class="col-12" hidden>
                    <div class="form-group">
                        <label>Email: </label>
                        <input type="text" class="form-control" name="email" value="<?= $user['email']; ?>">
                    </div>
                </div>
                <div class="col-12" hidden> 
                    <div class="form-group">
                        <label> Position: </label>
                        <input type="text" class="form-control" name="position" value="<?= $user['position']; ?>" >
                    </div>
                </div>
                <div class="col-12" hidden> 
                    <div class="form-group">
                        <label> Role: </label>
                        <input type="text" class="form-control" name="role" value="<?= $user['role']; ?>" >
                    </div>
                </div>
    <button type="submit" class="btn btn-primary w-100 mt-2" name="update_staff">Update</button>
</form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Profile-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Profile</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" enctype="multipart/form-data"> 
            <div class="row">
                <div class="col-md-12 mb-2">
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
                <div class="col-12">
                    <div class="form-group">
                        <label>Email: </label>
                        <input type="text" class="form-control" name="email" value="<?= $user['email']; ?>" required>
                    </div>
                </div>
                <div class="col-12"> 
                    <div class="form-group">
                        <label> Position: </label>
                        <input type="text" class="form-control" name="position" value="<?= $user['position']; ?>" >
                    </div>
                </div>
                <div class="col-12"> 
                    <div class="form-group">
                        <label> Role: </label>
                        <input type="text" class="form-control" name="role" value="<?= $user['role']; ?>" >
                    </div>
                </div>
                <div class="col-12"><button class="btn btn-primary w-100" style="margin-top: 35px;font-size: 18px; border-radius:5px;" type="submit" name="update_staff"> Update </button></div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Password-->
<div class="modal fade" id="changePass" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Change Password</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label> New Password </label>
                        <input type="password" class="form-control" id="newPassword" placeholder="New Password" name="new_password" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label> Confirm Password </label>
                        <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password" name="confirm_password" required>
                    </div>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" onclick="togglePasswordVisibility()" type="checkbox" role="switch" id="showPasswordCheckbox">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Show Password</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <button class="btn btn-primary w-100 " style="margin-top: 35px;font-size: 18px; border-radius:5px;" type="submit" name="update_password">Update Password</button>
                </div>  
            </div>
        </form>           
      </div>
     
    </div>
  </div>
</div>
        </div>
        <div class="col-md-8"> 
            <div class="card mt-3">
                <div class="card-header bg-primary text-white">Profile Details</div>
                <div class="card-body">
                    <!-- <form method="post" enctype="multipart/form-data">  -->
                        <div class="row">
                            <!-- <div class="col-md-12 mb-2">
                                <div class="custom-file form-group">
                                    <input type="file" onchange="readURL(this);" value="<?= $user['new_picture']?>" class="custom-file-input" id="customFile" name="new_picture">
                                    <label class="custom-file-label" for="customFile">Choose File Photo</label>
                                </div>
                            </div> -->
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label> Name: </label>
                                    <input type="text" class="form-control" name="fname" value="<?= $user['fname']; ?> <?= $user['lname']; ?>" readonly>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Email: </label>
                                    <input type="text" class="form-control" name="email" value="<?= $user['email']; ?>" readonly>
                                </div>
                            </div>

                            <div class="col-12"> 
                                <div class="form-group">
                                    <label> Position: </label>
                                    <input type="text" class="form-control" name="position" value="<?= $user['position']; ?>" readonly>
                                </div>
                            </div>

                            <div class="col-12"> 
                                <div class="form-group">
                                    <label> Role: </label>
                                    <input type="text" class="form-control" name="role" value="<?= $user['role']; ?>" readonly>
                                </div>
                            </div>
                            <!-- <div class="col-3"><button class="btn btn-primary w-100" style="margin-top: 35px;font-size: 18px; border-radius:5px;" type="submit" name="update_staff"> Update </button></div> -->
                        </div>

                            <!-- <a href="admin_inventory.php" class="btn btn-danger" style="width: 120px; font-size: 18px; border-radius:5px; margin-left:35%;"> Back </a> -->
                        
                    <!-- </form> -->
                </div>
            </div>
            <!-- <div class="card mt-3">
                <div class="card-header bg-primary text-white">Change Password</div>
                    <div class="card-body p-3">
                    <form method="post">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label> New Password </label>
                                    <input type="password" class="form-control" id="newPassword" placeholder="New Password" name="new_password" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label> Confirm Password </label>
                                    <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password" name="confirm_password" required>
                                </div>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" onclick="togglePasswordVisibility()" type="checkbox" role="switch" id="showPasswordCheckbox">
                                    <label class="form-check-label" for="flexSwitchCheckDefault">Show Password</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                            <button class="btn btn-primary w-100 " style="margin-top: 35px;font-size: 18px; border-radius:5px;" type="submit" name="update_password">Update Password</button>
                            </div>
                           
                        </div>
                           
                            
                           
                           <input type="hidden" name="email" value="<?php echo $user['id_admin']; ?>"> -->
                            
                        <!-- </form> 
                    </div>
                </div>
            </div>  -->
    </div>


</div>
    
    <!-- /.container-fluid -->
    
</div>
<script>
    // Initialize Cropper.js on the image
    var cropper = new Cropper(document.getElementById('cropper-image'), {
        aspectRatio: 1, // 1:1 aspect ratio (square)
        viewMode: 1, // Display the cropped area in the container
        autoCropArea: 1, // Automatically crop the entire image
        crop: function(event) {
            // Get the cropped canvas
            var canvas = cropper.getCroppedCanvas();
            // Get the cropped image data (base64 encoded)
            var croppedImage = canvas.toDataURL();
            // Set the value of the hidden input field to the cropped image data
            document.getElementById('cropped-image').value = croppedImage;
        }
    });

    // Function to display the selected image in the Cropper.js instance
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                // Set the source of the cropper image to the uploaded file
                cropper.replace(e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
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
