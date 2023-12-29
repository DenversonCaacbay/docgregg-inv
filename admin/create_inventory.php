<?php
   error_reporting(E_ALL ^ E_WARNING);
   require('../classes/staff.class.php');
   $userdetails = $bmis->get_userdata();
   $bmis->validate_admin();
   $staffbmis->create_inventory();

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
                    <form method="post" enctype="multipart/form-data"> 
                        <div class="row">
                            <div class="col-md-12">
                                <!-- <label>Item Picture:</label> -->
                                <?php if (is_null($item['picture'])): ?>
                                    <img id="blah" src="../images/placeholder/item-placeholder.png" class="img-size" alt="Pet Picture">
                                <?php else: ?>
                                    <img id="blah" src="../<?= $item['picture']?>" class="img-size" alt="Pet Picture">
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
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                            </div>
                            
                            <div class="col">
                                <div class="form-group">
                                    <label class="mtop" >Price: </label>
                                    <input type="number" class="form-control" name="price"  required>
                                </div>
                            </div>

                            <div class="col"> 
                                <div class="form-group">
                                    <label class="mtop"> Quantity: </label>
                                    <input type="number" class="form-control" name="qty" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label class="mtop">Category</label>
                                    <select class="form-control" name="categpry" id="category" required>
                                        <option value="" <?php echo empty($_POST['sex']) ? 'selected' : ''; ?>>Choose Category</option>
                                        <option value="Male">Medicine</option>
                                        <option value="Female">Vaccine</option>
                                        <option value="Female">Dog Food</option>
                                        <option value="Female">Cat food</option>
                                    </select>
                                </div>
                            </div>
                        </div>



                    <br>
                    <hr>

                        <input type="hidden" class="form-control" name="role" value="resident">
                            <a href="admin_inventory.php" class="btn btn-danger" style="width: 120px; font-size: 18px; border-radius:5px; margin-left:35%;"> Back </a>
                        <button class="btn btn-primary" style="width: 120px; font-size: 18px; border-radius:5px;" type="submit" name="create_inventory"> Create </button>
                    </form>
                </div>
            </div>
            <div class="col-md-2"> </div>
        </div>
    </div>

</div>

<!-- /.container-fluid -->

<!-- End of Main Content -->

