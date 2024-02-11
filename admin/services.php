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
    $view = $staffbmis->view_services_all($page, $recordsPerPage);
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
</style>

<!-- Begin Page Content -->

<div class="container-fluid">

    <!-- Page Heading -->

    
    
    <div class="row">
        <div class="col-md-6"><h1 class="">Services</h1></div>
        <div class="col-md-6"><a href="create_service.php" style="float:right;padding: 10px" class="btn btn-primary">Add Data</a></div>
    </div>

    <div class="row"> 
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label> Search </label>
                        <input type="text" class="form-control" id="searchInput" name="name"  value="" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <label> Services </label>
                    <select id="categorySelect" class="form-select" aria-label="Default select example">
                        <option>All</option>
                        <option value="consultation">Consultation</option>
                        <option value="vaccination">Vaccination</option>
                        <option value="deworming">Deworming</option>
                        <option value="heartworm">HeartWorm</option>
                        <option value="treatment">Treatment</option>
                        <option value="surgery">Surgery</option>
                        <option value="laboratory">Laboratory</option>
                        <option value="confinement">Confinement</option>
                        <option value="diagnostic">Diagnostic</option>
                        <option value="grooming">Grooming</option>
                        <option value="cesarian">Cesarian Section Surgery</option>
                        <option value="bloodchemtest">Blood Chemistry Test</option>
                    </select>
                </div>
            </div>
            
            <div class="card" style="height: 500px; overflow: auto;">
                <table class="table table-hover text-center table-bordered">
                    <form action="" method="post">
                        <thead style="background: #0296be;color:#fff;" class="sticky"> 
                            <tr>
                                <th> Customer Name </th>
                                <th> Contact </th>
                                <th> Address </th>
                                <th> Availed Service </th>
                                <th> Date Availed </th>
                                <th> Actions </th>
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
                                        <td> <?= $item['customer_address'] ?> </td>
                                        <td data-service="<?= htmlspecialchars($item['service_availed']); ?>">
                                            <a href="#" class="product-link" data-toggle="modal" data-target="#productModal" data-product="<?= htmlspecialchars(json_encode($item), ENT_QUOTES, 'UTF-8'); ?>">
                                                <?= strlen($item['service_availed']) > 30 ? substr($item['service_availed'], 0, 30) . '...' : $item['service_availed']; ?>
                                            </a>
                                            
                                        </td>
                                        <td hidden><?= $item['treatment_name']; ?></td>
                                        <td> <?= date("F d, Y", strtotime($item['created_at'])); ?> </td>
                                        <td>
                                            <form action="" method="post">
                                                <input type="hidden" name="serv_id" value="<?= $item['serv_id']; ?>">
                                                <input type="hidden" name="customer_name" value="<?= $item['customer_name']; ?>">
                                                <input type="hidden" name="service_availed" value="<?= $item['service_availed']; ?>">
                                                <input type="hidden" name="staff_name" value="<?= $item['staff_name']; ?>">
                                                <button class="btn btn-primary" type="submit" name="delete_services" style="width: 70px;padding:5px; font-size: 15px; border-radius:5px;" onclick="return confirm('Are you sure you want to Archive this data?')"> Remove </button>
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
