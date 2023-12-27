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
                <div class="card-header bg-primary text-white"> Add Item Data</div>
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
                                    <label> Product Name: </label>
                                    <input type="text" class="form-control" name="lname"  value="<?= $view['lname']?>" required>
                                </div>
                            </div>
                            
                            <div class="col">
                                <div class="form-group">
                                    <label class="mtop" >Price: </label>
                                    <input type="number" class="form-control" name="fname"  value="<?= $view['fname']?>" required>
                                </div>
                            </div>

                            <div class="col"> 
                                <div class="form-group">
                                    <label class="mtop"> Quantity: </label>
                                    <input type="number" class="form-control" name="mi"value="<?= $view['mi']?>" required>
                                </div>
                            </div>
                        </div>



                    <br>
                    <hr>

                        <input type="hidden" class="form-control" name="role" value="resident">
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

<!-- End of Main Content -->

