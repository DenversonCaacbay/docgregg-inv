<?php
   error_reporting(E_ALL ^ E_WARNING);
   require('../classes/staff.class.php');
   $userdetails = $bmis->get_userdata();
   $user = $staffbmis->view_single_staff($userdetails['id_admin']);
   $bmis->validate_admin();
    $staffbmis->update_inventory_low();
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
        <a class="btn btn-primary" href="admin_low_inventory.php">Back</a>
        <h4 class="mb-0 ml-2">Add Item Stocks</h4>
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
                        <div class="row">
                        <div class="col-md-12 " hidden>
                                <!-- <label>Item Picture:</label> -->
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
                            <div class="col-md-12" style="margin-top:5%;"> 
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
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="mtop"> Purchased Date: </label>
                                        <input type="date" class="form-control" name="bought_date" value="" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="mtop"> Expiration Date: </label>
                                        <input type="date" class="form-control" name="exp_date" value="" required>
                                    </div>
                            </div>
                        </div>
                        <input name="inv_id" type="hidden" value="<?= $view['inv_id']?>">
                        <input type="hidden" class="form-control" name="role" value="resident">
                            
                        <button class="btn btn-primary w-100" style=" font-size: 18px; border-radius:5px;" type="submit" name="update_inventory"> Add Stocks </button>

                        </div>
                    </div>
                </div>
            </form> 
        </div>
    </div>

</div>


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

<script>
    $(document).ready(function () {
        // Add a change event handler to the Purchased Date input
        $('input[name="bought_date"]').on('change', function () {
            // Get the selected Purchased Date value
            var purchasedDate = new Date($(this).val());

            // Calculate the minimum Expiration Date (6 months from the Purchased Date)
            var minExpirationDate = new Date(purchasedDate.getFullYear(), purchasedDate.getMonth() + 12, purchasedDate.getDate());

            // Set the minimum Expiration Date value to the Expiration Date input
            $('input[name="exp_date"]').attr('min', formatDate(minExpirationDate));
        });

        // Function to format date as 'YYYY-MM-DD'
        function formatDate(date) {
            var year = date.getFullYear();
            var month = (date.getMonth() + 1).toString().padStart(2, '0');
            var day = date.getDate().toString().padStart(2, '0');
            return year + '-' + month + '-' + day;
        }
    });
</script>

<!-- /.container-fluid -->

<!-- End of Main Content -->

