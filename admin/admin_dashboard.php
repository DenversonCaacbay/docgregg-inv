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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->


    <div class="row"> 
        <div class="col-md-3">
            <h4>Dashboard</h4>
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
                                <i class="fas fa-user-friends fa-2x text-dark "></i>
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
                                <div class="h5 mb-0 font-weight-bold text-dark"><?= $rescountpet?></div>
                                <br>
                                <!-- <a href="admn_table_totalhouse.php"> View Records </a> -->
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-syringe fa-2x text-dark"></i>
              
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
                                <div class="h5 mb-0 font-weight-bold text-dark"><?= $rescountvac ?></div>
                                <br>
                                <!-- <a href="admn_table_totalhouse.php"> View Records </a> -->
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill fa-2x text-dark"></i>
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
                                <div class="h5 mb-0 font-weight-bold text-dark"><?= $rescountvac ?></div>
                                <br>
                                <!-- <a href="admn_table_totalhouse.php"> View Records </a> -->
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill fa-2x text-dark"></i>
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
                                <div class="h5 mb-0 font-weight-bold text-dark"><?= $rescountvac ?></div>
                                <br>
                                <!-- <a href="admn_table_totalhouse.php"> View Records </a> -->
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill fa-2x text-dark"></i>
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
                                <div class="h5 mb-0 font-weight-bold text-dark"><?= $rescountvac ?></div>
                                <br>
                                <!-- <a href="admn_table_totalhouse.php"> View Records </a> -->
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill fa-2x text-dark"></i>
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
                                <div class="h5 mb-0 font-weight-bold text-dark"><?= $rescountvac ?></div>
                                <br>
                                <!-- <a href="admn_table_totalhouse.php"> View Records </a> -->
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill fa-2x text-dark"></i>
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
                                <div class="h5 mb-0 font-weight-bold text-dark"><?= $rescountvac ?></div>
                                <br>
                                <!-- <a href="admn_table_totalhouse.php"> View Records </a> -->
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill fa-2x text-dark"></i>
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
                                <div class="h5 mb-0 font-weight-bold text-dark"><?= $rescountvac ?></div>
                                <br>
                                <!-- <a href="admn_table_totalhouse.php"> View Records </a> -->
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill fa-2x text-dark"></i>
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
                                <div class="h5 mb-0 font-weight-bold text-dark"><?= $rescountvac ?></div>
                                <br>
                                <!-- <a href="admn_table_totalhouse.php"> View Records </a> -->
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill fa-2x text-dark"></i>
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
                                <div class="h5 mb-0 font-weight-bold text-dark"><?= $rescountvac ?></div>
                                <br>
                                <!-- <a href="admn_table_totalhouse.php"> View Records </a> -->
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill fa-2x text-dark"></i>
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
                                <div class="h5 mb-0 font-weight-bold text-dark"><?= $rescountvac ?></div>
                                <br>
                                <!-- <a href="admn_table_totalhouse.php"> View Records </a> -->
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill fa-2x text-dark"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex align-items-center">
                <label for="timePeriod" class="me-2 mt-2">Select Time Period:</label>
                <select id="timePeriod" style="width:120px;" class="form-select" onchange="updateChart()">
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                    <option value="yearly">Yearly</option>
                </select>
            </div>

            <div>
                <canvas style="height:100%" id="myBarChart"></canvas>
            </div>

                <script>
                    var myBarChart; // Declare the chart variable outside the functions

                    function updateChart() {
                        var selectedTimePeriod = document.getElementById('timePeriod').value;
                        fetch('pos/fetch_data.php?timePeriod=' + selectedTimePeriod)
                            .then(response => response.json())
                            .then(data => updateChartWithData(data));
                    }

                    function updateChartWithData(data) {
                        var ctx = document.getElementById('myBarChart').getContext('2d');

                        // Check if the chart instance already exists
                        if (myBarChart) {
                            myBarChart.destroy(); // Destroy the existing chart
                        }

                        // Create a new chart instance with the updated data
                        myBarChart = new Chart(ctx, {
                            type: 'bar',
                            data: data,
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    }

                    // Initial chart update on page load
                    updateChart();
                </script>
            </div>
        </div>

        <div class="row mt-5"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6"><h4 class="mb-4">New Added Pets</h4></div>
                    <div class="col-md-6"><a href="admin_pets.php" style="float:right;padding: 10px" class="btn btn-primary">View All Pets</a></div>
            </div>
            <br>
            <table class="table">
                <th>Full Name</th>
                <th>Pet Name</th>
                <th>Date</th>
                <th></th>

                <?php if(is_array($recent_user)) {?>
                    <?php foreach($recent_user as $view) {?>
                    <tr>
                        <td><?= $view['fname'];?> <?= $view['lname'];?></td>
                        <td><?= $view['pet_name'];?></td>
                        <td> <?= date("F d, Y - l", strtotime($view['created_at'])); ?> </td>
                        <td><span class="badge bg-danger">New</span></td>
                        <!-- <td>Dog Hat</td>
                        <td>Ruby</td>
                        <td>January 01, 2024</td> -->
                    </tr>
                    <?php }?>
                <?php } ?>
            </table>    
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