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

    $pets = $staffbmis->view_customer_pets();
    // print_r($pets);
    $id_user = $_GET['id_user'];
    $staffbmis->create_pet($id_user);

    $view_syringe = $staffbmis->view_inventory_internal_syringe();

    $view_vaccine = $staffbmis->view_inventory_internal_vaccine();

    $view_medicine = $staffbmis->view_inventory_internal_medicine();
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

<div class="container-fluid page-container">

    <!-- Page Heading -->

    <div class="d-flex align-items-center">
        <a class="btn btn-primary" href="view_customer.php?id=<?= $_GET['id'] ?>">Back</a>
        <h4 class="mb-0 ms-4">Avail Service - Cat</h4>
    </div>
    <div class="row">
        <div class="col-md-12">
            
            <div class="row">
                <div class="col-md-4">
                    <form method="post" enctype='multipart/form-data' class="mt-1 p-2">
                        <label hidden>Pet Name:</label>
                        <input type="text" name="chosen_pet"  class=" form-control" value="Not Needed" hidden/>
                        <label hidden>Pet Type:</label>
                        <input type="text" name="chosen_type"  class=" form-control" value="Dog" hidden/>
                        <!-- <select class="form-select" name="chosen_type" required>
                            <option value="">-- Select Type --</option>
                            <option value="Dog">Dog</option>
                            <option value="Cat">Cat</option>
                        </select> -->
                        <label class="mt-3">Select Service:</label>
                        <select id="serviceSelect" class="form-select" onchange="showOptions()" required>
                            <option>Select a service</option>
                            <option value="vaccination">Vaccination</option>
                            <option value="deworming">Deworming</option>
                            <option value="heartworm">Heartworm</option>
                            <option value="treatment">Treatment</option>
                            <option value="surgery">Surgery</option>
                            <option value="laboratory">Laboratory</option>
                            <option value="confinement">Confinement</option>
                            <option value="diagnostic">Diagnostic</option>
                            <option value="grooming">Grooming</option>
                            <option value="cesarian">Cesarian Section Surgery</option>
                            <option value="bloodchemistry">Blood Chemistry Test</option>
                        </select>
                        <div id="additionalOptions" class="mt-3" style="display: none;">
                            <!-- Additional select options will be displayed here -->
                        </div>
                        <input type="hidden" name="staff" value="<?= $userdetails['fname']?> <?= $userdetails['lname']?>">
                        
                        <button type="submit" class="btn btn-primary w-100 mt-3" onclick="availService()">Add to Table</button>
                    </form>
                </div>
                <div class="col-md-8">
                    <form class="form--card mt-3" action="../classes/insert_data.php?id=<?= $_GET['id'] ?>" method="post">
                        <table id="itemTable" class="table table-border">
                            <thead>
                                <th hidden>Pet</th>
                                <th hidden>Pet Type</th>
                                <th>Service</th>
                                <th>Type / Medicine / Equipment</th>
                                <th>Quantity</th>
                                <th hidden>Staff</th>
                                <th>Cancel</th>
                                
                            </thead>
                            <tbody>
                                <!-- Table rows will be dynamically added here -->
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-6"><button type="button" class="btn btn-danger w-100 mt-3" onclick="clearTable()">Clear Table</button></div>
                            <div class="col-md-6">
                            <input type="hidden" name="tableData" id="tableDataInput">
                            <input type="submit" class="btn btn-primary w-100 mt-3" onclick="clearTable()" value="Avail Service">
                    
                            </div>
                        </div>
                        
                        
                    </form>
                    
                </div>
            </div>

        </div>
    </div> 
</div>

