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

<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->


    <div class="row"> 
        <div class="col-md-4">
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

        <div class="col-md-4">  
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

        <div class="col-md-4">  
            <br>
            <div class="card border-left-primary shadow card-upper-space">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pet Vaccinated</div>
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
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex align-items-center">
                <label for="timePeriod" class="me-2 mt-2">Select Time Period:</label>
                <select class="form-select" style="width:100px;" id="timePeriod" onchange="updateChart()">
                    <option value="week">Week</option>
                    <option value="month">Month</option>
                    <option value="year">Year</option>
                </select>
            </div>


    <!-- Display the chart -->
            <canvas id="salesChart" width="800" height="200"></canvas>

    <!-- Your script to fetch and update data -->
    <script>
        // Initial time period selection
        let selectedTimePeriod = 'week';

        // Function to update the chart based on the selected time period
        function updateChart() {
            selectedTimePeriod = document.getElementById('timePeriod').value;
            updateChartData();
        }

        // Function to update the chart data
        function updateChartData() {
            // Fetch data from the server using AJAX
            fetch('pos/fetch_data.php?timePeriod=' + selectedTimePeriod)
                .then(response => response.json())
                .then(data => {
                    const ctx = document.getElementById('salesChart').getContext('2d');

                    const chart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data.dates,
                            datasets: [{
                                label: 'Total Sales',
                                data: data.total,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        // Initial chart rendering
        updateChartData();
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