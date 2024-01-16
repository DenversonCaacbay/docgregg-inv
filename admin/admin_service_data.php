<?php
    error_reporting(E_ALL ^ E_WARNING);
    include('../classes/staff.class.php');
    // include('../classes/resident.class.php');

    $userdetails = $bmis->get_userdata();
    $bmis->validate_admin();
    $recent_user = $staffbmis->recent_user();
    // print_r($recent_user);

    // $rescountuser = $staffbmis->count_user();
    $rescountpet = $staffbmis->count_pet();
    $rescountsales = $staffbmis->count_total();
    $rescountvac = $staffbmis->count_vac();
    // $rescountm = $residentbmis->count_male_resident();
    // $rescountf = $residentbmis->count_female_resident();
    // $rescountfh = $residentbmis->count_head_resident();
    // $rescountfm = $residentbmis->count_member_resident();
    // $rescountvoter = $residentbmis->count_voters();
    // $rescountsenior = $residentbmis->count_resident_senior();

    $staffcount = $staffbmis->count_staff();
    // $staffcountm = $staffbmis->count_mstaff();
    // $staffcountf = $staffbmis->count_fstaff();
    
    $rescountuser = $staffbmis->count_services_consultation();
    $rescountuser1 = $staffbmis->count_services_vaccination();
    $rescountuser2 = $staffbmis->count_services_treatment();
    $rescountuser3 = $staffbmis->count_services_deworming();
    $rescountuser4 = $staffbmis->count_services_cesarian();
    $rescountuser5 = $staffbmis->count_services_grooming();
    $rescountuser6 = $staffbmis->count_services_surgery();
    $rescountuser7 = $staffbmis->count_services_bloodchem();
    $rescountuser8 = $staffbmis->count_services_heartworm();
    $rescountuser9 = $staffbmis->count_services_confinement();
    $rescountuser10 = $staffbmis->count_services_laboratory();
    $rescountuser11 = $staffbmis->count_services_diagnostic();



?>

<style> 
.card-upper-space {
    margin-top: 35px;
}

.card-row-gap {
    margin-top: 3em;
}

img{
    width: 50px;
}


</style>


<?php 
    include('dashboard_sidebar_start.php');
    
?>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->


    <div class="row"> 
        <div class="col-md-3">
            <h4>All Services</h4>
            <br>
            <div class="card border-left-primary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Consultation</div>
                                <div class="h5 mb-0 font-weight-bold text-dark"><?= $rescountuser?></div>
                                <br>
                                <!-- <a href="admn_table_totalres.php"> View Records </a> -->
                        </div>
                        <div class="col-auto">
                            <span style="color: #4e73df;"> 
                                <!-- <i class="fas fa-user-friends fa-2x text-dark "></i> -->
                                <img src="../assets/consulrtation.png">
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">  
            <br>
            <div class="card border-left-primary shadow card-upper-space">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Vaccination</div>
                                <div class="h5 mb-0 font-weight-bold text-dark"><?= $rescountuser1?></div>
                                <br>
                                <!-- <a href="admn_table_totalhouse.php"> View Records </a> -->
                        </div>
                        <div class="col-auto">
                            <!-- <i class="fas fa-syringe fa-2x text-dark"></i> -->
                            <img src="../assets/vaccination.png">
              
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">  
            <br>
            <div class="card border-left-primary shadow card-upper-space">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Deworming</div>
                                <div class="h5 mb-0 font-weight-bold text-dark"><?= $rescountuser3 ?></div>
                                <br>
                                <!-- <a href="admn_table_totalhouse.php"> View Records </a> -->
                        </div>
                        <div class="col-auto">
                        <img src="../assets/deworming.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">  
            <br>
            <div class="card border-left-primary shadow card-upper-space">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Heartworm</div>
                                <div class="h5 mb-0 font-weight-bold text-dark"><?= $rescountuser8 ?></div>
                                <br>
                                <!-- <a href="admn_table_totalhouse.php"> View Records </a> -->
                        </div>
                        <div class="col-auto">
                        <img src="../assets/heartworm.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">  
            <br>
            <div class="card border-left-primary shadow card-upper-space">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Treatment</div>
                                <div class="h5 mb-0 font-weight-bold text-dark"><?= $rescountuser2 ?></div>
                                <br>
                                <!-- <a href="admn_table_totalhouse.php"> View Records </a> -->
                        </div>
                        <div class="col-auto">
                            <!-- <i class="fas fa-first-aid fa-2x text-dark"></i> -->
                            <img src="../assets/treatment.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">  
            <br>
            <div class="card border-left-primary shadow card-upper-space">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Surgery</div>
                                <div class="h5 mb-0 font-weight-bold text-dark"><?= $rescountuser6 ?></div>
                                <br>
                                <!-- <a href="admn_table_totalhouse.php"> View Records </a> -->
                        </div>
                        <div class="col-auto">
                            <!-- <i class="fas fa-money-bill fa-2x text-dark"></i> -->
                            <img src="../assets/surgery.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">  
            <br>
            <div class="card border-left-primary shadow card-upper-space">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Laboratory</div>
                                <div class="h5 mb-0 font-weight-bold text-dark"><?= $rescountuser10 ?></div>
                                <br>
                                <!-- <a href="admn_table_totalhouse.php"> View Records </a> -->
                        </div>
                        <div class="col-auto">
                        <img src="../assets/laboratory.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">  
            <br>
            <div class="card border-left-primary shadow card-upper-space">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Confinement</div>
                                <div class="h5 mb-0 font-weight-bold text-dark"><?= $rescountuser9 ?></div>
                                <br>
                                <!-- <a href="admn_table_totalhouse.php"> View Records </a> -->
                        </div>
                        <div class="col-auto">
                        <img src="../assets/confinement.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">  
            <br>
            <div class="card border-left-primary shadow card-upper-space">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Diagnotics</div>
                                <div class="h5 mb-0 font-weight-bold text-dark"><?= $rescountuser11 ?></div>
                                <br>
                                <!-- <a href="admn_table_totalhouse.php"> View Records </a> -->
                        </div>
                        <div class="col-auto">
                        <img src="../assets/diagnostic.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">  
            <br>
            <div class="card border-left-primary shadow card-upper-space">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Grooming</div>
                                <div class="h5 mb-0 font-weight-bold text-dark"><?= $rescountuser5 ?></div>
                                <br>
                                <!-- <a href="admn_table_totalhouse.php"> View Records </a> -->
                        </div>
                        <div class="col-auto">
                        <img src="../assets/grooming.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">  
            <br>
            <div class="card border-left-primary shadow card-upper-space">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Cesarian Section Surgery</div>
                                <div class="h5 mb-0 font-weight-bold text-dark"><?= $rescountuser4 ?></div>
                                <br>
                                <!-- <a href="admn_table_totalhouse.php"> View Records </a> -->
                        </div>
                        <div class="col-auto">
                        <img src="../assets/surgery.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">  
            <br>
            <div class="card border-left-primary shadow card-upper-space">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Blood Chemistry Test</div>
                                <div class="h5 mb-0 font-weight-bold text-dark"><?= $rescountuser7 ?></div>
                                <br>
                                <!-- <a href="admn_table_totalhouse.php"> View Records </a> -->
                        </div>
                        <div class="col-auto">
                        <img src="../assets/blood-test.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
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