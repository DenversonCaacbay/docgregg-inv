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
    <div class="d-flex align-items-center">
        <a class="btn btn-primary" href="admin_low_inventory.php">Back</a>
        <h1 class="mb-0 ml-2">Update Item Data</h1>
    </div>
                
    <div class="row"> 
        <div class="col-md-2"> </div> 
        <div class="col-md-8"> 
            <div class="card mt-3">
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data"> 
                        <div class="row">
                            <!--  -->
                            <div class="col-md-12">
                                <!-- <label>Item Picture:</label> -->
                                <?php if (is_null($item['picture'])): ?>
                                    <img id="blah" src="../images/placeholder/item-placeholder.png" class="img-size" alt="Item Picture">
                                <?php else: ?>
                                    <img id="blah" src="../uploads/<?= $item['picture']?>" class="img-size" alt="Item Picture">
                                <?php endif; ?>
                                <br>
                            </div>

                            <br><br>

                            <div class="col">
                                <div class="form-group">
                                    <label> Product Name: </label>
                                    <input type="text" class="form-control" name="name"  value="<?= $item['name']?>" readonly>
                                </div>
                            </div>
                            
                            <div class="col">
                                <div class="form-group">
                                    <label class="mtop" >Price: </label>
                                    <input type="number" class="form-control" name="price"  value="<?= $item['price']?>" step=".01" readonly>
                                </div>
                            </div>

                            <div class="col"> 
                                <div class="form-group">
                                    <label class="mtop"> Quantity: </label>
                                    <input type="number" class="form-control" name="qty"value="<?= $item['quantity']?>" required>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label class="mtop">Category</label>
                                    <select class="form-control" name="category" id="category" readonly>
                                        <option value="">Choose Category</option>
                                        <option value="Medicine" <?php echo ($item['category'] == 'Medicine') ? 'selected="selected"' : ''; ?>>Medicine</option>
                                        <option value="Vaccine" <?php echo ($item['category'] == 'Vaccine') ? 'selected="selected"' : ''; ?>>Vaccine</option>
                                        <option value="Dog Food" <?php echo ($item['category'] == 'Dog Food') ? 'selected="selected"' : ''; ?>>Dog Food</option>
                                        <option value="Cat food" <?php echo ($item['category'] == 'Cat food') ? 'selected="selected"' : ''; ?>>Cat food</option>
                                    </select>
                                </div>
                            </div>
                        </div>



                        <br>
                        <hr>

                        <input name="inv_id" type="hidden" value="<?= $view['inv_id']?>">
                        <input type="hidden" class="form-control" name="role" value="resident">
                            <!-- <a href="admin_inventory.php" class="btn btn-danger" style="width: 120px; font-size: 18px; border-radius:5px; margin-left:35%;"> Back </a> -->
                        <button class="btn btn-primary W-100" style=" font-size: 18px; border-radius:5px;" type="submit" name="update_inventory"> Update </button>
                    </form>
                </div>
            </div>
            <div class="col-md-2"> </div>
        </div>
    </div>

</div>

<!-- /.container-fluid -->

<!-- End of Main Content -->

