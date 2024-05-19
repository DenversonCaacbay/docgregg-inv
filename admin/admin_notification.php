<?php
    ini_set('display_errors',0);
    error_reporting(E_ALL ^ E_WARNING);
    require('../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $user = $staffbmis->view_single_staff($userdetails['id_admin']);
    $bmis->validate_admin();
    
    
//     $page = isset($_GET['page']) ? $_GET['page'] : 1;
// $recordsPerPage = 10; // set the number of records to display per page
// $view = $staffbmis->view_inventory($page, $recordsPerPage);
// $totalRecords = $staffbmis->count_inventory(); // get the total number of records

// Calculate the total number of pages
// $totalPages = ceil($totalRecords / $recordsPerPage);
    // $staffbmis->create_staff();
    // $upstaff = $staffbmis->update_staff();
    // $staffbmis->delete_staff();
    // $staffcount = $staffbmis->count_inventory();
    $staffbmis->delete_invetory();

    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $recordsPerPage = 3; // set the number of records to display per page
    $view = $staffbmis->view_low_inventory($page, $recordsPerPage);
    $view_exp = $staffbmis->view_inventory_expire();
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
        <div class="col-md-6"><h4 class="mb-4">Low Inventory</h4></div>
        <div class="col-md-6"><h4 class="mb-4">Expiring Items</h4></div>
    </div>

    <div class="row"> 
        <div class="col-md-6">
           <table class="table table-hover text-center table-bordered">
                <form action="" method="post">
                    <thead style="background: #0296be;color:#fff;"> 
                        <tr>
                            <th> Type </th>
                            <th> Picture </th>
                            <th> Product Name </th>
                            <th hidden> Price </th>
                            <th> Quantity </th>
                            <th hidden> Category </th>
                            <th hidden> Date Created </th>
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
                                        <img id="blah" src="../assets/placeholder/item-placeholder.png" style="width: 30px; height:30px;" alt="Item Picture">
                                    <?php else: ?>
                                        <img src="<?= $view['picture'] ?>" class="img-fluid" alt="Modal Image" style="width: 30px; height:30px;">
                                        <?php endif; ?>
                                    </td>
                                    <td> <?= strlen($view['name']) > 20 ? substr($view['name'], 0, 20) . '...' : $view['name']; ?> </td>
                                    <td hidden>₱ <?= $view['price'];?> </td>
                                    <td> <?= $view['quantity'];?> </td>
                                    <td hidden> <?= $view['category'] ? $view['category'] : 'N/A' ;?> </td>
                                    <td hidden> <?= date("F d, Y", strtotime($view['created_at'])); ?> </td>
                                    <td>    
                                        <form action="" method="post">
                                            <a href="update_low_inventory_form.php?inv_id=<?= $view['inv_id'];?>" style="padding:5px; font-size: 12px; border-radius:5px; margin-bottom: 2px;" class="btn btn-success"> Add Stocks </a>
                                            <input type="hidden" name="inv_id" value="<?= $view['inv_id'];?>">
                                           
                                        </form>
                                    </td>
                                </tr>
                            <?php }?>
                        <?php } ?>
                    </tbody>
                </form>
            </table>
        </div>
        <div class="col-md-6">
        <table class="table table-hover text-center table-bordered">
                <form action="" method="post">
                    <thead style="background: #0296be;color:#fff;"> 
                        <tr>
                            <th> Type </th>
                            <th> Picture </th>
                            <th> Product Name </th>
                            <th hidden> Price </th>
                            <th hidden> Quantity </th>
                            <th hidden> Category </th>
                            <th hidden> Date Created </th>
                            <th> Expiration Date </th>
                            <th> Deduct Item </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if(is_array($view_exp)) {?>
                            <?php foreach($view_exp as $view_exp) {?>
                                <tr>
                                <td> <?= $view_exp['type'];?> </td>
                                <td>
                                    <?php if (is_null($view_exp['picture'])): ?>
                                        <img id="blah" src="../assets/placeholder/item-placeholder.png" width="50" alt="Item Picture" width="150">
                                    <?php else: ?>
                                        <img src="<?= $view_exp['picture'] ?>" class="img-fluid" alt="Modal Image" style="width: 50px; height:50px;">
                                        <?php endif; ?>
                                    </td>
                                    <td> <?= strlen($view_exp['name']) > 20 ? substr($view_exp['name'], 0, 20) . '...' : $view_exp['name']; ?> </td>
                                    <td hidden>₱ <?= $view_exp['price'];?> </td>
                                    <td hidden> <?= $view_exp['quantity'];?> </td>
                                    <td hidden> <?= $view_exp['category'] ? $view_exp['category'] : 'N/A' ;?> </td>
                                    <td hidden> <?= date("F d, Y", strtotime($view_exp['created_at'])); ?> </td>
                                    <td> <?= date("F d, Y", strtotime($view_exp['expired_at'])); ?> </td>
                                    <td>    
                                        <form action="" method="post">
                                            <input type="hidden" name="inv_id" value="<?= $view_exp['inv_id'];?>">
                                            <a href="report_page.php?inv_id=<?= $view_exp['inv_id'];?>" style="padding:5px; font-size: 15px; border-radius:5px; margin-bottom: 2px;" class="btn btn-success"> Report Item </a>
                                           
                                        </form>
                                    </td>
                                </tr>
                            <?php }?>
                        <?php } ?>
                    </tbody>
                </form>
            </table>
        </div>
    </div>
</div>
<!-- End of Main Content -->

<?php 
    include('dashboard_sidebar_end.php');
?>
