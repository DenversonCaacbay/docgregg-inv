<?php
    ini_set('display_errors',0);
    error_reporting(E_ALL ^ E_WARNING);
    require('../../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $user = $staffbmis->view_single_staff($userdetails['id_admin']);
    $bmis->validate_admin();
    
    $staffbmis->delete_invetory();

    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $recordsPerPage = 5; // set the number of records to display per page
    $view = $staffbmis->view_services_deworming($page, $recordsPerPage);
    $totalRecords = $staffbmis->count_services_deworming(); // get the total number of records

// Calculate the total number of pages
    $totalPages = ceil($totalRecords / $recordsPerPage);
    function getServiceDeworming($serviceAvailed) {
        $services = explode(', ', $serviceAvailed);
        foreach ($services as $service) {
            if ($service == 'Deworming') {
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
        <div class="col-md-6"><a href="../create_service.php" style="float:right;padding: 10px" class="btn btn-primary">Add Data</a></div>
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
                    <option selected>Deworming</option>
                    <option value="heartworm">HeartWorm</option>
                    <option value="treatment">Treatment</option>
                    <option value="surgery">Surgery</option>
                    <option value="laboratory">Laboratory</option>
                    <option value="confinement">Confinement</option>
                    <option value="diagnostic">Diagnostic</option>
                    <option value="grooming">Grooming</option>
                    <option value="cesarian">Cesarian Section Surgery</option>
                    <option value="bloodchemtest">Blood Chemistry Test</option>
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
                       
                        </tr>
                    </thead>

                    <tbody>
                    <?php if (is_array($view) && count($view) > 0) { ?>
                            <?php foreach($view as $view) {?>
                                <tr>

                                    <td><?= strlen($view['customer_name']) > 20 ? substr($view['customer_name'], 0, 20) . '...' : $view['customer_name']; ?></td>
                                    <td><?= getServiceDeworming($view['service_availed']); ?></td>
                                    <td> <?= date("M d, Y", strtotime($view['created_at'])); ?> </td>
                                    
                                </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="4">No Data Found</td>
                                </tr>
                            <?php } ?>
                    </tbody>
                </form>
            </table>
            <div id="noDataFound" style="display: none;text-align:center">
                    <p>No Data Found</p>
                </div>
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


<!-- End of Main Content -->

<?php 
    include('dashboard_sidebar_end.php');
?>
