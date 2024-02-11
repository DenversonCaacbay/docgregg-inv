<?php
    
    // ini_set('display_errors',0);
    error_reporting(E_ALL ^ E_WARNING);
    require('../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $user = $staffbmis->view_single_staff($userdetails['id_admin']);
    $bmis->validate_admin();
    $view = $staffbmis->view_user();
    // $bmis->validate_admin();
    // $bmis->delete_bspermit();
    // $view = $bmis->view_bspermit();

    $staffbmis->create_service();

    $id_user = $_GET['id_user'];
    $staffbmis->create_pet($id_user);
    // echo $id_user;
    // $resident = $residentbmis->get_single_bspermit($id_resident);
    // if ($userdetails['role'] !== 'administrator') {
    //     // User is not an admin, display an alert
    //     echo '<script>alert("You are not authorized to access this page as admin.");</script>';
    //     // Redirect or take appropriate action if needed
    //     header('Location: admin_dashboard.php');
    //     exit();
    // }
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
        <h1 class="mb-0 ms-5">Availed Service</h1>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form method="post" enctype='multipart/form-data' class="mt-1 p-2" onsubmit="return validateForm()">
                <div class="row">
                    <div class="col-md-12">
                        <div class="container">
                             <div class="row me-5 mt-3">
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label> Customer Name: </label>
                                    <input type="text" class="form-control" name="customer_name" required>
                                </div>
                            </div>
                            <div class="col-md-6 mt-2">
                                <div class="form-group">
                                    <label> Contact Number: </label>
                                    <input type="number" class="form-control" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==11) return false;"  name="customer_contact" required>
                                </div>
                            </div>
                            <div class="col-md-6 mt-2">
                                <div class="form-group">
                                    <label> Address: </label>
                                    <input type="text" class="form-control" name="customer_address" required>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Consultation" name="services_list[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Consultation
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Vaccination" name="services_list[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Vaccination
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Deworming" name="services_list[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Deworming
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="HeartWorm" name="services_list[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            HeartWorm
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Treatment" name="services_list[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                           Treatment
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Surgery" name="services_list[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                           Surgery
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Laboratory" name="services_list[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                           Laboratory
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Confinement" name="services_list[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Confinement
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Diagnostic" name="services_list[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Diagnostic
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Grooming" name="services_list[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Grooming
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Cesarian Section Surgery" name="services_list[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Cesarian Section Surgery
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Blood Chemistry Test" name="services_list[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Blood Chemistry Test
                                        </label>
                                    </div>

                                    <!-- test for treatment here. feel free to edit -->
                                    <!-- <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Treatment test" name="treatment_list[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Treatment test
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Treatment test2" name="treatment_list[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Treatment test 2
                                        </label>
                                    </div> -->
                                    <!-- treatment test end -->

                                </div>
                                <div class="form-group" hidden>
                                    <label> Staff Name: </label>
                                    <input type="text" class="form-control" name="staff_name" value="<?= $userdetails['fname']?> <?= $userdetails['lname']?>">
                                </div>
                            </div>

                            <!-- <div class="form-group mt-3">
                                
                                <input  type="text" class="form-control" name="treatment_input" placeholder="Enter Treatment: " id="treatmentInput" style="display: none;">
                            </div> -->
                            <div class="input-group mt-3" id="showTreatment" style="display:none;">
                                <label>Select Treatment</label>
                                <select class="form-select w-100" name="treatment_input">
                                    <option selected></option>
                                    <option value="Surgical">Surgical</option>
                                    <option value="Disease Management">Disease Management</option>
                                </select>
                            </div>

                            
                            <div class="mt-3">
                                <input type="submit" class="btn btn-primary w-100 mb-3" name="create_service" value="Add Service" onclick="return confirm('Are you sure you want to Avail this Services?')" disabled />
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
    document.addEventListener('DOMContentLoaded', function () {
    var checkboxes = document.querySelectorAll('input[type="checkbox"][name="services_list[]"]');
    var treatmentCheckbox = document.querySelector('input[type="checkbox"][value="Treatment"]');
    var submitButton = document.querySelector('input[type="submit"][name="create_service"]');
    var treatmentInput = document.getElementById('showTreatment'); // Corrected element ID
    var treatmentDropdown = document.querySelector('select[name="treatment_input"]'); // Selecting the treatment dropdown

    // Initial check and set the button state
    checkAndUpdateButtonState();

    // Add event listener to each checkbox to update the button state
    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', checkAndUpdateButtonState);
    });

    // Add event listener to the treatment checkbox
    treatmentCheckbox.addEventListener('change', function () {
        if (this.checked) {
            // Show the treatment input field
            treatmentInput.style.display = 'block';
            treatmentDropdown.setAttribute('required', 'required'); // Make the dropdown required
        } else {
            // Hide the treatment input field
            treatmentInput.style.display = 'none';
            treatmentDropdown.removeAttribute('required'); // Remove the required attribute from the dropdown
            treatmentDropdown.selectedIndex = 0; // Reset the selected index
        }
        checkAndUpdateButtonState(); // Update button state when treatment checkbox changes
    });

    // Add event listener to the treatment dropdown
    treatmentDropdown.addEventListener('change', function () {
        if (this.value.trim() !== '') {
            // Make the treatment dropdown required if it has a selected value
            this.setAttribute('required', 'required');
        } else {
            // Remove the required attribute from the treatment dropdown if no value is selected
            this.removeAttribute('required');
        }
        checkAndUpdateButtonState(); // Update button state when treatment dropdown changes
    });

    // Function to check the status of checkboxes and update the button state
    function checkAndUpdateButtonState() {
        var atLeastOneChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
        var isTreatmentChecked = treatmentCheckbox.checked;
        var isTreatmentDropdownValid = !isTreatmentChecked || (isTreatmentChecked && treatmentDropdown.value.trim() !== '');

        // Enable submit button if at least one checkbox is checked and treatment dropdown is valid
        submitButton.disabled = !atLeastOneChecked || !isTreatmentDropdownValid;
    }
});
</script>




<!-- End of Main Content -->


<!-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        var checkboxes = document.querySelectorAll('input[type="checkbox"][name="services_list[]"]');
        var submitButton = document.querySelector('input[type="submit"][name="create_service"]');

        // Initial check and set the button state
        checkAndUpdateButtonState();

        // Add event listener to each checkbox to update the button state
        checkboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', checkAndUpdateButtonState);
        });

        // Function to check the status of checkboxes and update the button state
        function checkAndUpdateButtonState() {
            var atLeastOneChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
            submitButton.disabled = !atLeastOneChecked;
        }
    });
</script> -->