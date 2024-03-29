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

    // For Low Inventory
    $recordsPerPage = 3; // set the number of records to display per page
    $view = $staffbmis->view_low_inventory($page, $recordsPerPage);
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
    <style>
            .col-md-3 {
        display: flex;
        
    }
            .card-ui {
                display: flex;
                flex-direction: column;
                width:100%;
            }
            .item-header {
                margin-bottom: 10px;
            }
            .card-ui h5:last-child {
                flex-grow: 1;
            }
            </style>
        <div class="card card-ui border-left-primary shadow mt-1">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                    <h5 id="currentServiceHeading" style="font-size: 16px;" class="text-xs font-weight-bold text-primary text-uppercase mb-1">${currentService}</h5>
                        <p style="font-size: 16px;" class="h5 mb-0 text-dark">Count: ${currentData.count}</p>
                    </div>
                    <div class="col-auto">
                        <img src="${imageUrl}" style="width:35px" alt="${currentService}">
                    </div>
                </div>
            </div>
        </div>
    `;

//     const currentServiceHeading = document.getElementById('currentServiceHeading');

// // Get the text content of the element
// const currentService = currentServiceHeading.textContent;

// // Check if the length of the text content is greater than 30 characters
// currentServiceHeading.textContent = currentService.length > 12 ? currentService.substring(0, 12) + '...' : currentService;
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


<script>
  // Get the element by its ID

</script>





    <div class="row mt-5">
            <div class="col-md-12">
                <div class="d-flex justify-content-between">
                    <h3>Low Stock</h3>
                    <a class="btn btn-primary mb-3" href="admin_low_inventory.php">See More</a>
                </div>
                
            </div>
            <div class="col-md-12">
                <table class="table reponsive">
                    <th> Product Name </th>
                    <th> Quantity </th>
                    <th> Category </th>
                    <th></th>

                    <?php if(is_array($view)) {?>
                            <?php foreach($view as $view) {?>
                                <tr>
                                    <td> <?= strlen($view['name']) > 20 ? substr($view['name'], 0, 20) . '...' : $view['name']; ?> </td>
                                    <td> <?= $view['quantity'];?> </td>
                                    <td> <?= $view['category'] ? $view['category'] : 'N/A' ;?> </td>
                                    <td class="text-center"><span class="badge bg-danger">Low Stocks</span></td>
                                </tr>
                            <?php }?>
                        <?php } ?>
                </table>    
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