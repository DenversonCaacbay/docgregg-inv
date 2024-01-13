<?php
    
    ini_set('display_errors',0);
    error_reporting(E_ALL ^ E_WARNING);
    require('../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $bmis->validate_admin();
    $view = $staffbmis->view_user();
    // $bmis->validate_admin();
    // $bmis->delete_bspermit();
    // $view = $bmis->view_bspermit();
    $id_user = $_GET['id_user'];
    $staffbmis->create_pet($id_user);
    // echo $id_user;
    // $resident = $residentbmis->get_single_bspermit($id_resident);
   
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
        text-align: left;
    }
</style>

<!-- Begin Page Content -->

<div class="container-fluid">

    <!-- Page Heading -->

    <div class="d-flex align-items-center">
        <a class="btn btn-primary" href="services.php">Back</a>
        <h1 class="mb-0 ml-2">Availed Service</h1>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form method="post" enctype='multipart/form-data' class="mt-1 p-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="container">
                             <div class="row me-5 mt-3">
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label> Customer Name: </label>
                                    <input type="text" class="form-control" name="pet_name" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Consultation
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Vaccination
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Deworming
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            HeartWorm
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                           Treatment
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                           Surgery
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                           Laboratory
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Confinement
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Diagnostic
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Grooming
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Cesarian Section Surgery
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Blood Chemistry Test
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <input type="submit" class="btn btn-primary w-100 mb-3" name="add_pet" value="Add Service"/>
                            </div>
                            
                            
                        </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div> 
</div>
<script>
    $(document).ready(function() {
        var breedContainer = $('#breedContainer');
        var otherBreedInput = $('#otherBreedInput');

        $('#pet_type').change(function() {
            var selectedPetType = $(this).val();

            // Clear previous options
            $('#pet_breed').empty();

            if (selectedPetType === 'Dog') {
                // Show the breed select and populate it with dog breeds
                breedContainer.show();
                $('#pet_breed').append('<option value="Labrador">Labrador Retriever</option>');
                $('#pet_breed').append('<option value="Golden_Retriever">Golden Retriever</option>');
                $('#pet_breed').append('<option value="German_Shepherd">German Shepherd</option>');
                $('#pet_breed').append('<option value="Bulldog">Bulldog</option>');
                $('#pet_breed').append('<option value="Beagle">Beagle</option>');
                $('#pet_breed').append('<option value="Poodle">Poodle</option>');
                $('#pet_breed').append('<option value="Rottweiler">Rottweiler</option>');
                $('#pet_breed').append('<option value="Husky">Siberian Husky</option>');
                $('#pet_breed').append('<option value="Dachshund">Dachshund</option>');
                $('#pet_breed').append('<option value="Azkal">Azkal</option>');
                $('#pet_breed').append('<option value="Other">Other</option>');
            } else if (selectedPetType === 'Cat') {
                // Show the breed select and populate it with cat breeds
                breedContainer.show();
                $('#pet_breed').append('<option value="Siamese">Siamese</option>');
                $('#pet_breed').append('<option value="Persian">Persian</option>');
                $('#pet_breed').append('<option value="Maine_Coon">Maine Coon</option>');
                $('#pet_breed').append('<option value="Sphynx">Sphynx</option>');
                $('#pet_breed').append('<option value="Ragdoll">Ragdoll</option>');
                $('#pet_breed').append('<option value="British_Shorthair">British Shorthair</option>');
                $('#pet_breed').append('<option value="Bengal">Bengal</option>');
                $('#pet_breed').append('<option value="Abyssinian">Abyssinian</option>');
                $('#pet_breed').append('<option value="Scottish_Fold">Scottish Fold</option>');
                $('#pet_breed').append('<option value="Other">Other</option>');
            } else {
                // Hide the breed select if neither Dog nor Cat is selected
                breedContainer.hide();
            }
        });

        $('#pet_breed').change(function() {
            var selectedBreed = $(this).val();

            // Show additional input if "Other" is selected
            if (selectedBreed === 'Other') {
                otherBreedInput.show();
            } else {
                otherBreedInput.hide();
            }
        });
    });
</script>

<!-- <script>
    $(document).ready(function() {
        $('#pet_type').change(function() {
            var selectedPetType = $(this).val();
            var breedContainer = $('#breedContainer');
            // Clear previous options
            $('#pet_breed').empty();
            if (selectedPetType === 'Dog') {
                // Show the breed select and populate it with dog breeds
                breedContainer.show();
                $('#pet_breed').append('<option value="Labrador">Labrador Retriever</option>');
                $('#pet_breed').append('<option value="Golden_Retriever">Golden Retriever</option>');
                $('#pet_breed').append('<option value="German_Shepherd">German Shepherd</option>');
                $('#pet_breed').append('<option value="Bulldog">Bulldog</option>');
                $('#pet_breed').append('<option value="Beagle">Beagle</option>');
                $('#pet_breed').append('<option value="Poodle">Poodle</option>');
                $('#pet_breed').append('<option value="Rottweiler">Rottweiler</option>');
                $('#pet_breed').append('<option value="Husky">Siberian Husky</option>');
                $('#pet_breed').append('<option value="Dachshund">Dachshund</option>');
                $('#pet_breed').append('<option value="Azkal">Azkal</option>');
                $('#pet_breed').append('<option value="Other">Other...</option>');
                // Add more dog breeds as needed
            } else if (selectedPetType === 'Cat') {
                // Show the breed select and populate it with cat breeds
                breedContainer.show();
                $('#pet_breed').append('<option value="Siamese">Siamese</option>');
                $('#pet_breed').append('<option value="Persian">Persian</option>');
                $('#pet_breed').append('<option value="Maine_Coon">Maine Coon</option>');
                $('#pet_breed').append('<option value="Sphynx">Sphynx</option>');
                $('#pet_breed').append('<option value="Ragdoll">Ragdoll</option>');
                $('#pet_breed').append('<option value="British_Shorthair">British Shorthair</option>');
                $('#pet_breed').append('<option value="Bengal">Bengal</option>');
                $('#pet_breed').append('<option value="Abyssinian">Abyssinian</option>');
                $('#pet_breed').append('<option value="Scottish_Fold">Scottish Fold</option>');
                $('#pet_breed').append('<option value="Other">Other</option>');
                // Add more cat breeds as needed
            } else {
                // Hide the breed select if neither Dog nor Cat is selected
                breedContainer.show();
            }
        });
    });
</script> -->
<script>
    
function calculateAge() {
    // Get the entered birthdate from the input field
    var birthdateInput = document.getElementById("birthdate");
    var birthdate = new Date(birthdateInput.value);

    // Get the current date
    var currentDate = new Date();

    // Calculate the age in years
    var ageInMilliseconds = currentDate - birthdate;
    var ageInYears = ageInMilliseconds / (365.25 * 24 * 60 * 60 * 1000);

    // Display the calculated age in the second input field
    var ageInput = document.getElementById("age");
    ageInput.value = ageInYears.toFixed(2) + " years";
}
</scrip>
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

