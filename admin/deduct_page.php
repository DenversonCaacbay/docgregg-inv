<?php
   error_reporting(E_ALL ^ E_WARNING);
   require('../classes/staff.class.php');
   $userdetails = $bmis->get_userdata();
   $user = $staffbmis->view_single_staff($userdetails['id_admin']);
   $bmis->validate_admin();
    $staffbmis->deduct_inventory();

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
        <a class="btn btn-primary" href="deduct_page.php">Back</a>
        <h4 class="mb-0 ml-2">Deduct Quantity</h4>
    </div>
                
    <div class="row"> 
        <div class="col-md-12"> 
            <form method="post">
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
                        <div class="row">
                        <div class="col-md-12 " hidden>
                                <div class="custom-file form-group">
                                    <input type="file" onchange="readURL(this);" value="<?= $item['picture']?>" class="custom-file-input" id="customFile" name="new_picture">
                                    <label class="custom-file-label" for="customFile">Choose File Photo</label>
                                    <div class="valid-feedback">Valid.</div>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3" hidden>
                                <div class="form-group">
                                    <label> Product Name: </label>
                                    <input type="text" class="form-control" name="name"  value="<?= $item['name']?>" required>
                                </div>
                            </div>
                            <div class="col-md-6" hidden>
                                <div class="form-group">
                                    <label class="mtop" >Price: </label>
                                    <input type="number" class="form-control" name="price"  value="<?= $item['price']?>" step=".01" required>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-top:10%;"> 
                                <div class="form-group">
                                    <label class="mtop"> Total Quantity: </label>
                                    <input type="number" class="form-control" name="total_quantity" value="<?= $item['quantity'] ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-12"> 
                                <div class="form-group">
                                    <label class="mtop"> Quantity: </label>
                                    <input type="number" class="form-control" name="qty" value="" required>
                                </div>
                            </div>
                            <div class="col" hidden>
                                <div class="form-group">
                                    <label class="mtop">Category</label>
                                    <input type="text" class="form-control" name="category" value="<?= $item['category']?>" readonly>
                                </div>
                            </div>
                                <div class="col-md-12" hidden>
                                    <div class="form-group">
                                        <label class="mtop"> Purchased Date: </label>
                                        <input type="date" class="form-control" name="bought_date" value="<?= $item['purchased_at']?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12" hidden>
                                    <div class="form-group">
                                        <label class="mtop"> Expiration Date: </label>
                                        <input type="date" class="form-control" name="exp_date" value="<?= $item['expired_at']?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="mtop"> Type: </label>
                                        <input type="text" class="form-control" name="type" value="<?= $item['type']?>" readonly>
                                    </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label> Reason To Deduct Item: </label>
                                    <input type="text" class="form-control" name="remarks"  value="" required>
                                </div>
                            </div>
                        </div>
                        <input name="inv_id" type="hidden" value="<?= $view['inv_id']?>">
                        <input type="hidden" class="form-control" name="role" value="resident">
                            
                        <button class="btn btn-primary w-100" style=" font-size: 18px; border-radius:5px;" type="submit" name="deduct_inventory"> Deduct Item </button>

                        </div>
                    </div>
                </div>
            </form> 
        </div>
    </div>

</div>




<!-- /.container-fluid -->

<!-- End of Main Content -->

