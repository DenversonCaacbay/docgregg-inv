<?php
   error_reporting(E_ALL ^ E_WARNING);
   require('../classes/staff.class.php');
   $userdetails = $bmis->get_userdata();
   $bmis->validate_admin();
    $staffbmis->update_inventory();
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
<style>
    label{
        font-size: 14px !important;
    }
    .form-control{
        font-size: 14px !important;
    }
</style>
<!-- Begin Page Content -->

<div class="container-fluid page-container">

    <!-- Page Heading -->
    <div class="d-flex align-items-center">
        <a class="btn btn-primary" href="admin_inventory.php">Back</a>
        <h4 class="mb-0 ml-2">Update Item Data</h4>
    </div>
                
    <div class="row"> 
        <div class="col-md-12"> 
            <form method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">   
                            <?php if (is_null($item['picture'])): ?>
                                <img id="blah" src="../images/placeholder/item-placeholder.png" height="150" width="150" alt="Item Picture">
                            <?php else: ?>
                                <img id="blah" src="../uploads/<?= $item['picture']?>" height="150" width="150" alt="Item Picture">
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Type of Inventory</label>
                                    <input type="text" class="form-control" name="type" value="<?= $item['type']?>" readonly/>
                                </div>
                                <div class="col-md-6">
                                    <label> Select Image File:  </label>
                                    <input type="file"  onchange="readURL(this, 'blah');" class="form-control" name="new_picture" required>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label> Product Name: </label>
                                        <input type="text" class="form-control" name="name"  value="<?= $item['name']?>" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                <div class="form-group">
                                    <label class="mtop" >Capital:  </label>
                                    <input type="number" class="form-control" id="capital" name="input_capital" value="<?= $item['capital']?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="mtop" >Profit: % </label>
                                    <input type="number" class="form-control" id="profit" name="input_profit" value="<?= $item['profit']?>" readonly>
                                </div>
                            </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="mtop" >Price: </label>
                                        <input type="number" class="form-control" name="price"  value="<?= $item['price']?>" step=".01" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3"> 
                                    <div class="form-group">
                                        <label class="mtop"> Quantity: 
                                        <a href="<?= $view['quantity'] <= 20 ? 'update_low_inventory_form.php?inv_id=' . $_GET['inv_id'] : "" ?>">
                                                <span class="mtop badge badge-<?= $view['quantity'] <= 20 ? "danger" : "success" ?>"> <?= $view['quantity'] <= 20 ? "Low" : "Good" ?> Stock
                                                </span>
                                            </a>
                                        </label>
                                        <input type="number" class="form-control" name="qty" value="<?= $item['quantity']?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="mtop">Category</label>
                                        <input type="text" class="form-control" name="category" value="<?= $item['category']?>" readonly>
                                    </div>
                                </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="mtop"> Purchased Date: </label>
                                            <input type="date" class="form-control" name="bought_date" value="<?= $item['purchased_at']?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div classs="form-group">
                                            <label class="mtop"> Expiration Date: </label>
                                            <input type="date" class="form-control" name="exp_date" value="<?= $item['expired_at']?>" readonly>
                                        </div>
                                        <input name="inv_id" type="hidden" value="<?= $view['inv_id']?>">
                                        <input type="hidden" class="form-control" name="role" value="resident">
                                    </div>
                                    <!-- <div class="col-md-12"> 
                                        <div class="form-group">
                                            <span class="mtop badge badge-<?= $view['quantity'] ? "success" : "danger" ?>"> <?= $view['quantity'] ? "Good" : "Low" ?> Stock</span>
                                            <input type="number" class="form-control" name="qty" value="<?= $item[''] ?: "0" ?>" readonly>
                                        </div>
                                    </div> -->
                                    <div class="col-md-12">
                                        <button class="btn btn-primary w-100" style=" font-size: 18px; border-radius:5px;" type="submit" name="update_inventory"> Update </button>
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