<script>
    function showOptions() {
        var serviceSelect = document.getElementById("serviceSelect");
        var selectedOption = serviceSelect.value;
        var additionalOptionsDiv = document.getElementById("additionalOptions");
        additionalOptionsDiv.innerHTML = ""; // Clear previous options

        if (selectedOption === "vaccination" || selectedOption === "surgery" || selectedOption === "cesarian") {
            // Fetch deworming medicines from the server
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var medicines = JSON.parse(this.responseText);
                    var selectHTML = '<label>List of Syringe and Vaccine: </label><select class="form-select" size="5">';
                    for (var i = 0; i < medicines.length; i++) {
                        selectHTML += '<option value="' + medicines[i].id + '">' + medicines[i].name + '</option>';
                    }
                    selectHTML += '</select>';
                    selectHTML += '<label class="mt-3">Enter Quantity: </label><input type="number" name="quantity" class="form-control" id="quantityInput" placeholder="Enter quantity">';
                    additionalOptionsDiv.innerHTML = selectHTML;
                }
            };
            xhttp.open("GET", "../classes/fetch_vaccination.php", true);
            xhttp.send();
        } 
        else if (selectedOption === "deworming") {
            // Fetch deworming medicines from the server
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var medicines = JSON.parse(this.responseText);
                    var selectHTML = '<label>List of Medicines: </label><select class="form-select" size="5">';
                    for (var i = 0; i < medicines.length; i++) {
                        selectHTML += '<option value="' + medicines[i].id + '">' + medicines[i].name + '</option>';
                    }
                    selectHTML += '</select>';
                    selectHTML += '<label class="mt-3">Enter Quantity: </label><input type="number" name="quantity" class="form-control" id="quantityInput" placeholder="Enter quantity">';
                    additionalOptionsDiv.innerHTML = selectHTML;
                }
            };
            xhttp.open("GET", "../classes/fetch_medicine.php", true);
            xhttp.send();
        } else if (selectedOption === "treatment") {
            var selectHTML = '<select id="treatmentType" class="form-select">' +
                                '<option value="">-- Select Treatment --</option>' +
                                '<option value="surgical">Surgical</option>' +
                                '<option value="medicine">Medicine</option>' +
                            '</select>';
            additionalOptionsDiv.innerHTML = selectHTML;

            var treatmentTypeSelect = document.getElementById("treatmentType");
            treatmentTypeSelect.addEventListener("change", function() {
                var selectedTreatment = this.value;
                var additionalOptionsHTML = '';
                if (selectedTreatment === "surgical") {
                    // Fetch syringe and vaccine options
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            var medicines = JSON.parse(this.responseText);
                            additionalOptionsHTML += '<label>List of Syringe and Vaccine: </label><select class="form-select" size="5">';
                            for (var i = 0; i < medicines.length; i++) {
                                additionalOptionsHTML += '<option value="' + medicines[i].id + '">' + medicines[i].name + '</option>';
                            }
                            additionalOptionsHTML += '</select>';
                            additionalOptionsHTML += '<label class="mt-3">Enter Quantity: </label><input type="number" name="quantity" class="form-control" id="quantityInput" placeholder="Enter quantity">';
                            additionalOptionsDiv.innerHTML = additionalOptionsHTML;
                        }
                    };
                    xhttp.open("GET", "../classes/fetch_vaccination.php", true);
                    xhttp.send();
                } else if (selectedTreatment === "medicine") {
                    // Fetch medicine options
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            var medicines = JSON.parse(this.responseText);
                            additionalOptionsHTML += '<label>List of Medicines: </label><select class="form-select" size="5">';
                            for (var i = 0; i < medicines.length; i++) {
                                additionalOptionsHTML += '<option value="' + medicines[i].id + '">' + medicines[i].name + '</option>';
                            }
                            additionalOptionsHTML += '</select>';
                            additionalOptionsHTML += '<label class="mt-3">Enter Quantity: </label><input type="number" name="quantity" class="form-control" id="quantityInput" placeholder="Enter quantity">';
                            additionalOptionsDiv.innerHTML = additionalOptionsHTML;
                        }
                    };
                    xhttp.open("GET", "../classes/fetch_medicine.php", true);
                    xhttp.send();
                }
            });
        }
        else if (selectedOption === "laboratory") {
            var selectHTML = '<select class="form-select">' +
                                '<option>CBC</option>' +
                                '<option>DIAGNOSTIC TEST KITS</option>' +
                                '<option>ULTRASOUND</option>' +
                             '</select>';
            selectHTML += '<label class="mt-3  d-none">Enter Quantity: </label><input type="number" name="quantity" class="form-control" value="0" id="quantityInput" placeholder="Enter quantity" hidden>';
            additionalOptionsDiv.innerHTML = selectHTML;
            
        } else if (selectedOption === "grooming") {
            var selectHTML = '<select class="form-select">' +
                                '<option>Basic Grooming</option>' +
                                '<option>Full Groom</option>' +
                             '</select>';
            selectHTML += '<label class="mt-3  d-none">Enter Quantity: </label><input type="number" name="quantity" class="form-control" value="0" id="quantityInput" placeholder="Enter quantity" hidden>';
            additionalOptionsDiv.innerHTML = selectHTML;
        } else if (selectedOption === "bloodchemistry") {
            var selectHTML = '<select class="form-select">' +
                                '<option>Chem 17 Dog</option>'
                             '</select>';
            selectHTML += '<label class="mt-3 d-none">Enter Quantity: </label><input type="number" name="quantity" class="form-control" value="0" id="quantityInput" placeholder="Enter quantity" hidden>';
            additionalOptionsDiv.innerHTML = selectHTML;
        }

        if (selectedOption !== "Select a service") {
            additionalOptionsDiv.style.display = "block"; // Show additional options
        } else {
            additionalOptionsDiv.style.display = "none"; // Hide additional options if no service selected
        }
    }


    function availService() {
    var petInput = document.querySelector('input[name="chosen_pet"]');
    var staffInput = document.querySelector('input[name="staff"]');
    var typeInput = document.querySelector('input[name="chosen_type"]');
    var serviceSelect = document.getElementById("serviceSelect");
    var quantityInput = document.querySelector('input[name="quantity"]');
    var selectedPet = petInput.value.trim();
    var selectedStaff = staffInput.value.trim();
    var selectedType = typeInput.value.trim(); 
    var selectedQuantity = quantityInput.value.trim(); 
    var selectedService = serviceSelect.options[serviceSelect.selectedIndex].text;

    // Check if pet input is empty
    if (selectedPet === '') {
        alert('Please select a pet.');
        return; // Exit function if pet input is empty
    }

    // Check if pet type input is empty
    if (selectedType === '') {
        alert('Please select a pet type.');
        return; // Exit function if pet type input is empty
    }

    if (selectedQuantity === '') {
        alert('Quantity Field is Empty.');
        return; // Exit function if pet type input is empty
    }

    // Check if service is not selected
    if (selectedService === 'Select a service') {
        alert('Please select a service.');
        return; // Exit function if service is not selected
    }

    // Get selected additional options if any
    var additionalOptionsDiv = document.getElementById("additionalOptions");
    var selectedOptions = additionalOptionsDiv.querySelectorAll('select option:checked');
    var selectedOptionsText = [];
    selectedOptions.forEach(function(option) {
        selectedOptionsText.push(option.text);
    });
    var additionalOptions = selectedOptionsText.join(', ');

    // Populate the table
    var table = document.querySelector('.table tbody');
    var newRow = table.insertRow();
    newRow.innerHTML = '<td hidden>' + selectedPet + '</td>' +
                       '<td hidden>' + selectedType + '</td>' +
                       '<td>' + selectedService + '</td>' +
                       '<td>' + additionalOptions + '</td>' +
                       '<td>' + selectedQuantity + '</td>' +
                       '<td hidden>' + selectedStaff + '</td>';

    // Store the table data in local storage
    var tableData = {
        pet: selectedPet,
        type: selectedType,
        service: selectedService,
        options: selectedOptionsText,
        quantity: selectedQuantity,
        staff: selectedStaff,
    };
    var existingTableData = localStorage.getItem('tableData');
    if (existingTableData) {
        existingTableData = JSON.parse(existingTableData);
        existingTableData.push(tableData);
        localStorage.setItem('tableData', JSON.stringify(existingTableData));
    } else {
        localStorage.setItem('tableData', JSON.stringify([tableData]));
    }
}



