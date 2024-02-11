<?php
    
    ini_set('display_errors',0);
    error_reporting(E_ALL ^ E_WARNING);
    require('../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $user = $staffbmis->view_single_staff($userdetails['id_admin']);
    $bmis->validate_admin();
    $view = $staffbmis->view_user();
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
    }
</style>

<!-- Begin Page Content -->

<div class="container-fluid">

    <!-- Page Heading -->

    <div class="row"> 
        <div class=""> 
            <h1 class="text-gray"> Help & Support</h1>
        </div>
    </div>

    <div class="container-fluid mt-3">
        <div class="accordion accordion-flush" id="accordionFlushExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                    Service Tab
                </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                    <code>1.</code> You can view the availed services of the clients<br>
                    <code>2.</code> You can add data by the clicking Add Data which will be done upon clients availing the service<br>
                    <code>3.</code> Clients need to provide there basic informations <br>
                    <code>4.</code> You can select what type of service the clients want to avail<br>
                    <code><i>Note: </i></code> If Treatment is selected you have to select what type of Treatment<br>
                </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                   Inventory Tab
                </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                    <code>1.</code> You can see all the product added in your Inventory<br>
                    <code>2.</code> You can add Product via Add Item button, and fill up the product information needed<br>
                    <code>3.</code> You can Update the product information through the Inventory tab in the right column there is an Update Button where you can update the information<br>
                    <code>4.</code> You can also delete the product if needed.<br>
                    <code><i>Note: </i></code> If product is Low kindly check the notification in the Upper Right corner you can see all the low on stocks product there<br>
                </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                    Sales Inventory Tab
                </button>
                </h2>
                <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                    <code>1.</code> In this tab admin needs client to buy first in the shop and enter the items bought by the clients<br>
                    <code>2.</code> You can add to cart the items and it will be displayed in the Order Details Section.<br>
                    <code>3.</code> You need to verify first if the cash is exact amount or not to be able to proceed in the payment<br>
                    <code>4.</code> After you are done in the payment. the quantity of the item will also be decrease in the inventory section<br>
                </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                   Logs & Reports Tab
                </button>
                </h2>
                <div id="flush-collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                    <code>1.</code> There are 2 sections which is Stocks and Services<br>
                    <code>Reports</code><br>
                    <code>1.</code> In the stocks you can see all the bought products of the client.<br>
                    <code>2.</code>  There are 4 button in the upper right corner which is Daily, Weekly, Monthly, Yearly, You can generate report by clicking what report you needed<br>
                    <code>3.</code> In the Services you can see all the availed services and who make the list.<br>
                    <code>4.</code>  There are 4 button in the upper right corner which is Daily, Weekly, Monthly, Yearly, You can generate report by clicking what report you needed<br>
                    <code>Logs</code><br>
                    <code>1.</code> There are 3 sections which is Staff, Services and Inventory<br>
                    <code>2.</code> You can view all the logs in each sections.

                </div>
            </div>
        </div>
    </div>
    
    <!-- /.container-fluid -->
    
</div>
<!-- End of Main Content -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modalmanager.min.js" integrity="sha512-/HL24m2nmyI2+ccX+dSHphAHqLw60Oj5sK8jf59VWtFWZi9vx7jzoxbZmcBeeTeCUc7z1mTs3LfyXGuBU32t+w==" crossorigin="anonymous"></script>
<!-- responsive tags for screen compatibility -->
<meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
<!-- custom css --> 
<link href="../BarangaySystem/customcss/regiformstyle.css" rel="stylesheet" type="text/css">
<!-- bootstrap css --> 
<link href="../BarangaySystem/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"> 
<!-- fontawesome icons -->
<script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>
<script src="../BarangaySystem/bootstrap/js/bootstrap.bundle.js" type="text/javascript"> </script>

