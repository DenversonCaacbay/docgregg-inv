<?php
    ini_set('display_errors',0);
    error_reporting(E_ALL ^ E_WARNING);
    require('../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $bmis->validate_admin();
    $view = $staffbmis->view_user();
    // $staffbmis->create_staff();
    // $upstaff = $staffbmis->update_staff();
    // $staffbmis->delete_staff();
    $staffcount = $staffbmis->count_user();
    

?>

<?php 
    include('dashboard_sidebar_start.php');
?>

<!-- Begin Page Content -->

<div class="container-fluid">

    <!-- Page Heading -->

    <h1 class="mb-4">Client List</h1>
    <!-- <button class="btn btn-primary">Add Item</button> -->

    <hr>

    <div class="row"> 
        <div class="col-md-12">
           <table class="table table-hover text-center table-bordered">
                <form action="" method="post">
                    <thead style="background: #0296be;color:#fff;"> 
                        <tr>
                            <th> Picture </th>
                            <th> First Name </th>
                            <th> Middle Name </th>
                            <th> Last Name </th>
                            <th> Sex </th>
                            <th> Address </th>
                            <th> Actions </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if(is_array($view)) {?>
                            <?php foreach($view as $view) {?>
                                <tr>
                                <td>
                                    <?php if (is_null($view['picture'])): ?>
                                        <span>No Picture</span>
                                    <?php else: ?>
                                        <img src="<?= $view['picture'] ?>" class="img-fluid" alt="Modal Image">
                                        <?php endif; ?>
                                    </td>
                                    <td> <?= $view['fname'];?> </td>
                                    <td><?= $view['mi'];?> </td>
                                    <td> <?= $view['lname'];?> </td>
                                    <td> <?= $view['sex'];?> </td>
                                    <td> <?= $view['address'];?> </td>
                                    <td>    
                                        <form action="" method="post">
                                            <a href="update_inventory_form.php?id_user=<?= $view['id_admin'];?>" style="width: 100px;padding:5px; font-size: 15px; border-radius:5px; margin-bottom: 2px;" class="btn btn-success"> View Record </a>
                                            <a href="update_inventory_form.php?id_user=<?= $view['id_admin'];?>" style="width: 100px;padding:5px; font-size: 15px; border-radius:5px; margin-bottom: 2px;" class="btn btn-success"> View Pets </a>
                                            <input type="hidden" name="id_user" value="<?= $view['id_admin'];?>">
                                            <!-- <button class="btn btn-danger" type="submit" name="delete_user"style="width: 70px;padding:5px; font-size: 15px; border-radius:5px;"> Remove </button> -->
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
