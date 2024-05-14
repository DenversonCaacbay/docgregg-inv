<?php
    ini_set('display_errors',0);
    error_reporting(E_ALL ^ E_WARNING);
    require('../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $user = $staffbmis->view_single_staff($userdetails['id_admin']);
    $bmis->validate_admin();

    // $view = $staffbmis->view_inventory_expires();
    
    $staffbmis->delete_invetory();

    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $recordsPerPage = 3; // set the number of records to display per page
    $view = $staffbmis->view_inventory_expire();
    // $view = $staffbmis->view_low_inventory($page, $recordsPerPage);
    $totalRecords = $staffbmis->count_low_inventory(); // get the total number of records

// Calculate the total number of pages
    $totalPages = ceil($totalRecords / $recordsPerPage);
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

<!-- Begin Page Content -->

<div class="container-fluid page-container">

    <!-- Page Heading -->

    
    
    <div class="row">
        <div class="col-md-6"><h4 class="mb-4">Expiring Item</h4></div>
    </div>

    <div class="row"> 
        <div class="col-md-12">
           <table class="table table-hover text-center table-bordered">
                <form action="" method="post">
                    <thead style="background: #0296be;color:#fff;"> 
                        <tr>
                            <th> Type </th>
                            <th> Picture </th>
                            <th> Product Name </th>
                            <th> Price </th>
                            <th> Quantity </th>
                            <th> Category </th>
                            <th> Date Created </th>
                            <th> Actions </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if(is_array($view)) {?>
                            <?php foreach($view as $view) {?>
                                <tr>
                                <td> <?= $view['type'];?> </td>
                                <td>
                                    <?php if (is_null($view['picture'])): ?>
                                        <img id="blah" src="../assets/placeholder/item-placeholder.png" width="50" alt="Item Picture" width="150">
                                    <?php else: ?>
                                        <img src="<?= $view['picture'] ?>" class="img-fluid" alt="Modal Image" style="width: 50px; height:50px;">
                                        <?php endif; ?>
                                    </td>
                                    <td> <?= strlen($view['name']) > 20 ? substr($view['name'], 0, 20) . '...' : $view['name']; ?> </td>
                                    <td>₱ <?= $view['price'];?> </td>
                                    <td> <?= $view['quantity'];?> </td>
                                    <td> <?= $view['category'] ? $view['category'] : 'N/A' ;?> </td>
                                    <td> <?= date("F d, Y", strtotime($view['created_at'])); ?> </td>
                                    <td>    
                                        <form action="" method="post">
                                            <a href="update_low_inventory_form.php?inv_id=<?= $view['inv_id'];?>" style="padding:5px; font-size: 15px; border-radius:5px; margin-bottom: 2px;" class="btn btn-success"> Add Stocks </a>
                                            <input type="hidden" name="inv_id" value="<?= $view['inv_id'];?>">
                                           
                                        </form>
                                    </td>
                                </tr>
                            <?php }?>
                        <?php } ?>
                    </tbody>
                </form>
            </table>
            <!-- Pagination links -->
        <!-- Pagination links -->
<!-- <ul class="pagination justify-content-center">

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
</ul> -->

        </div>
    </div>
</div>
<!-- End of Main Content -->

<?php 
    include('dashboard_sidebar_end.php');
?>
