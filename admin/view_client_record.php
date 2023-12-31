<?php
   error_reporting(E_ALL ^ E_WARNING);
   require('../classes/staff.class.php');
   $userdetails = $bmis->get_userdata();
   $bmis->validate_admin();
    $staffbmis->update_inventory();
    $item = $staffbmis->view_single_inventory();
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
                <div class="card-header bg-primary text-white"> Update Item Data</div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data"> 
                        <div class="row">
                            <!--  -->
                            <div class="col-md-12">
                                <!-- <label>Item Picture:</label> -->
                                <?php if (is_null($item['picture'])): ?>
                                    <img id="blah" src="../images/placeholder/item-placeholder.png" class="img-size" alt="Item Picture">
                                <?php else: ?>
                                    <img id="blah" src="../uploads/<?= $item['picture']?>" class="img-size" alt="Pet Picture">
                                <?php endif; ?>
                                <br>
                            </div>

                            <div class="col-md-12">
                                <!-- <label>Item Picture:</label> -->
                                <div class="custom-file form-group">
                                    <input type="file" onchange="readURL(this);" value="<?= $item['picture']?>" class="custom-file-input" id="customFile" name="new_picture">
                                    <label class="custom-file-label" for="customFile">Choose File Photo</label>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                            </div><br><br>

                            <div class="col">
                                <div class="form-group">
                                    <label> Product Name: </label>
                                    <input type="text" class="form-control" name="name"  value="<?= $item['name']?>" required>
                                </div>
                            </div>
                            
                            <div class="col">
                                <div class="form-group">
                                    <label class="mtop" >Price: </label>
                                    <input type="number" class="form-control" name="price"  value="<?= $item['price']?>" step=".01" required>
                                </div>
                            </div>

                            <div class="col"> 
                                <div class="form-group">
                                    <label class="mtop"> Quantity: </label>
                                    <input type="number" class="form-control" name="qty"value="<?= $item['quantity']?>" required>
                                </div>
                            </div>
                        </div>



                        <br>
                        <hr>

                        <input name="inv_id" type="hidden" value="<?= $view['inv_id']?>">
                        <input type="hidden" class="form-control" name="role" value="resident">
                            <a href="admin_inventory.php" class="btn btn-danger" style="width: 120px; font-size: 18px; border-radius:5px; margin-left:35%;"> Back </a>
                        <button class="btn btn-primary" style="width: 120px; font-size: 18px; border-radius:5px;" type="submit" name="update_inventory"> Update </button>
                    </form>
                </div>
            </div>
            <div class="col-md-2"> </div>
        </div>
    </div>

</div>

<!-- /.container-fluid -->

<!-- End of Main Content -->

