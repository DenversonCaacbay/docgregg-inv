<?php
   error_reporting(E_ALL ^ E_WARNING);
   require('../classes/staff.class.php');
   $userdetails = $bmis->get_userdata();
   $bmis->validate_admin();
    $staffbmis->update_inventory_internal();
    $item = $staffbmis->view_single_inventory();
    if ($userdetails['role'] !== 'administrator') {
        // User is not an admin, display an alert
        echo '<script>alert("You are not authorized to access this page as admin.");</script>';
        // Redirect or take appropriate action if needed
        header('Location: admin_dashboard.php');
        exit();
    }
?>

<?php 
    include('dashboard_sidebar_start.php');
?>

<!-- Begin Page Content -->

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-flex align-items-center">
        <a class="btn btn-primary" href="admin_inventory_internal.php">Back</a>
        <h1 class="mb-0 ml-2">Update Item Data</h1>
    </div>
                
    <div class="row"> 
        <div class="col-md-12"> 
            <form method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-5">
                        <div class="col-md-12 mt-5">   
                            <?php if (is_null($item['picture'])): ?>
                                <img id="blah" src="../images/placeholder/item-placeholder.png" height="400" width="400" alt="Item Picture">
                            <?php else: ?>
                                <img id="blah" src="../uploads/<?= $item['picture']?>" height="400" width="400" alt="Item Picture">
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="container ">
                            <div class="row me-3">
                            <div class="col-md-12">
                                    <!-- <label>Item Picture:</label> -->
                                    <!-- <div class="custom-file form-group">
                                        <input type="file" onchange="readURL(this);" value="<?= $item['picture']?>" class="custom-file-input" id="customFile" name="new_picture">
                                        <label class="custom-file-label" for="customFile">Choose File Photo</label>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div> -->
                                    <input type="file"  onchange="readURL(this, 'blah');" class="form-control" name="new_picture" required>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <div class="form-group">
                                        <label> Product Name: </label>
                                        <input type="text" class="form-control" name="name"  value="<?= $item['name']?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="mtop" >Price: </label>
                                        <input type="number" class="form-control" name="price"  value="<?= $item['price']?>" step=".01" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6"> 
                                    <div class="form-group">
                                        <label class="mtop"> Quantity: </label>
                                        <input type="number" class="form-control" name="qty" value="<?= $item['quantity']?>" readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label class="mtop">Category</label>
                                        <input type="text" class="form-control" name="category" value="<?= $item['category']?>" readonly>
                                    </div>
                                </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="mtop"> Purchased Date: </label>
                                            <input type="date" class="form-control" name="bought_date" value="<?= $item['purchased_at']?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="mtop"> Expiration Date: </label>
                                            <input type="date" class="form-control" name="exp_date" value="<?= $item['expired_at']?>" readonly>
                                        </div>
                                    <input name="inv_id" type="hidden" value="<?= $view['inv_id']?>">
                                    <input type="hidden" class="form-control" name="role" value="resident">
                                        
                                    <button class="btn btn-primary w-100" style=" font-size: 18px; border-radius:5px;" type="submit" name="update_inventory_internal"> Update </button>
                                </div>
                                

                            </div>
                        

                        </div>
                        </div>
                        
                    </div>
                </div>
            </form> 
        </div>
    </div>

</div>

<!-- /.container-fluid -->

<!-- End of Main Content -->

