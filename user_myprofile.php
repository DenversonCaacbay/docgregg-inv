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
    // print_r($user);
   
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
<?php 
    include('user_navbar_start.php');
?>

<div class="container">

    <!-- Page Heading -->

    <div class="row"> 
        <div class="text-center mt-3"> 
            <h1 style="color: #0296be;"> My Profile</h1>
        </div>
    </div>

<!-- Begin Page Content -->

<div class="container">

    <!-- Page Heading -->
                
    <div class="row mt-3"> 
        <div class="col-md-2"> </div> 
        <div class="col-md-8"> 
            <div class="card border-0">
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data"> 
                        <div class="row">
                            <div class="col-12 text-center mb-3">
                            <div class="col-md-12">
                                <?php if (empty($user['picture'])): ?>
                                    <img id="blah" src="images/placeholder/user-placeholder.png" width="150" alt="User Picture">
                                <?php else: ?>
                                    <img id="blah" src="<?= $user['picture']?>" width="150" alt="User Picture">
                                <?php endif; ?>
                                <br>
                            </div>
                            <div class="col-md-12 mt-3 mb-2">
                                <!-- <label>Item Picture:</label> -->
                                <div class="custom-file form-group">
                                    <input type="file" onchange="readURL(this);" value="<?= $user['picture']?>" class="custom-file-input" id="customFile" name="new_picture">
                                    <label class="custom-file-label" for="customFile">Choose File Photo</label>
                                </div>
                            </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label> First Name: </label>
                                    <input type="text" class="form-control" name="fname" value="<?= $user['fname']; ?>" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label> Last Name: </label>
                                    <input type="text" class="form-control" name="lname" value="<?= $user['lname']; ?>" required>
                                </div>
                            </div>

                            <div class="col-md-4">
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

                        
                        </div>



                        <br>
                        <button class="btn btn-primary" style="width: 100%; font-size: 18px; border-radius:5px;" type="submit" name="update_resident"> Update Profile </button>
                        
                    </form>
                </div>
            </div>
            <div class="col-md-2"> </div>
        </div>
    </div>

</div>
    
    <!-- /.container-fluid -->
    
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>




<!-- End of Main Content -->

