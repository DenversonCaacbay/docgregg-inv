<?php
    ini_set('display_errors',0);
    error_reporting(E_ALL ^ E_WARNING);
    require('../../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $bmis->validate_admin();
    
    $staffbmis->delete_invetory();

    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $recordsPerPage = 5; // set the number of records to display per page
    $view = $staffbmis->view_services_bloodchem($page, $recordsPerPage);
    $totalRecords = $staffbmis->count_services_bloodchem(); // get the total number of records

// Calculate the total number of pages
    $totalPages = ceil($totalRecords / $recordsPerPage);
    function getServiceBloodchem($serviceAvailed) {
        $services = explode(', ', $serviceAvailed);
        foreach ($services as $service) {
            if ($service == 'Blood Chemistry Test') {
                return $service;
            }
        }
        return ''; // Return an empty string if 'Consultation' is not found
    }

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
</style>

<!-- Begin Page Content -->

<div class="container-fluid">

    <!-- Page Heading -->

    
    
    <div class="row">
        <div class="col-md-6"><h1 class="">Services</h1></div>
        <div class="col-md-6"><a href="create_service.php" style="float:right;padding: 10px" class="btn btn-primary">Add Data</a></div>
    </div>

    <div class="row"> 
        <div class="col-md-12">
        <div class="row">
            <div class="col-md-8">
                 <div class="form-group">
                    <label> Search </label>
                    <input type="text" class="form-control" id="searchInput" name="name"  value="" required>
                </div>
            </div>
            <div class="col-md-4">
                <label> Services </label>
                <select id="categorySelect" class="form-select" aria-label="Default select example">
                    <option value="all">All</option>
                    <option value="consultation">Consultation</option>
                    <option value="vaccination">Vaccination</option>
                    <option value="deworming">Deworming</option>
                    <option value="heartworm">HeartWorm</option>
                    <option value="treatment">Treatment</option>
                    <option value="surgery">Surgery</option>
                    <option value="laboratory">Laboratory</option>
                    <option value="confinement">Confinement</option>
                    <option value="diagnostic">Diagnostic</option>
                    <option value="grooming">Grooming</option>
                    <option value="cesarian">Cesarian Section Surgery</option>
                    <option selected>Blood Chemistry Test</option>
                </select>
            </div>
        </div>
            
        <div class="card" style="height: 500px; overflow: auto;">
        <table class="table table-hover text-center table-bordered">
                <form action="" method="post">
                    <thead style="background: #0296be;color:#fff;" class="sticky"> 
                        <tr>
                            <th> Customer Name </th>
                            <th> Availed Service </th>
                            <th> Date Availed </th>
                            <th> Actions </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if(is_array($view)) {?>
                            <?php foreach($view as $view) {?>
                                <tr>

                                    <td><?= strlen($view['customer_name']) > 20 ? substr($view['customer_name'], 0, 20) . '...' : $view['customer_name']; ?></td>
                                    <td><?= getServiceBloodchem($view['service_availed']); ?></td>
                                    <td> <?= date("M d, Y", strtotime($view['created_at'])); ?> </td>
                                    <td>    
                                        <form action="" method="post">
                                            <a href="update_inventory_form.php?inv_id=<?= $view['inv_id'];?>" style="width: 70px;padding:5px; font-size: 15px; border-radius:5px; margin-bottom: 2px;" class="btn btn-success"> Update </a>
                                            <input type="hidden" name="inv_id" value="<?= $view['inv_id'];?>">
                                            <button class="btn btn-danger" type="submit" name="delete_inventory"style="width: 70px;padding:5px; font-size: 15px; border-radius:5px;"  onclick="return confirm('Are you sure you want to remove this data?')"> Remove </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php }?>
                        <?php } ?>
                    </tbody>
                </form>
            </table>
        </div>
 
            <!-- Pagination links -->
        <!-- Pagination links -->

        <!--Pagination -->
        <!-- <div class="container-fluid fixed-bottom mb-5">
        <div class="row justify-content-end">
            <div class="col-md-12">
                <ul class="pagination justify-content-end">
                    
                    <?php if ($page > 1) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $page - 1; ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    
                    <?php if ($page < $totalPages) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $page + 1; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div> -->

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"> Picture</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Modal image -->
                <img id="modalImage" class="img-fluid" alt="Modal Image" width="100%">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript function to open the modal, set the image source, and update the modal title
    function openModal(imageSrc, category) {
        console.log("Opening modal with image source and category:", imageSrc, category);

        // Assuming modalImage is the ID of your image element in the modal
        document.getElementById('modalImage').src = imageSrc;

        // Assuming modalTitle is the class of your modal title element
        document.querySelector('.modal-title').textContent = category + '- Picture';
    }
</script>


<script>
    $(document).ready(function () {
        $('#categorySelect').on('change', function () {
            var selectedValue = $(this).val();
            if (selectedValue !== 'all') {
                window.location.href = 'services-' + selectedValue + '.php';
            }
            else{
                window.location.href = '../services.php';
            }
        });
    });
</script> 

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get the input field and table
        var input = document.getElementById('searchInput');
        var table = document.querySelector('.table');

        // Add an event listener to the input field
        input.addEventListener('input', function () {
            // Get the search query and convert it to lowercase
            var query = input.value.toLowerCase();

            // Get all table rows in the tbody
            var rows = table.querySelectorAll('tbody tr');

            // Loop through each row and hide/show based on the search query
            rows.forEach(function (row) {
                var productName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                var category = row.querySelector('td:nth-child(5)').textContent.toLowerCase();

                // Check if the query matches the product name or category
                if (productName.includes(query) || category.includes(query)) {
                    row.style.display = ''; // Show the row
                } else {
                    row.style.display = 'none'; // Hide the row
                }
            });
        });
    });
</script>
<!-- End of Main Content -->

<?php 
    include('dashboard_sidebar_end.php');
?>
