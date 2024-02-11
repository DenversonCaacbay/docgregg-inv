<?php
    ini_set('display_errors', 0);
    error_reporting(E_ALL ^ E_WARNING);
    require('../../classes/staff.class.php');
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
        <div class="col-md-10">
            <div class="d-flex align-items-center">
                <a class="btn btn-primary" href="../admin_reports_logs.php">Back</a>
                <h1 class="mb-0 ml-2">Reports - Stocks</h1>
            </div>
        </div>
        <div class="col-md-2 text-md-right">
            <nav aria-label="breadcrumb" class="custom-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="report_stock.php">Stocks</a></li>
                    <li class="breadcrumb-item"><a href="report_services.php">Services</a></li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-7">
                    <form id="pdfForm" method="post" action="../generatepdf/random/stocks.php" style="display: inline-block; margin-right: 10px;">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group" style="margin-bottom: 5px;">
                                    <label for="fromDate" style="display: block;">From Date:</label>
                                    <input type="date" class="form-control" id="fromDate" name="fromDate" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group" style="margin-bottom: 5px;">
                                    <label for="toDate" style="display: block;">To Date:</label>
                                    <input type="date" class="form-control" id="toDate" name="toDate" required>
                                </div>
                            </div>
                            <!-- <div class="col-md-1 mt-4"><button type="submit" class="btn btn-primary p-2 mt-3" id="generatePDF"><i class="fas fa-search"></i></button></div> -->
                            <div class="col-md-1 mt-4"><a  href="report_stock.php" class="btn btn-primary p-2 mt-3"><i class="fas fa-redo"></i></a></div>            
                            <div class="col-md-2 mt-4"><a href="#" class="btn btn-primary p-2" style="margin-top:15px" onclick="validateDates()" id="pdfLink"><i class="fas fa-print"></i></a></div>
                        </div>
                    </form> 
                </div>  
                <!-- <script>
                    document.getElementById('pdfLink').addEventListener('click', function (event) {
                        event.preventDefault();
                        document.getElementById('pdfForm').submit();
                    });
                </script>   -->
                <script>
                    function validateDates() {
                        var startDate = document.getElementById('fromDate').value;
                        var endDate = document.getElementById('toDate').value;

                        if (startDate === "" || endDate === "") {
                            alert("Please select both start and end dates.");
                        } else {
                            // Perform other actions or submit the form
                            var form = document.getElementById('pdfForm');
                            form.submit();

                            // Open PDF link in a new tab
                            openPdfLink();
                        }
                    }

                    // This function opens the PDF link in a new tab
                    function openPdfLink() {
                        var pdfLink = document.getElementById('pdfLink').getAttribute('href');
                        window.open(pdfLink, '_blank');
                    }
                </script>





                <div class="col-md-5 text-md-right" style="margin-top:30px;">
                    Generate Report by:  &nbsp
                    <!-- <button type="button" class="btn btn-primary">Day</button> -->
                    <a href="../generatepdf/stocks/day.php" class="btn btn-primary" target="_blank" id="generatePDF">Daily</a>
                    <a href="../generatepdf/stocks/week.php" class="btn btn-primary" target="_blank" id="generatePDF">Weekly</a>
                    <a href="../generatepdf/stocks/month.php" class="btn btn-primary" target="_blank" id="generatePDF">Monthly</a>
                    <a href="../generatepdf/stocks/year.php" class="btn btn-primary" target="_blank" id="generatePDF">Yearly</a>
                    <!-- <button type="button" class="btn btn-primary">Week</button>
                    <button type="button" class="btn btn-primary">Month</button> -->
                    <!-- <button type="button" class="btn btn-primary">Year</button> -->
                </div>
            </div>
            <div class="card" style="height: 500px; overflow: auto;">
            <table class="table table-hover text-center table-bordered">
                <form action="" method="post">
                    <thead style="background: #0296be;color:#fff;" class="sticky"> 
                        <tr>
                            <th> Customer Name </th>
                            <th> Product Name </th>
                            <th> Total Quantity</th>
                            <th> Total </th>
                            <th> Staff </th>
                            <th> Created at </th>
                        </tr>
                    </thead>

                    <tbody>
                    <tbody>
                        <?php if(is_array($view)) {?>
                            <?php foreach($view as $view) {?>
                                <tr>
                                    <td> <?= $view['customer_name']; ?></td>
                                    <td>
                                        <a href="#" class="product-link" data-toggle="modal" data-target="#productModal" data-product="<?= htmlspecialchars(json_encode($view), ENT_QUOTES, 'UTF-8'); ?>">
                                            <?= strlen($view['product']) > 30 ? substr($view['product'], 0, 30) . '...' : $view['product']; ?>
                                        </a>
                                    </td>
                                    <td> <?= $view['totalQty']; ?></td>
                                    <td>₱ <?= number_format($view['total']); ?> </td>
                                    <td> <?= $view['staff_name']; ?></td>
                                    <td> <?= $view['created_at']; ?> </td>
                                </tr>
                            <?php }?>
                        <?php } ?>
                    </tbody>

                </form>
            </table>
        </div>
        </div>
    </div>
    
    <!-- /.container-fluid -->
    <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Product Details</h5>
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> -->
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

