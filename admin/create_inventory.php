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
    <div class="d-flex align-items-center">
        <a class="btn btn-primary" href="admin_inventory.php">Back</a>
        <h1 class="mb-0 ml-2">Add Item Data</h1>
    </div>
    <!-- Page Heading -->
                
    <div class="row mt-3"> 
        <div class="col-md-12"> 
            <form method="post" enctype="multipart/form-data"> 
                <div class="row">
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-12 mt-5">
                                <?php if (is_null($item['picture'])): ?>
                                    <img id="blah" src="../images/placeholder/item-placeholder.png" height="400" width="400" alt="Pet Picture">
                                <?php else: ?>
                                    <img id="blah" src="../<?= $item['picture']?>" width="400" height="400" alt="Pet Picture">
                                <?php endif; ?>
                            </div>
                        </div>
                        
                       
                    </div>
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="custom-file form-group">
                                    <input type="file" onchange="readURL(this, 'blah');" value="<?= $item['picture']?>" class="custom-file-input" id="customFile" name="new_picture">
                                    <label class="custom-file-label" for="customFile">Choose File Photo</label>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label> Product Name: </label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                            </div>
                            
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mtop" >Price: </label>
                                    <input type="number" class="form-control" name="price"  required>
                                </div>
                            </div>
                            <div class="col-md-6"> 
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
                                        <option value="Medicine">Medicine</option>
                                        <option value="Vaccine">Vaccine</option>
                                        <option value="Dog Food">Dog Food</option>
                                        <option value="Cat food">Cat food</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="mtop"> Purchased Date: </label>
                                    <input type="date" class="form-control" name="bought_date" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="mtop"> Expiration Date: </label>
                                    <input type="date" class="form-control" name="exp_date" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-primary w-100 m-2" style="font-size: 18px; border-radius:5px;" type="submit" name="create_inventory"> Create </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

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

<!-- /.container-fluid -->

<!-- End of Main Content -->

