<?php
    error_reporting(E_ALL ^ E_WARNING);
    include('../classes/staff.class.php');
    // include('../classes/resident.class.php');

    $userdetails = $bmis->get_userdata();
    $bmis->validate_admin();
    $recent_user = $staffbmis->recent_user();
    // print_r($recent_user);

    $rescountuser = $staffbmis->count_user();
    $rescountpet = $staffbmis->count_pet();
    // $rescountm = $residentbmis->count_male_resident();
    // $rescountf = $residentbmis->count_female_resident();
    // $rescountfh = $residentbmis->count_head_resident();
    // $rescountfm = $residentbmis->count_member_resident();
    // $rescountvoter = $residentbmis->count_voters();
    // $rescountsenior = $residentbmis->count_resident_senior();

    $staffcount = $staffbmis->count_staff();
    // $staffcountm = $staffbmis->count_mstaff();
    // $staffcountf = $staffbmis->count_fstaff();
    



?>

<style> 
.card-upper-space {
    margin-top: 35px;
}

.card-row-gap {
    margin-top: 3em;
}
</style>


<?php 
    include('dashboard_sidebar_start.php');
?>

<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->


    <div class="row"> 
        <div class="col-md-6">
            <h4>Dashboard</h4>
            <br>
            <div class="card border-left-primary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Clients</div>
                                <div class="h5 mb-0 font-weight-bold text-dark"><?= $rescountuser?></div>
                                <br>
                                <!-- <a href="admn_table_totalres.php"> View Records </a> -->
                        </div>
                        <div class="col-auto">
                            <span style="color: #4e73df;"> 
                                <i class="fas fa-user-friends fa-2x text-dark "></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">  
            <br>
            <div class="card border-left-primary shadow card-upper-space">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pets</div>
                                <div class="h5 mb-0 font-weight-bold text-dark"><?= $rescountpet?></div>
                                <br>
                                <!-- <a href="admn_table_totalhouse.php"> View Records </a> -->
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-paw fa-2x text-dark"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- <div class="col-md-4"> 
            <br>
            <div class="card border-left-primary shadow card-upper-space">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Staff</div>
                                <div class="h5 mb-0 font-weight-bold text-dark"><?= $staffcount?></div>
                                <br>
                               
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-layer-group fa-2x text-dark"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>  -->
    </div>


    <br>
    <br>

    <div class="row"> 
    <div class="col-md-12">
        <h4> Recent Patient </h4> 
        <br>
        <table class="table">
            <th>Full Name</th>
            <th>Pet Name</th>
            <th>Date</th>

            <?php if(is_array($recent_user)) {?>
                <?php foreach($recent_user as $view) {?>
                <tr>
                    <td><?= $view['fname'];?> <?= $view['lname'];?></td>
                    <td><?= $view['pet_name'];?></td>
                    <td> <?= date("F d, Y - l", strtotime($view['created_at'])); ?> </td>
                    <!-- <td>Dog Hat</td>
                    <td>Ruby</td>
                    <td>January 01, 2024</td> -->
                </tr>
                <?php }?>
            <?php } ?>
        </table>
        
    </div>


<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<br>
<br>

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
                
<?php 
    include('dashboard_sidebar_end.php');
?>