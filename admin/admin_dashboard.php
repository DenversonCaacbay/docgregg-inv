<?php
    error_reporting(E_ALL ^ E_WARNING);
    include('../classes/staff.class.php');
    // include('../classes/resident.class.php');

    $userdetails = $bmis->get_userdata();
    $user = $staffbmis->view_single_staff($userdetails['id_admin']);
    $bmis->validate_admin();
    $recent_user = $staffbmis->recent_user();
    // print_r($recent_user);

    $internal = $staffbmis->view_low_inventory_external();
    $external = $staffbmis->view_low_stock_internal();
    $most_sold = $staffbmis->view_stock_most_sold();

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

    // For Low Inventory
    $recordsPerPage = 3; // set the number of records to display per page
    // $view = $staffbmis->view_low_inventory($page, $recordsPerPage);
    $totalRecords = $staffbmis->count_low_inventory(); // get the total number of records



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

.card-img-top{
    width: 50px;
}
.container-fluid {
    height: 650px;
    overflow: auto; /* This enables scrolling */
}

/* Hide scrollbar for WebKit (Safari and Chrome) */
.container-fluid::-webkit-scrollbar {
    display: none;
}
</style>


<?php 
    include('dashboard_sidebar_start.php');
?>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Begin Page Content -->
<!-- <div class="container-fluid" style="height: 650px;overflow: auto;"> -->
<div class="container-fluid page-container">

<!-- Page Heading -->


    <div class="row"> 
        <div class="col-md-12 d-flex justify-content-between align-items-center">
            <h4>Dashboard</h4>
            <!-- <a class="btn btn-primary mb-3" style="float:right" href="admin_service_data.php">See More</a> -->
        </div>
        <!-- <div id="serviceCardsContainer"></div> -->
    </div>
    <div class="card shadow py-3 px-3">
    <div class="row">
        <div class="col-md-6">
            <div class="d-flex justify-content-between align-items-center">
                <h5>Low Stock Internal</h5>
                <a class="btn btn-primary mb-3" href="admin_low_inventory.php">See More</a>
            </div>
            <table class="table table-reponsive">
                <th> Product Name </th>
                <th> Quantity </th>
                <th> Category </th>
                <!-- <th></th> -->
                <?php if(is_array($internal)) {?>
                    <?php foreach($internal as $view) {?>
                        <tr>
                            <td> <?= strlen($view['name']) > 20 ? substr($view['name'], 0, 20) . '...' : $view['name']; ?> </td>
                            <td> <?= $view['quantity'];?> </td>
                            <td> <?= $view['category'] ? $view['category'] : 'N/A' ;?> </td>
                            <!-- <td class="text-center"><span class="badge bg-danger">Low Stocks</span></td> -->
                        </tr>
                    <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="3">No Data Found</td>
                        </tr>
                    <?php } ?>
            </table> 
        </div>
        <div class="col-md-6">
            <div class="d-flex justify-content-between">
                <h5>Low Stock External</h5>
                <a class="btn btn-primary mb-3" href="admin_low_inventory.php">See More</a>
            </div>
            <table class="table table-reponsive">
                <tr>
                    <th> Product Name </th>
                    <th> Quantity </th>
                    <th> Category </th>
                    <!-- <th></th> -->
                </tr>
                <tr>
                    <?php if (is_array($external) && count($external) > 0) { ?>
                        <?php foreach ($external as $item) { ?>
                    <tr>
                        <td><?= $item['name'] ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= $item['category'] ?></td>
                        <!-- <td></td> -->
                    </tr>
                    <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="3">No Data Found</td>
                        </tr>
                    <?php } ?>
                </tr>
            </table>
        </div>
        <div class="col-md-12">
            <div class="d-flex justify-content-between">
                <h5>Top 3 Most Sold Product</h5>
            </div>
            <table class="table table-reponsive">
                <tr>
                    <th> Product Name </th>
                    <th> Total </th>
                    <!-- <th></th> -->
                </tr>
                <?php if (is_array($most_sold) && count($most_sold) > 0) { ?>
                    <?php foreach ($most_sold as $item) { ?>
                <tr>
                    <td><?= $item['product'] ?></td>
                    <td>₱<?= number_format($item['total'], 2, '.', ',') ?></td>
                    <!-- <td></td> -->
                </tr>
                <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="2">No Data Found</td>
                    </tr>
                <?php } ?>
            </table>   
        </div>
    </div>
    </div>

    <div class="row mt-3">
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
                <canvas style="height:95%" id="myBarChart"></canvas>
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
            <h3 class="mt-3">Availed Service</h3>
            <div class="col-md-12">
                
                <canvas  id="barChart" width="400" height="400"></canvas>

                <script>
                    // Fetch data from PHP file using Fetch API
                    document.addEventListener('DOMContentLoaded', function () {
                        // Fetch data from PHP file using Fetch API
                        fetch('pos/fetch_pie.php')
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                console.log(data); // Check the data in the console

                                // Process the data to extract service names and counts
                                var labels = data.map(item => item.service_name);
                                var values = data.map(item => item.count);

                                // Create a bar chart
                                var ctx = document.getElementById('barChart').getContext('2d');
                                var myBarChart = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            label: 'Availed Per Services',
                                            data: values,
                                            backgroundColor: 'rgba(54, 162, 235, 0.7)', // Blue
                                            borderColor: 'rgba(54, 162, 235, 1)',
                                            borderWidth: 1
                                        }]
                                    },
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
                            })
                            .catch(error => console.error('Error fetching data:', error));
                    });
                </script>
            </div>

        </div>
       
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->