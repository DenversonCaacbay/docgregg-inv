<?php
    
    ini_set('display_errors',0);
    error_reporting(E_ALL ^ E_WARNING);
    require('../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $bmis->validate_admin();
    $view = $staffbmis->count_vaccine_report();
    // $bmis->validate_admin();
    // $bmis->delete_bspermit();
    // $view = $bmis->view_bspermit();
    $id_resident = $_GET['id_resident'];
    // $resident = $residentbmis->get_single_bspermit($id_resident);
   
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
            <h1 class="text-gray">Reports - Vaccination</h1>
        </div>
        <div class="col-md-3 text-md-right">
            <nav aria-label="breadcrumb" class="custom-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="admin_reports.php">Stocks</a></li>
                    <li class="breadcrumb-item"><a href="admin_reports_clients.php">Clients</a></li>
                    <li class="breadcrumb-item"><a href="admin_reports_vaccination.php">Vaccinations</a></li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
            <div class="col-md-7">
                    <form id="pdfForm" method="post" action="generatepdf/random/vaccination.php" style="display: inline-block; margin-right: 10px;">
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
                            <div class="col-md-1 mt-4"><a  href="admin_reports.php" class="btn btn-primary p-2 mt-3"><i class="fas fa-redo"></i></a></div>            
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

                <div class="col-md-5 text-md-right mt-4">
                    Generate Report by:  &nbsp
                    <!-- <button type="button" class="btn btn-primary">Day</button> -->
                    <a href="generatepdf/vaccination/day.php" class="btn btn-primary" target="_blank" id="generatePDF">Daily</a>
                    <a href="generatepdf/vaccination/week.php" class="btn btn-primary" target="_blank" id="generatePDF">Weekly</a>
                    <a href="generatepdf/vaccination/month.php" class="btn btn-primary" target="_blank" id="generatePDF">Monthly</a>
                    <a href="generatepdf/vaccination/year.php" class="btn btn-primary" target="_blank" id="generatePDF">Yearly</a>
                    <!-- <button type="button" class="btn btn-primary">Week</button>
                    <button type="button" class="btn btn-primary">Month</button> -->
                    <!-- <button type="button" class="btn btn-primary">Year</button> -->
                </div>
            </div>
            <table class="table table-hover text-center table-bordered mt-3">
                <form action="" method="post">
                    <thead style="background: #0296be;color:#fff;"> 
                        <tr>
                            <th> Pet Name </th>
                            <th> Pet Condition </th>
                            <th> Vaccine Taken </th>
                            <th> Date Vaccinated </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if(is_array($view)) {?>
                            <?php foreach($view as $view) {?>
                                <tr>
                                <td> <?= $view['pet_name'];?> </td>
                                <td> <?= $view['vac_condition'];?> </td>
                                <td> <?= $view['vac_used'];?> </td>
                                    <td> <?= $view['created_at'];?> </td>
                                </tr>
                            <?php }?>
                        <?php } ?>
                    </tbody>
                </form>
            </table>
        </div>
    </div>
    
    <!-- /.container-fluid -->
    
</div>
<!-- End of Main Content -->

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
        function displayProductDetails(product) {
            // You can customize this function based on how you want to display product details
            var detailsHtml = "<p><strong>Product:</strong> " + product.product + "</p>";
            detailsHtml += "<p><strong>Total Quantity:</strong> " + product.totalQty + "</p>";
            detailsHtml += "<p><strong>Total:</strong> ₱" + product.total + ".00</p>";
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
