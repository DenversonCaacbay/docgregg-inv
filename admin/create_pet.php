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
        <a class="btn btn-primary" href="view_customer.php?id=<?= $_GET['id'] ?>">Back</a>
        <h1 class="mb-0 ml-2">Add Pets</h1>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form method="post" enctype='multipart/form-data' class="mt-1 p-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label> Pet Name: </label>
                                    <input type="text" class="form-control" name="pet_name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mtop">Pet Type</label>
                                    <select class="form-control" name="pet_type" id="pet_type" required>
                                        <option value="">Choose</option>
                                        <option value="Dog">Dog</option>
                                        <option value="Cat">Cat</option>
                                    </select> 
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="breedContainer">
                                    <label class="mtop">Pet Breed</label>
                                    <select class="form-control" name="breed" id="pet_breed" required>
                                        <!-- Breed options will be dynamically added here -->
                                    </select>
                                </div>
                             </div>  
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label> Birth Date: </label>
                                    <input type="date" class="form-control" name="bdate" id="birthdate" max="<?php echo date('Y-m-d'); ?>" required>
                                </div>
                            </div>   
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="mtop">Sex</label>
                                    <select class="form-control" name="sex" id="sex" required>
                                        <option value="" <?php echo empty($_POST['sex']) ? 'selected' : ''; ?>>Choose your Sex</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <input type="submit" class="btn btn-primary w-100 mb-3" name="add_pet" value="Add Pet"/>
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
                // Add more cat breeds as needed
            } else {
                // Hide the breed select if neither Dog nor Cat is selected
                breedContainer.show();
            }
        });
    });
</script>
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
</script>
