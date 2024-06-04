<?php
    error_reporting(E_ALL ^ E_WARNING);
    require('../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $bmis->validate_admin();

    // For Updating
    $staffbmis->update_inventory();
    $staffbmis->update_image();

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
    <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <a class="btn btn-primary" href="admin_inventory.php">Back</a>
            <h4 class="mb-0 ml-2">Update Item Data</h4>
        </div>
        <div class="d-flex align-items-center">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#imageModal">Image Update</button>
            <button class="btn btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#updateModal">Update Information</button>
        </div>
        
    </div>
                
    <div class="row"> 
        <div class="col-md-12"> 
            <form method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">   
                            <?php if (is_null($item['picture'])): ?>
                                <img src="../images/placeholder/item-placeholder.png" height="150" width="150" alt="Item Picture">
                            <?php else: ?>
                                <img src="../uploads/<?= $item['picture']?>" height="150" width="150" alt="Item Picture">
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Type of Inventory</label>
                                    <input type="text" class="form-control" name="type" value="<?= $item['type']?>" readonly/>
                                </div>
                                <!-- <div class="col-md-6">
                                    <label> Select Image File:  </label>
                                    <input type="file"  onchange="readURL(this, 'blah');" class="form-control" name="new_picture" required>
                                </div> -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label> Code: </label>
                                        <input type="text" class="form-control" name="code"  value="<?= $item['code']?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label> Product Name: </label>
                                        <input type="text" class="form-control" name="name"  value="<?= $item['name']?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                <div class="form-group">
                                    <label class="mtop" >Capital:  </label>
                                    <input type="number" class="form-control"  name="input_capital" value="<?= $item['capital']?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="mtop" >Profit: % </label>
                                    <input type="number" class="form-control" name="input_profit" value="<?= $item['profit']?>" readonly>
                                </div>
                            </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="mtop" >Price: </label>
                                        <input type="number" class="form-control" value="<?= $item['price']?>" step=".01" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3"> 
                                    <div class="form-group">
                                        <label class="mtop"> Quantity: 
                                        <a href="<?= $item['quantity'] <= $item['low_stock'] ? 'update_low_inventory_form.php?inv_id=' . $_GET['inv_id'] : "" ?>">
                                            <span class="mtop badge badge-<?= $item['quantity'] <= $item['low_stock'] ? "danger" : "success" ?>"> <?= $item['quantity'] <= $item['low_stock'] ? "Low" : "Good" ?> Stock
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
                                    <!-- <div class="col-md-12">
                                        <button class="btn btn-primary w-100" style=" font-size: 18px; border-radius:5px;" type="submit" name="update_inventory"> Update </button>
                                    </div> -->

                            </div>
                        

                        </div>
                        </div>
                        
                    </div>
                </div>
            </form> 
        </div>
    </div>

<!-- Update Information Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Product Details</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST">
        <div class="modal-body">
            <div class="col-md-12">
                <div class="form-group">
                    <label> Code: </label>
                    <input type="text" class="form-control" name="code"  value="" required>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label> Product Name: </label>
                    <input type="text" class="form-control" name="name"  value="" required>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="mtop" >Capital:  </label>
                    <input type="number" class="form-control" id="capital" name="input_capital" value="" required>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="mtop" >Profit: % </label>
                    <!-- <input type="number" class="form-control" id="profit" name="input_profit" required> -->
                    <select class="form-select" id="profit" name="input_profit">
                        <option value="10">10%</option>
                        <option value="20">20%</option>
                        <option value="30">30%</option>
                        <option value="40">40%</option>
                        <option value="50">50%</option>
                        <option value="60">60%</option>
                        <option value="70">70%</option>
                        <option value="80">80%</option>
                        <option value="90">90%</option>
                        <option value="99">99%</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="mtop" >Price: </label>
                    <input type="number" class="form-control" id="total_price" name="price"  value="" step=".01" readonly>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="update_inventory">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Update Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Product Image</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="col-md-4" hidden>
                <div class="form-group">
                    <label> Product Name: </label>
                    <input type="text" class="form-control" name="name"  value="<?= $item['name']?>" readonly>
                </div>
            </div>
            <div class="col-md-12">   
                <?php if (is_null($item['picture'])): ?>
                    <img id="blah" src="../images/placeholder/item-placeholder.png" height="150" width="150" alt="Item Picture">
                <?php else: ?>
                    <img id="blah" src="../uploads/<?= $item['picture']?>" height="150" width="150" alt="Item Picture">
                <?php endif; ?>
            </div>
            <div class="col-md-12">
                <label> Select Image File:  </label>
                <input type="file" onchange="readURL(this, 'blah');" class="form-control" name="new_picture" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="update_image">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

</div>

<!-- for capital, profit, price -->
<script>
    $(document).ready(function () {
        // Function to calculate total price
        function calculateTotalPrice() {
            var capital = parseFloat($('#capital').val());
            var profitPercentage = parseFloat($('#profit').val());

            // Check if capital and profit percentage are valid numbers
            if (!isNaN(capital) && !isNaN(profitPercentage)) {
                // Calculate total price using percentage profit
                var profitAmount = capital * (profitPercentage / 100);
                var totalPrice = capital + profitAmount;
                $('#total_price').val(totalPrice.toFixed(2)); // Display total price with 2 decimal places
            }
        }

        // Call calculateTotalPrice function when capital or profit percentage changes
        $('#capital, #profit').on('input', calculateTotalPrice);
    });
</script>


<!-- /.container-fluid -->

<!-- End of Main Content -->

