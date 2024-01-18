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
    fetch('pos/fetch_pie.php')
        .then(response => response.json())
        .then(data => {
            // Sort the data by count in descending order
            data.sort((a, b) => b.count - a.count);

            // Service images mapping (replace with your actual image URLs)
            const serviceImages = {
                'Consultation': '../assets/consulrtation.png',
                'Vaccination': '../assets/vaccination.png',
                'Treatment': '../assets/treatment.png',
                'BloodTest': '../assets/blood-test.png',
                'Deworming': '../assets/deworming.png',
                'Diagnostic': '../assets/diagnostic.png',
                'Grooming': '../assets/grooming.png',
                'HeartWorm': '../assets/heartworm.png',
                'Laboratory': '../assets/laboratory.png',
                'Surgery': '../assets/surgery.png',
                'Confinement': '../assets/confinement.png',
                // Add more mappings as needed
            };

            // Process the data and create HTML cards
            const container = document.getElementById('serviceCardsContainer');
            let row;

            for (let i = 0; i < data.length; i++) {
                // Create a new row for every third card
                if (i % 4 === 0) {
                    row = document.createElement('div');
                    row.classList.add('row', 'mb-4');
                    container.appendChild(row);
                }

                // Get the image URL based on the service name
                const imageUrl = serviceImages[data[i].service_name] || '../assets/confinement.png';

                // Create card and add to the current row
                const card = document.createElement('div');
                card.classList.add('col-md-3');
                card.innerHTML = `
                    <div class="card border-left-primary shadow">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <h5 class="text-xs font-weight-bold text-primary text-uppercase mb-1">${data[i].service_name}</h5>
                                    <p class="h5 mb-0 font-weight-bold text-dark">Count: ${data[i].count}</p>
                                </div>
                                <div class="col-auto">
                                    <img src="${imageUrl}" style="width:50px" alt="${data[i].service_name}">
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                // Append the card to the current row
                row.appendChild(card);
            }
        })
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