<?php
    
    ini_set('display_errors',0);
    error_reporting(E_ALL ^ E_WARNING);
    require('../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
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
                            <th> Role </th>
                            <th> Created at </th>
                            <th> Action </th>
                        </tr>
                    </thead>

                    <tbody>
                    <tbody>
                        <?php if(is_array($view)) {?>
                            <?php foreach($view as $view) {?>
                                <tr>
                                <td>
                                    <?php if (is_null($view['picture'])): ?>
                                        <img id="blah" src="../assets/placeholder/user-placeholder.PNG" class="img-fluid" width="50" height="50" alt="Staff Picture">
                                    <?php else: ?>
            
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="openModal('<?= $view['picture'] ?>', '<?= $view['fname'] ?>')">
                                            <img src="<?= $view['picture'] ?>" class="img-fluid" alt="Modal Image" width="50">
                                        </a>

                                        <?php endif; ?>
                                    </td>

                                    <td> <?= $view['fname']; ?> <?= $view['lname']; ?></td>
                                    <td> <?= $view['email']; ?></td>
                                    <td> <?= $view['role']; ?></td>
                                    <td> <?= $view['created_at']; ?> </td>
                                    <td>
                                        <?php if ($view['role'] == 'administrator') : ?>
                                            <!-- Nothing is displayed if the role is 'administrator' -->
                                        <?php else: ?>
                                            <!-- Display the form if the role is not 'administrator' -->
                                            <form action="" method="post">
                                                <input type="hidden" name="id_admin" value="<?= $view['id_admin'];?>">
                                                <button class="btn btn-primary" type="submit" name="delete_staff" style="width: 70px; padding: 5px; font-size: 15px; border-radius: 5px;" onclick="return confirm('Are you sure you want to remove this staff?')">Remove</button>
                                            </form>
                                        <?php endif; ?>
                                    </td>

                                </tr>
                            <?php }?>
                        <?php } ?>
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