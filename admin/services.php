<?php
    ini_set('display_errors',0);
    error_reporting(E_ALL ^ E_WARNING);
    require('../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
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
                                <th> Availed Service </th>
                                <th> Date Availed </th>
                                <th> Actions </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if(is_array($view)) {?>
                                <?php foreach($view as $view) {?>
                                    <tr>

                                        <td data-fullname="<?= htmlspecialchars($view['customer_name']); ?>">
                                            <?= strlen($view['customer_name']) > 20 ? substr($view['customer_name'], 0, 20) . '...' : $view['customer_name']; ?>
                                        </td>
                                        <td data-service="<?= htmlspecialchars($view['service_availed']); ?>"> 
                                            <a href="#" class="product-link" data-toggle="modal" data-target="#productModal" data-product="<?= htmlspecialchars(json_encode($view), ENT_QUOTES, 'UTF-8'); ?>">
                                                <?= strlen($view['service_availed']) > 30 ? substr($view['service_availed'], 0, 30) . '...' : $view['service_availed']; ?>
                                            </a>
                                        </td>
                                        <td> <?= date("M d, Y", strtotime($view['created_at'])); ?> </td>
                                        <td>    
                                            <form action="" method="post">
                                                <!-- <a href="update_inventory_form.php?inv_id=<?= $view['inv_id'];?>" style="width: 70px;padding:5px; font-size: 15px; border-radius:5px; margin-bottom: 2px;" class="btn btn-success"> Update </a> -->
                                                <input type="hidden" name="serv_id" value="<?= $view['serv_id'];?>">
                                                <button class="btn btn-primary" type="submit" name="delete_services"style="width: 70px;padding:5px; font-size: 15px; border-radius:5px;"  onclick="return confirm('Are you sure you want to Archive this data?')"> Archive </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php }?>
                            <?php } ?>
                        </tbody>
                    </form>
                </table>
            </div>
        </div>
    </div>
</div>
    <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Details</h5>
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> -->
                </div>
                <div class="modal-body">
                    <div id="productDetails"></div>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div> -->
            </div>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    // Get the input field and table
    var input = document.getElementById('searchInput');
    var table = document.querySelector('.table');

    // Add an event listener to the input field
    input.addEventListener('input', function () {
        // Get the search query and convert it to lowercase
        var query = input.value.toLowerCase();

        // Get all table rows in the tbody
        var rows = table.querySelectorAll('tbody tr');

        // Loop through each row and hide/show based on the search query
        rows.forEach(function (row) {
            var customerNameCell = row.querySelector('td:nth-child(1)');
            var serviceCell = row.querySelector('td:nth-child(2)');
            var customer_name = customerNameCell.innerText.toLowerCase();
            var fullCustomerName = customerNameCell.getAttribute('data-fullname').toLowerCase();
            var fullService = serviceCell.getAttribute('data-service').toLowerCase();
            var service_availed = row.querySelector('td:nth-child(2)').innerText.toLowerCase();

            // Check if the query matches the shortened or full customer name, or service availed
            if (customer_name.includes(query) || fullCustomerName.includes(query) || service_availed.includes(query) || fullService.includes(query)) {
                row.style.display = ''; // Show the row
            } else {
                row.style.display = 'none'; // Hide the row
            }
        });
    });
});

</script>
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
