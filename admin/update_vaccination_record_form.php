<?php
   error_reporting(E_ALL ^ E_WARNING);
   require('../classes/resident.class.php');
   $userdetails = $bmis->get_userdata();
   $bmis->validate_admin();
//    $id_user = $_GET['id_user'];
//    $view = $residentbmis->get_single_resident($id_user);
//    $residentbmis->update_resident();

?>

<?php 
    include('dashboard_sidebar_start.php');
?>

<!-- Begin Page Content -->

<div class="container-fluid">

    <!-- Page Heading -->
                
    <div class="row"> 
        <div class="col-md-2"> </div> 
        <div class="col-md-8"> 
            <div class="card">
                <div class="card-header bg-primary text-white"> Update Vaccination Record</div>
                <div class="card-body">
                    <form method="post"> 
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label> Picture </label>
                                    <input type="file" class="form-control" name="pic"  value="<?= $view['picture']?>" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label> Last Name: </label>
                                    <input type="text" class="form-control" name="lname"  value="<?= $view['lname']?>" required>
                                </div>
                            </div>
                            
                            <div class="col">
                                <div class="form-group">
                                    <label class="mtop" >First Name: </label>
                                    <input type="text" class="form-control" name="fname"  value="<?= $view['fname']?>" required>
                                </div>
                            </div>

                            <div class="col"> 
                                <div class="form-group">
                                    <label class="mtop"> Middle Name: </label>
                                    <input type="text" class="form-control" name="mi"value="<?= $view['mi']?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="row"> 
                            <div class="col">
                                <div class="form-group">
                                    <label class="mtop">Contact Number:</label>
                                    <input type="tel" class="form-control" name="contact" maxlength="11" pattern="[0-9]{11}" value="<?= $view['contact']?>" required>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label>Email: </label>
                                    <input type="email" class="form-control" name="email"  value="<?= $view['email']?>" required>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="mtop">Birth Date: </label>
                                    <input type="date" class="form-control" name="bdate"  value="<?= $view['bdate']?>" required>
                                </div>
                            </div>

    
                            <div class="col">
                                <div class="form-group">
                                    <label class="mtop">Nationality: </label>
                                    <input type="text" class="form-control" name="nationality"  value="<?= $view['nationality']?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col"> 
                                <div class="form-group">
                                    <label>Status: </label>
                                    <input class="form-control" name="status" id="status" value="<?= $view['status']?>"  required>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label>Age</label>
                                    <input type="number" class="form-control" name="age" value="<?= $view['age']?>" required>
                                </div>
                            </div>

                            <div class="col rb">
                                <div class="form-group">
                                    <label class="mtop">Sex</label>
                                    <input type="text" class="form-control" name="sex" id="sex" value="<?= $view['sex']?>" required>
                                </div>
                            </div>         
                        </div>


                    <br>
                    <hr>

                        <input type="hidden" class="form-control" name="role" value="resident">
                            <a href="admin_vaccination_record.php" class="btn btn-danger" style="width: 120px; font-size: 18px; border-radius:5px; margin-left:35%;"> Back </a>
                        <button class="btn btn-primary" style="width: 120px; font-size: 18px; border-radius:5px;" type="submit" name="update_resident"> Update </button>
                    </form>
                </div>
            </div>
            <div class="col-md-2"> </div>
        </div>
    </div>

</div>

<!-- /.container-fluid -->

<!-- End of Main Content -->

