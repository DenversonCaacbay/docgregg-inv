<?php
    
    ini_set('display_errors',0);
    error_reporting(E_ALL ^ E_WARNING);
    require('../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $user = $staffbmis->view_single_staff($userdetails['id_admin']);
    $bmis->validate_admin();
    $view = $staffbmis->view_user();
    $staffbmis->delete_staff();
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
</style>

<!-- Begin Page Content -->

<div class="container-fluid">

    <!-- Page Heading -->

    <div class="row">
        <div class="col-md-6"><h1 class="mb-4">Staff List</h1></div>
    </div>

    <div class="container-fluid mt-3">
    <table class="table table-hover text-center table-bordered mt-3">
                <form action="" method="post">
                    <thead style="background: #0296be;color:#fff;"> 
                        <tr>
                            <th> Picture </th>
                            <th> Staff Name </th>
                            <th> Email</th>
                            <th> Position</th>
                            <th> Role </th>
                            <th> Created at </th>
                            <th> Action </th>
                        </tr>
                    </thead>

                    <tbody>
    <?php 
    $hasAdministrator = false; // Flag to track if there's an administrator
    if(is_array($view)) {
        foreach($view as $user) {
            if ($user['role'] == 'administrator') {
                $hasAdministrator = true; // Set the flag if an administrator is found
                break; // No need to continue checking once an administrator is found
            }
        }

        foreach($view as $user) {
            // If no administrator is found or if the current user is not an administrator, display the row with the "Remove" button
            if (!$hasAdministrator || $user['role'] != 'administrator') {
                ?>
                <tr>
                    <td>
                        <?php if (is_null($user['picture'])): ?>
                            <img id="blah" src="../assets/placeholder/user-placeholder.PNG" class="img-fluid" width="50" height="50" alt="Staff Picture">
                        <?php else: ?>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="openModal('<?= $user['picture'] ?>', '<?= $user['fname'] ?>')">
                                <img src="<?= $user['picture'] ?>" class="img-fluid" alt="Modal Image" width="50">
                            </a>
                        <?php endif; ?>
                    </td>
                    <td><?= $user['fname']; ?> <?= $user['lname']; ?></td>
                    <td><?= $user['email']; ?></td>
                    <td><?= $user['position']; ?></td>
                    <td><?= $user['role']; ?></td>
                    <td><?= $user['created_at']; ?></td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="id_admin" value="<?= $user['id_admin'];?>">
                            <button class="btn btn-danger" type="submit" name="delete_staff" style="width: 70px; padding: 5px; font-size: 15px; border-radius: 5px;" onclick="return confirm('Are you sure you want to remove <?= $user['fname']; ?>?')">Remove</button>
                        </form>
                    </td>
                </tr>
                <?php
            }
        }
    } ?>
</tbody>


                </form>
            </table>
    </div>
    
    <!-- /.container-fluid -->
    
</div>
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
    function openModal(imageSrc, fname) {
        console.log("Opening modal with image source and category:", imageSrc, fname);

        // Assuming modalImage is the ID of your image element in the modal
        document.getElementById('modalImage').src = imageSrc;

        // Assuming modalTitle is the class of your modal title element
        document.querySelector('.modal-title').textContent = fname + '- Picture';
    }
</script>
<!-- End of Main Content -->