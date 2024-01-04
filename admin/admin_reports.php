<?php
    
    ini_set('display_errors',0);
    error_reporting(E_ALL ^ E_WARNING);
    require('../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $bmis->validate_admin();
    $view = $staffbmis->view_invoice();
    $staffcount = $staffbmis->count_invoice();
    // $bmis->validate_admin();

   
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
            <h1 class="text-gray">Reports - Stocks</h1>
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
                <div class="col-md-12 text-md-right">
                    Generate Report by:  &nbsp
                    <!-- <button type="button" class="btn btn-primary">Day</button> -->
                    <a href="generatepdf/stocks/day.php" class="btn btn-primary" target="_blank" id="generatePDF">Daily</a>
                    <a href="generatepdf/stocks/week.php" class="btn btn-primary" target="_blank" id="generatePDF">Weekly</a>
                    <a href="generatepdf/stocks/month.php" class="btn btn-primary" target="_blank" id="generatePDF">Monthly</a>
                    <a href="generatepdf/stocks/year.php" class="btn btn-primary" target="_blank" id="generatePDF">Yearly</a>
                    <!-- <button type="button" class="btn btn-primary">Week</button>
                    <button type="button" class="btn btn-primary">Month</button> -->
                    <!-- <button type="button" class="btn btn-primary">Year</button> -->
                </div>
            </div>
            <table class="table table-hover text-center table-bordered mt-3">
                <form action="" method="post">
                    <thead style="background: #0296be;color:#fff;"> 
                        <tr>
                            <th> Product Name </th>
                            <th> Total Quantity</th>
                            <th> Total </th>
                            <th> Created at </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if(is_array($view)) {?>
                            <?php foreach($view as $view) {?>
                                <tr>
                                    <td> <?= $view['product'];?></td>
                                    <td> <?= $view['totalQty'];?></td>
                                    <td> <?= $view['total'];?></td>
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

