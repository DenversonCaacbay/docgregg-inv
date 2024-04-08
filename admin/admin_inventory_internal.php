<?php
    ini_set('display_errors',0);
    error_reporting(E_ALL ^ E_WARNING);
    require('../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $user = $staffbmis->view_single_staff($userdetails['id_admin']);
    $bmis->validate_admin();
    
    $staffbmis->delete_invetory();

    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $recordsPerPage = 5; // set the number of records to display per page
    $view = $staffbmis->view_inventory($page, $recordsPerPage);
    $totalRecords = $staffbmis->count_inventory(); // get the total number of records

// Calculate the total number of pages
    $totalPages = ceil($totalRecords / $recordsPerPage);

    //Para di ma access ni Staff yung page
    if ($userdetails['role'] !== 'administrator') {
        // User is not an admin, display an alert
        echo '<script>alert("You are not authorized to access this page as admin.");</script>';
        // Redirect or take appropriate action if needed
        header('Location: admin_dashboard.php');
        exit();
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
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <a class="btn btn-primary" href="admin_inventory.php">Back</a>
                <h1 class="ms-2 mt-2">Internal Inventory</h1>
            </div>
            
        </div>
        <div class="col-md-6"><a href="create_inventory.php" style="float:right;padding: 10px" class="btn btn-primary">Add Item</a></div>
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
                <label> Category </label>
                <select id="categorySelect" class="form-select" aria-label="Default select example">
                    <option>All</option>
                    <option value="vaccine">Vaccine</option>
                    <option value="syringe">Syringe</option>
                    <option value="medicine">Medicine</option>
                </select>
            </div>
        </div>
            
        <div class="card" style="height: 500px; overflow: auto;">
        <table class="table table-hover text-center table-bordered">
                <form action="" method="post">
                    <thead style="background: #0296be;color:#fff;" class="sticky"> 
                        <tr>
                            <th> Picture </th>
                            <th> Product Name </th>
                            <th> Price </th>
                            <th> Quantity </th>
                            <th> Category </th>
                            <th> Date Created </th>
                            <th> Purchased Date </th>
                            <th> Expiration Date </th>
                            <th> Actions </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if(is_array($view) && count($view) > 0) {?>
                            <?php foreach($view as $view) {?>
                                <tr>
                                <td>
                                    <?php if (is_null($view['picture'])): ?>
                                        <img id="blah" src="../assets/placeholder/item-placeholder.png" class="img-fluid" style="width: 50px; height:50px;" alt="Item Picture">
                                    <?php else: ?>
            
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="openModal('<?= $view['picture'] ?>', '<?= $view['category'] ?>')">
                                            <img src="<?= $view['picture'] ?>" class="img-fluid" alt="Modal Image" style="width: 50px; height:50px;">
                                        </a>

                                        <?php endif; ?>
                                    </td>

                                    <td><?= strlen($view['name']) > 20 ? substr($view['name'], 0, 20) . '...' : $view['name']; ?></td>
                                    <td>₱ <?= number_format($view['price']); ?> </td>
                                    <td> <?= $view['quantity'];?> </td>
                                    <td> <?= $view['category'] ? $view['category'] : 'N/A' ;?> </td>
                                    <td> <?= date("M d, Y", strtotime($view['created_at'])); ?> </td>
                                    <td> <?= $view['purchased_at'] ? date("M d, Y", strtotime($view['purchased_at'])) : "N/A"; ?> </td>
                                    <td> <?= $view['expired_at'] ? date("M d, Y", strtotime($view['expired_at'])) : "N/A"; ?> </td>
                                    <td>    
                                        <form action="" method="post">
                                            <a href="update_inventory_form.php?inv_id=<?= $view['inv_id'];?>" style="width: 70px;padding:5px; font-size: 15px; border-radius:5px; margin-bottom: 2px;" class="btn btn-success"> Update </a>
                                            <input type="hidden" name="inv_id" value="<?= $view['inv_id'];?>">
                                            <input type="hidden" name="name" value="<?= $view['name'];?>">
                                            <button class="btn btn-danger" type="submit" name="delete_inventory"style="width: 70px;padding:5px; font-size: 15px; border-radius:5px;"  onclick="return confirm('Are you sure you want to remove this data?')"> Remove </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php }?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="9">No Data Found</td>
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
                window.location.href = 'inventory/internal/admin_inventory_' + selectedValue + '.php';
            }
        });
    });
</script> 


<!-- End of Main Content -->
