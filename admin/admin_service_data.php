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
        <div class="col-md-12">
            <div class="d-flex align-items-center">
                <a class="btn btn-primary" href="admin_dashboard.php">Back</a>
                <h1 class="mb-0 ml-2">All Services</h1>
            </div>
            
            <br>
        </div>
        <div id="serviceCardsContainer"></div>
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

        // Create cards for all services, sorted by count
        sortedServices.forEach((currentService, index) => {
            if (index % 4 === 0) {
                // Create a new row for every four cards
                const row = document.createElement('div');
                row.classList.add('row');
                container.appendChild(row);
            }

            // Get the image URL based on the service name
            const imageUrl = serviceImages[currentService];

            // Find data for the current service
            const currentData = data.find(item => item.service_name === currentService) || { count: 0 };

            // Create card and add to the current row
            const card = document.createElement('div');
            card.classList.add('col-md-3');
            card.innerHTML = `
                <div class="card border-left-primary shadow mt-3">
                    
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <h5 style="font-size: 16px;" class="text-xs font-weight-bold text-primary text-uppercase mb-1">${currentService}</h5>
                                <p class="h5 mb-0 -bold text-dark">Count: ${currentData.count}</p>
                            </div>
                            <div class="col-auto">
                                <img src="${imageUrl}" style="width:50px" alt="${currentService}">
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Append the card to the current row
            container.lastChild.appendChild(card);
        });
    };

    // Fetch data from the PHP script and create cards
    fetch('pos/fetch_pie.php')
        .then(response => response.json())
        .then(data => createCards(data))
        .catch(error => console.error('Error fetching data:', error));
</script>



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