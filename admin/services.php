<?php
    ini_set('display_errors',0);
    error_reporting(E_ALL ^ E_WARNING);
    require('../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $user = $staffbmis->view_single_staff($userdetails['id_admin']);
    $bmis->validate_admin();
    
    $staffbmis->delete_services();

    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $recordsPerPage = 5; // set the number of records to display per page
    // $view = $staffbmis->view_services_all($page, $recordsPerPage);
    $view = $staffbmis->view_customers($page, $recordsPerPage);
    // $totalRecords = $staffbmis->count_inventory(); // get the total number of records

// Calculate the total number of pages
    $totalPages = ceil($totalRecords / $recordsPerPage);


?>

<?php 
    include('dashboard_sidebar_start.php');
?>

<style>
    thead.sticky {
        position: sticky;
        top: 0;
        z-index: 100;
    }
    th,td{
        /* justify-content: center; */
        align-content: center;
    }
</style>

<!-- Begin Page Content -->

<div class="container-fluid page-container">

    <!-- Page Heading -->

    
    
    <div class="row">
        <div class="col-md-12 d-flex justify-content-between align-items-center">
            <h4 class="">List of Customers</h4>
            <a href="create_customer.php" class="btn btn-primary">Add Customer</a>
        </div>
    </div>

    <div class="row"> 
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label> Search :</label>
                        <input type="text" class="form-control" id="searchInput" name="name"  value="" required>
                    </div>
                </div>
            </div>
            
            <div class="card customer--card">
                <table class="table table-hover text-center table-bordered">
                    <form action="" method="post">
                        <thead style="background: #0296be;color:#fff;" class="sticky"> 
                            <tr>
                                <th> Customer Name </th>
                                <th> Contact </th>
                                <th> Email </th>
                                <th> Address </th>
                                <th> View </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (is_array($view) && count($view) > 0) { ?>
                                <?php foreach ($view as $item) { ?>
                                    <tr>
                                        <td data-fullname="<?= htmlspecialchars($item['customer_name']); ?>">
                                            <?= strlen($item['customer_name']) > 20 ? substr($item['customer_name'], 0, 20) . '...' : $item['customer_name']; ?>
                                        </td>
                                        <td> <?= $item['customer_contact'] ?> </td>
                                        <td> <?= $item['customer_email'] ?> </td>
                                        <td> <?= $item['customer_address'] ?> </td>
                                        <td>
                                            <form action="" method="post">
                                                <input type="hidden" name="serv_id" value="<?= $item['customer_id']; ?>">
                                                <input type="hidden" name="customer_name" value="<?= $item['customer_name']; ?>">
                                                
                                                <input type="hidden" name="staff_name" value="<?= $item['staff_name']; ?>">
                                                <a href="view_customer.php?id=<?= $item['id_user'] ?>" class="btn btn-primary" style="width: 70px;padding:5px; font-size: 15px; border-radius:5px;">View</a>
                                                <!-- <button class="btn btn-primary" type="submit" name="delete_services" style="width: 70px;padding:5px; font-size: 15px; border-radius:5px;"> View </button> -->
                                                <!-- <button class="btn btn-danger" type="submit" name="delete_services" style="width: 70px;padding:5px; font-size: 15px; border-radius:5px;" onclick="return confirm('Are you sure you want to Archive this data?')"> Remove </button> -->
                                            </form>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="4">No Data Found</td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </form>
                </table>
                <div id="noDataFound" style="display: none;text-align:center">
                    <p>No Data Found</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="productModal" tabindex="-1"  aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Details</h5>
            </div>
            <div class="modal-body">
                <div id="productDetails"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> -->
<script>
    $(document).ready(function () {
        $('#categorySelect').on('change', function () {
            var selectedValue = $(this).val();
            if (selectedValue !== 'all') {
                window.location.href = 'services/services-' + selectedValue + '.php';
            }
        });
    });
</script> 


<script>
    $(document).ready(function() {
        // Handle click on product link
        $(".product-link").click(function(e) {
            e.preventDefault();
            var productDetails = $(this).data("product");
            displayProductDetails(productDetails);
        });

        // Function to display product details in the modal
        function displayProductDetails(product) {
            // You can customize this function based on how you want to display product details
            var detailsHtml = "<p><strong>Customer Name:</strong> " + product.customer_name + "</p>";
            detailsHtml += "<p><strong>Services Availed:</strong> " + product.service_availed + "</p>";
            

            // Check if there is treatment information
            if (product.treatment_name) {
                detailsHtml += "<p>" + product.treatment_name + "</p>";
            } else {
                detailsHtml += "<p>No Treatment Information</p>";
            }
            detailsHtml += "<p><strong>Staff:</strong>" + product.staff_name + "</p>";
            detailsHtml += "<p><strong>Created At:</strong> " + product.created_at + "</p>";

            // Update the content of the modal with the product details
            $("#productDetails").html(detailsHtml);

            // Show the modal using JavaScript
            $("#productModal").modal("show");
        }

        // Handle form submission to filter results
    });
</script>



<!-- End of Main Content -->
