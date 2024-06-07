<?php
    ini_set('display_errors',1);
    error_reporting(E_ALL ^ E_WARNING);
    require('../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $user = $staffbmis->view_single_staff($userdetails['id_admin']);
    $bmis->validate_admin();
    
    $staffbmis->delete_services();

    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $recordsPerPage = 5; // set the number of records to display per page
    // $view = $staffbmis->view_services_all($page, $recordsPerPage);
    $view = $staffbmis->view_customers($page, $recordsPerPage);
    // $totalRecords = $staffbmis->count_inventory(); // get the total number of records

// Calculate the total number of pages
    $totalPages = ceil($totalRecords / $recordsPerPage);

?>

<?php 
    include('dashboard_sidebar_start.php');
?>

<style>
    thead.sticky {
        position: sticky;
        top: 0;
        z-index: 100;
    }
    th,td{
        /* justify-content: center; */
        align-content: center;
    }
    .customer--card{
        background: none;
    }
</style>

<!-- Begin Page Content -->

<div class="container-fluid page-container">

    <!-- Page Heading -->

    
    
    <div class="row">
        <div class="col-md-12 d-flex justify-content-between align-items-center">
            <h4 class="">List of Customers</h4>
            <a href="create_customer.php" class="btn btn-primary">Add Customer</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" class="form-control mt-2" id="searchInput" name="name" placeholder="Search..." required>
                    </div>
                </div>
                <div class="col-md-4">
    <div class="form-group">
        <select class="form-control mt-2" id="cityDropdown">
            <option value="">Select City</option>
        </select>
    </div>
</div>
<div class="col-md-2">
    <a href="generate_customer.php" class="btn btn-primary w-100 p-2 mt-2" id="printButton" target="_blank">Print</a>
</div>

            </div>
            <div class="card customer--card border-0">
                <table class="table table-hover text-center table-bordered" id="customerTable">
                    <thead style="background: #0296be; color: #fff;" class="sticky">
                        <tr>
                            <th>Customer Name</th>
                            <th>Contact</th>
                            <th>Email</th>
                            <th>Street</th>
                            <th>Barangay</th>
                            <th>City</th>
                            <th>Province</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (is_array($view) && count($view) > 0) { ?>
                            <?php foreach ($view as $item) { ?>
                                <tr>
                                    <td data-fullname="<?= htmlspecialchars($item['customer_name']); ?>">
                                        <?= strlen($item['customer_name']) > 20 ? substr($item['customer_name'], 0, 20) . '...' : $item['customer_name']; ?>
                                    </td>
                                    <td> <?= $item['customer_contact'] ?> </td>
                                    <td> <?= $item['customer_email'] ?> </td>
                                    <td> <?= $item['street'] ?> </td>
                                    <td> <?= $item['barangay'] ?> </td>
                                    <td> <?= $item['city'] ?> </td>
                                    <td> <?= $item['province'] ?> </td>
                                    <td>
                                        <form action="" method="post">
                                            <input type="hidden" name="serv_id" value="<?= $item['customer_id']; ?>">
                                            <input type="hidden" name="customer_name" value="<?= $item['customer_name']; ?>">
                                            <input type="hidden" name="staff_name" value="<?= $item['staff_name']; ?>">
                                            <a href="view_customer.php?id=<?= $item['id_user'] ?>" class="btn btn-primary" style="width: 70px; padding:5px; font-size: 15px; border-radius:5px;">View</a>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="8">No Customer Found</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div id="noDataFound" style="display: none; text-align: center">
                    <p>No Data Found</p>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
// Function to get unique cities from the table
function getUniqueCities() {
    var table = document.getElementById('customerTable');
    var trs = table.getElementsByTagName('tr');
    var cities = new Set();
    
    for (var i = 1; i < trs.length; i++) {
        var tds = trs[i].getElementsByTagName('td');
        if (tds[5]) {
            cities.add(tds[5].textContent || tds[5].innerText);
        }
    }
    return Array.from(cities);
}

// Function to populate the city dropdown
function populateCityDropdown() {
    var cityDropdown = document.getElementById('cityDropdown');
    var cities = getUniqueCities();
    
    cities.forEach(function(city) {
        var option = document.createElement('option');
        option.value = city;
        option.textContent = city;
        cityDropdown.appendChild(option);
    });
}

// Function to filter table rows based on search input and city dropdown
function filterTable() {
    var input = document.getElementById('searchInput').value.toLowerCase();
    var selectedCity = document.getElementById('cityDropdown').value.toLowerCase();
    var table = document.getElementById('customerTable');
    var trs = table.getElementsByTagName('tr');
    var noDataFound = document.getElementById('noDataFound');
    var visibleRowCount = 0;

    for (var i = 1; i < trs.length; i++) {
        var tds = trs[i].getElementsByTagName('td');
        var showRow = true;
        
        // Filter by city
        if (selectedCity && tds[5]) {
            var city = tds[5].textContent || tds[5].innerText;
            if (city.toLowerCase() !== selectedCity) {
                showRow = false;
            }
        }

        // Filter by search input
        if (showRow) {
            showRow = false;
            for (var j = 0; j < 3; j++) { // Only search in the first three columns
                if (tds[j]) {
                    var tdValue = tds[j].textContent || tds[j].innerText;
                    if (tdValue.toLowerCase().indexOf(input) > -1) {
                        showRow = true;
                        break;
                    }
                }
            }
        }
        
        trs[i].style.display = showRow ? "" : "none";
        if (showRow) visibleRowCount++;
    }

    // Show or hide the "No Data Found" message
    noDataFound.style.display = visibleRowCount > 0 ? "none" : "block";
}

// Function to get filtered table data
function getFilteredData() {
    var table = document.getElementById('customerTable');
    var trs = table.getElementsByTagName('tr');
    var filteredData = [];

    for (var i = 1; i < trs.length; i++) {
        if (trs[i].style.display !== 'none') {
            var tds = trs[i].getElementsByTagName('td');
            var row = [];
            for (var j = 0; j < tds.length; j++) {
                row.push(tds[j].textContent || tds[j].innerText);
            }
            filteredData.push(row);
        }
    }
    return filteredData;
}

// Event listener for search input keyup
document.getElementById('searchInput').addEventListener('keyup', filterTable);

// Event listener for city dropdown change
document.getElementById('cityDropdown').addEventListener('change', filterTable);

document.getElementById('printButton').addEventListener('click', function(event) {
    var city = document.getElementById('cityDropdown').value;
    if (city === "") {
        event.preventDefault(); // Prevent the default action of the anchor tag
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Select City First'
        });
    } else {
        this.href = 'generatepdf/generate_customer.php?city=' + encodeURIComponent(city);
    }
});


// Populate the city dropdown on page load
document.addEventListener('DOMContentLoaded', populateCityDropdown);
</script>





<!-- End of Main Content -->
