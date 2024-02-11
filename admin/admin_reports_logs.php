<?php
    ini_set('display_errors', 0);
    error_reporting(E_ALL ^ E_WARNING);
    require('../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $user = $staffbmis->view_single_staff($userdetails['id_admin']);
    $bmis->validate_admin();
    $view = $staffbmis->view_invoice();
    $staffcount = $staffbmis->count_invoice();

    
    if ($userdetails['role'] !== 'administrator') {
        // User is not an admin, display an alert
        echo '<script>alert("You are not authorized to access this page as admin.");</script>';
        // Redirect or take appropriate action if needed
        header('Location: admin_dashboard.php');
        exit();
    }

    // Continue with the rest of your code for admin
?>

<?php 
    include('dashboard_sidebar_start.php');
?>


<style>
    .input-icons i {
        position: absolute;
    }
        
    .input-icons {
        width: 30%;
        margin-bottom: 10px;
        margin-left: 34%;
    }
        
    .icon {
        padding: 10px;
        min-width: 40px;
    }
    .form-control{
        text-align: center;
        padding: 20px;
    }
    .custom-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
        padding-left:10px;
        content: "|";
        padding: 0 5px;
        color: #6c757d; /* Set the color of the divider */
  }
</style>

<!-- Begin Page Content -->

<div class="container-fluid">

    <!-- Page Heading -->

    <div class="row">
        <div class="col-md-9">
            <h1 class="text-gray">Reports & Logs</h1>
        </div>
        <div class="col-md-3 text-md-right">
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-6">
            <div class="card text-center p-5">
                <i class="fas fa-file-alt fa-5x" style="color: #0296be !important;font-size: 50px !important;"></i>
                <h4 class="mt-3">Reports</h4>
                <a class="btn btn-primary" href="reports/report_stock.php">Visit</a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-center p-5">
                <i class="fas fa-cogs fa-5x" style="color: #0296be !important;font-size: 50px !important;"></i>
                <h4 class="mt-3">Logs</h4>
                <a class="btn btn-primary" href="logs/logs_staff.php">Visit</a>
            </div>
        </div>
    </div>
    
    <!-- /.container-fluid -->
</div>
<!-- Bootstrap Modal -->



<!-- Bootstrap Modal -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.7.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.7.2/dist/js/bootstrap.bundle.min.js"></script> -->

<script>
    $(document).ready(function() {
        // Handle click on product link
        $(".product-link").click(function(e) {
            e.preventDefault();
            var productDetails = $(this).data("product");
            displayProductDetails(productDetails);
        });

        // Function to display product details in the modal

    // You can customize this function based on how you want to display product details
        function displayProductDetails(product) {
    // You can customize this function based on how you want to display product details
            var totalNumber = parseFloat(product.total); // Convert to number if it's not already
            var formattedTotal = totalNumber.toLocaleString(); // Format the total with commas
            var detailsHtml = "<p><strong>Product:</strong> " + product.product + "</p>";
            detailsHtml += "<p><strong>Total Quantity:</strong> " + product.totalQty + "</p>";
            detailsHtml += "<p><strong>Total:</strong> ₱" + formattedTotal + ".00</p>";
            detailsHtml += "<p><strong>Created At:</strong> " + product.created_at + "</p>";
        
            // Update the content of the modal with the product details
            $("#productDetails").html(detailsHtml);
        
            // Show the modal using JavaScript
            $("#productModal").modal("show");
        }


        // Handle form submission to filter results
        $("form").submit(function(e) {
            e.preventDefault();
            var fromDate = new Date($("#fromDate").val());
            var toDate = new Date($("#toDate").val());

            // Iterate through each row and hide/show based on the date range
            $("tbody tr").each(function() {
                var rowDate = new Date($(this).find("td:last-child").text());
                if (rowDate >= fromDate && rowDate <= toDate) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
</script>
<!-- 
<script>
    $(document).ready(function() {
        // Handle click on product link
        $(".product-link").click(function(e) {
            e.preventDefault();
            var productDetails = $(this).data("product");
            displayProductDetails(productDetails);
        });
    });

    // Function to display product details in the modal
    function displayProductDetails(product) {
        // You can customize this function based on how you want to display product details
        var detailsHtml = "<p><strong>Product:</strong> " + product.product + "</p>";
        detailsHtml += "<p><strong>Total Quantity:</strong> " + product.totalQty + "</p>";
        detailsHtml += "<p><strong>Total: ₱ </strong> " + product.total + ".00</p>";
        detailsHtml += "<p><strong>Created At:</strong> " + product.created_at + "</p>";

        // Update the content of the modal with the product details
        $("#productDetails").html(detailsHtml);

        // Show the modal
        $('#productModal').modal('show');
    }
</script> -->
<!-- End of Main Content -->

