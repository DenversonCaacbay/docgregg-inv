<?php
   error_reporting(E_ALL ^ E_WARNING);
   require('../classes/staff.class.php');
   $userdetails = $bmis->get_userdata();
   $user = $staffbmis->view_single_staff($userdetails['id_admin']);
   $bmis->validate_admin();
   $staffbmis->create_inventory_all();
//    print_r($userdetails['role']);
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
    <div class="d-flex align-items-center">
        <a class="btn btn-primary" href="admin_inventory.php">Back</a>
        <h4 class="mb-0 ml-2">Add Product</h4>
    </div>
    <!-- Page Heading -->
                
    <div class="row"> 
        <div class="col-md-12"> 
            <form method="post" enctype="multipart/form-data"> 
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <?php if (is_null($item['picture'])): ?>
                                    <img id="blah" src="../assets/placeholder/item-placeholder.png" height="150" width="150" alt="Pet Picture">
                                <?php else: ?>
                                    <img id="blah" src="../<?= $item['picture']?>" width="300" height="300" alt="Pet Picture">
                                <?php endif; ?>
                            </div>
                        </div>
                        
                       
                    </div>
                    <div class="col-md-12">
                        <div class="container">
                            <div class="row me-3">
                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <label> Type of Inventory </label>
                                    <select class="form-control" name="type" id="type" required onchange="updateCategoryOptions()">
                                        <option value="" class="text-center">-- Select Type --</option>
                                        <option value="Internal">Internal Inventory</option>
                                        <option value="External">External Inventory</option>
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label> Select Image File:  </label>

                                <input type="file"  onchange="readURL(this, 'blah');" class="form-control" name="new_picture" required>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> Code: </label>
                                    <input type="text" class="form-control" name="code" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> Product Name: </label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="mtop" >Capital:  </label>
                                    <input type="number" class="form-control" id="capital" name="input_capital" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="mtop" >Profit: % </label>
                                    <!-- <input type="number" class="form-control" id="profit" name="input_profit" required> -->
                                    <select class="form-control" id="profit" name="input_profit">
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="mtop" >Price: </label>
                                    <input type="number" class="form-control" id="total_price" name="price" readonly required>
                                </div>
                            </div>
                            <div class="col-md-3"> 
                                <div class="form-group">
                                    <label class="mtop"> Quantity: </label>
                                    <input type="number" class="form-control" name="qty" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="mtop">Category</label>
                                    <select class="form-control" name="category" id="category" required>
                                        <option value="">Choose Category</option>
                                        <!-- Options will be dynamically updated based on the selection -->
                                    </select>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mtop"> Purchased Date: </label>
                                    <input type="date" class="form-control" name="bought_date" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mtop"> Expiration Date: </label>
                                    <input type="date" class="form-control" name="exp_date" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label> Notify When low Stock: </label>
                                    <input type="number" class="form-control" name="low_stock" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-primary w-100" style="font-size: 18px; border-radius:5px;" type="submit" name="create_inventory"> Create </button>
                            </div>
                            
                        </div>
                        </div>
                        
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function updateCategoryOptions() {
        var typeSelect = document.getElementById('type');
        var categorySelect = document.getElementById('category');
        
        // Clear existing options
        categorySelect.innerHTML = '';
        
        // Add default option
        var defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.text = 'Choose Category';
        categorySelect.appendChild(defaultOption);
        
        // Internal Inventory options
        if (typeSelect.value === 'Internal') {
            addOption(categorySelect, 'Medicine', 'Medicine');
            addOption(categorySelect, 'Vaccine', 'Vaccine');
            addOption(categorySelect, 'Syringe', 'Syringe');
        }
        // External Inventory options
        else if (typeSelect.value === 'External') {
            addOption(categorySelect, 'Shampoo', 'Shampoo');
            addOption(categorySelect, 'Dog Food', 'Dog Food');
            addOption(categorySelect, 'Cat food', 'Cat Food');
        }
    }
    
    function addOption(selectElement, value, text) {
        var option = document.createElement('option');
        option.value = value;
        option.text = text;
        selectElement.appendChild(option);
    }
</script>

<script>
    function readURL(input, imageId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                document.getElementById(imageId).src = e.target.result;
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
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

