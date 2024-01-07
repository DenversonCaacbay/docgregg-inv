<?php
    
    ini_set('display_errors',0);
    error_reporting(E_ALL ^ E_WARNING);
    require('../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $bmis->validate_admin();
    // $view = $staffbmis->view_user();
    $view = $staffbmis->view_single_pet();
    $staffbmis->create_vaccination_record();
    $vax = $staffbmis->view_vaccine();
    // print_r($vax);
    // $bmis->validate_admin();
    // $bmis->delete_bspermit();
    // $view = $bmis->view_bspermit();
    // $id_resident = $_GET['id_resident'];
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
        text-align: center;
    }
</style>

<!-- Begin Page Content -->

<div class="container-fluid">

    <!-- Page Heading -->

    <div class="d-flex align-items-center">
        <a class="btn btn-primary" href="admin_client_pet.php?id_user=<?= $_GET['id_user']; ?>">Back</a>
        <h1 class="mb-0 ml-2">Add Record</h1>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="container"  style="margin-top: 2em;">   
                <div class="card p-3" style="margin-bottom: 3em;">     
                    <form method="post" enctype='multipart/form-data' class="mt-1 p-2">
                    <!-- Rest of your form code -->
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> Pet Name: </label>
                                    <input type="text" class="form-control" name="pet_name" value="<?= $view['pet_name'] ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> Pet Type: </label>
                                    <input type="text" class="form-control" name="pet_type" id="petType" value="<?= $view['pet_type'] ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> Vaccine Taken: </label>
                                    <!-- <input type="text" class="form-control" name="vaccine" required> -->
                                    <select class="form-control" name="vaccine" required>
                                        <?php if(is_array($vax) && count($vax) > 0): ?>
                                        <?php foreach($vax as $item): ?>
                                            <option value="<?= $item['name']; ?>"><?= $item['name']; ?></option>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                            <option value="">No vaccine available</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="medicalConditionGroup" style="display: none;">
                                    <label> Medical Condition: </label>
                                    <select class="form-control" name="vac_condition" id="medicalCondition" required>
                                    </select>
                                </div>
                            </div>
                            <div class="com-md-12">
                                <div class="form-group" id="medicalConditionGroup">
                                    <label> Other Condition: </label>
                                    <input type="text" class="form-control" id="other_condition" name="other_condition" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> Date Vaccinated: </label>
                                    <input type="text" class="form-control" name="vac_date" value="<?= date("M d, Y") ?>" readonly>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> Next Vaccination: </label>
                                    <input type="datetime-local" class="form-control" id="nextVacInput" name="next_vac" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                            <input type="checkbox" id="vacCheckbox" name="vacc_done_check"> Vaccination Done
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <input type="submit" class="btn btn-primary w-100 mb-3" name="add_vac" value="Submit"/>
                            </div>
                        </div>
                    </form>             
                </div>
            </div>
        </div>
    </div> 
</div>
<!-- End of Main Content -->
<script>
    // Function to show/hide and populate medical condition based on pet type
    function toggleAndPopulateMedicalCondition() {
        var petType = document.getElementById('petType').value;
        var medicalConditionGroup = document.getElementById('medicalConditionGroup');
        var medicalConditionSelect = document.getElementById('medicalCondition');

        // Define medical conditions for dogs and cats
        var dogMedicalConditions = [
            "Ear Infection", "Vomiting", "Arthritis", "Dental Disease", "Leptospirosis", 
            "Conjunctivitis", "Urinary tract Infections", "Dog diarrhoea", "Obesity", 
            "Parvovirus", "Parasites", "Diarrhea", "Rabies", "Hip dysplasia", 
            "Breathing difficulties", "Dog ear Infections", "Kennel cough", 
            "Canine Distemper", "Epilepsy", "Anal fistulae", "Pancreatitis", "Cancer", 
            "Gum Disease", "Other"
        ];

        var catMedicalConditions = [
            "FeLV", "Diabetes", "Hyperthyroidism", "Dental Disease", 
            "Feline Lower Urinary tract Disease", "Loss of Appetite", "Fever", 
            "Bloody Urine", "Obesity", "Cancer", "Diarrhea", "Rabbies", 
            "Urinary Tract Infection", "Fleas", "Breathing problems", 
            "Kidney Disease", "Upper Respiratory infection", "Feline Panleukonia", 
            "Tapeworms", "Ringworms", "Vomiting", "Hearthworm", "Cat flu",  "Other"
        ];

        // Display the medical condition group if pet type is 'dog' or 'cat', hide otherwise
        if (petType.toLowerCase() === 'dog') {
            populateMedicalConditions(dogMedicalConditions);
            medicalConditionGroup.style.display = 'block';
        } else if (petType.toLowerCase() === 'cat') {
            populateMedicalConditions(catMedicalConditions);
            medicalConditionGroup.style.display = 'block';
        } else {
            medicalConditionGroup.style.display = 'none';
        }
    }

    // Function to populate medical conditions in the select element
    function populateMedicalConditions(conditions) {
        var medicalConditionSelect = document.getElementById('medicalCondition');
        medicalConditionSelect.innerHTML = ""; // Clear existing options

        // Add options based on the conditions array
        for (var i = 0; i < conditions.length; i++) {
            var option = document.createElement('option');
            option.value = conditions[i];
            option.text = conditions[i];
            medicalConditionSelect.add(option);
        }
    }

    // Add an event listener to the pet type input to trigger the toggle function
    document.getElementById('petType').addEventListener('change', toggleAndPopulateMedicalCondition);

    // Initial check on page load
    toggleAndPopulateMedicalCondition();
</script>
<script>
  $(document).ready(function() {
    // Event listener for date input changes
    $("#nextVacInput").on("input", function() {
      updateNextVacInput();
    });

    // Event listener for checkbox changes
    $("#vacCheckbox").change(function() {
      updateNextVacInput();
    });

    function updateNextVacInput() {
      var isChecked = $("#vacCheckbox");
      var nextVacInput = $("#nextVacInput");

      // Check if the selected date is today or less than today
      var selectedDate = new Date(nextVacInput.val());
      var currentDate = new Date();
      // currentDate.setHours(0, 0, 0, 0); // Set current date to the start of the day // let user pick today's date

      if (isChecked.prop("checked")) {
        nextVacInput.prop("disabled", true); // Disable the input when the checkbox is checked
        nextVacInput.val(''); // Clear the input when the checkbox is checked
      } else {
        // Check if the selected date is today or less than today
        if (selectedDate <= currentDate) {
          alert("Invalid date. Please select a date greater than today.");
          nextVacInput.val(''); // Reset the date
        }
        nextVacInput.prop("disabled", false); // Enable the input when the checkbox is unchecked
      }
    }
  });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modalmanager.min.js" integrity="sha512-/HL24m2nmyI2+ccX+dSHphAHqLw60Oj5sK8jf59VWtFWZi9vx7jzoxbZmcBeeTeCUc7z1mTs3LfyXGuBU32t+w==" crossorigin="anonymous"></script>
<!-- responsive tags for screen compatibility -->