// Load table data from local storage when the page loads
window.onload = function() {
    // Get the table data from localStorage
    var existingTableData = localStorage.getItem('tableData');

    // Set the table data to the tableData input field value
    document.getElementById('tableDataInput').value = existingTableData;

    // Check if existingTableData is not null before processing
    if (existingTableData) {
        existingTableData = JSON.parse(existingTableData);
        var table = document.querySelector('.table tbody');
        existingTableData.forEach(function(data, index) {
            var newRow = table.insertRow();
            newRow.innerHTML = '<td hidden>' + data.pet + '</td>' +
                               '<td hidden>' + data.type + '</td>' +
                               '<td>' + data.service + '</td>' +
                               '<td>' + data.options.join(', ') + '</td>' +
                               '<td>' + data.quantity + '</td>' +
                               '<td hidden>' + data.staff + '</td>'+
                               '<td><button class="btn btn-danger" onclick="removeRow(' + index + ')">Cancel</button></td>';
        });
    }
};

function clearTable() {
    var table = document.querySelector('.table tbody');
    table.innerHTML = ''; // Clear table contents

    localStorage.removeItem('tableData'); // Remove table data from local storage
}

// Function to remove a row from the table and update local storage
function removeRow(index) {
    var table = document.querySelector('.table tbody');
    table.deleteRow(index);

    var existingTableData = localStorage.getItem('tableData');
    if (existingTableData) {
        existingTableData = JSON.parse(existingTableData);
        existingTableData.splice(index, 1);
        localStorage.setItem('tableData', JSON.stringify(existingTableData));
    }
}


</script>
