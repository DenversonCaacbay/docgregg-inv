<?php
    error_reporting(E_ALL ^ E_WARNING);
    include('../classes/staff.class.php');
    // include('../classes/resident.class.php');

    $userdetails = $bmis->get_userdata();
    $user = $staffbmis->view_single_staff($userdetails['id_admin']);
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
<div class="container-fluid" style="height: 650px;overflow: auto;">

<!-- Page Heading -->


    <div class="row"> 
        <div class="col-md-6"><h3>Dashboard</h3></div>
        <div class="col-md-6"><a class="btn btn-primary mb-3" style="float:right" href="admin_service_data.php">See More</a></div>
        <div id="serviceCardsContainer"></div>
    </div>
    

    <script>
    // Function to create cards based on the data
    const createCards = (data) => {
        const container = document.getElementById('serviceCardsContainer');

        // Service images mapping (replace with your actual image URLs)
        const serviceImages = {
            'Consultation': '../assets/consulrtation.png',
            'Vaccination': '../assets/vaccination.png',
            'Treatment': '../assets/treatment.png',
            'Blood Chemistry Test': '../assets/blood-test.png',
            'Deworming': '../assets/deworming.png',
            'Diagnostic': '../assets/diagnostic.png',
            'Grooming': '../assets/grooming.png',
            'HeartWorm': '../assets/heartworm.png',
            'Laboratory': '../assets/laboratory.png',
            'Surgery': '../assets/surgery.png',
            'Confinement': '../assets/confinement.png',
            'Cesarian Section Surgery': '../assets/confinement.png',
            // Add more mappings as needed
        };

        // Sort the services based on count in descending order
        const sortedServices = Object.keys(serviceImages).sort((a, b) => {
            const countA = (data.find(item => item.service_name === a) || { count: 0 }).count;
            const countB = (data.find(item => item.service_name === b) || { count: 0 }).count;
            return countB - countA;
        });

        // Create only the first four cards
        const rowContainer = document.createElement('div');
rowContainer.classList.add('row');

for (let index = 0; index < 4; index++) {
    // Get the image URL based on the service name
    const currentService = sortedServices[index];
    const imageUrl = serviceImages[currentService];

    // Find data for the current service
    const currentData = data.find(item => item.service_name === currentService) || { count: 0 };

    // Create card
    const card = document.createElement('div');
    card.classList.add('col-md-3');
    card.innerHTML = `
        <div class="card border-left-primary shadow mt-1">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <h5 style="font-size: 16px;" class="text-xs font-weight-bold text-primary text-uppercase mb-1">${currentService}</h5>
                        <p class="h5 mb-0 text-dark">Count: ${currentData.count}</p>
                    </div>
                    <div class="col-auto">
                        <img src="${imageUrl}" style="width:50px" alt="${currentService}">
                    </div>
                </div>
            </div>
        </div>
    `;

    // Append the card to the row container
    rowContainer.appendChild(card);
}

// Append the row container to the main container
container.appendChild(rowContainer);
    };

    // Fetch data from the PHP script and create cards
    fetch('pos/fetch_pie.php')
        .then(response => response.json())
        .then(data => createCards(data))
        .catch(error => console.error('Error fetching data:', error));
</script>













    <br>
    <div class="row">
        <div class="col-md-8">
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
            <div class="col-md-4">
            <canvas class="mt-3" id="pieChart" width="400" height="400"></canvas>

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

                                // Create a pie chart
                                var ctx = document.getElementById('pieChart').getContext('2d');
                                var myPieChart = new Chart(ctx, {
                                    type: 'pie',
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            data: values,
                                            backgroundColor: [
                                                'rgba(255, 99, 132, 0.7)',
                                                'rgba(54, 162, 235, 0.7)',
                                                'rgba(255, 206, 86, 0.7)',
                                                'rgba(75, 192, 192, 0.7)',
                                                'rgba(153, 102, 255, 0.7)',
                                                'rgba(255, 159, 64, 0.7)',
                                                'rgba(0, 128, 0, 0.7)',   // Green
                                                'rgba(255, 0, 0, 0.7)',   // Red
                                                'rgba(0, 0, 255, 0.7)',   // Blue
                                                'rgba(255, 140, 0, 0.7)', // Dark Orange
                                                'rgba(128, 0, 128, 0.7)', // Purple
                                                'rgba(0, 255, 255, 0.7)', // Cyan
                                            ],
                                        }],
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
        <div class="row">
            <div class="col-md-12"><h3>Recently Availed Service</h3></div>
            <div class="col-md-12">
                <table class="table reponsive">
                    <th>Date</th>
                    <th>Customer Name</th>
                    <th>Service Availed</th>
                    <th>Staff Name</th>
                    <th></th>

                    <?php if(is_array($recent_user)) {?>
                        <?php foreach($recent_user as $view) {?>
                        <tr>
                            <td><?= date("F d, Y - l", strtotime($view['created_at'])); ?></td>
                            <td><?= $view['customer_name'];?></td>
                            <td><?= $view['service_availed'];?></td>
                            <td><?= $view['staff_name'];?></td>
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