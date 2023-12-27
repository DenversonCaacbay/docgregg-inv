<?php
    ini_set('display_errors',0);
    error_reporting(E_ALL ^ E_WARNING);
    require('../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $bmis->validate_admin();
    $view = $staffbmis->view_inventory();
    // $staffbmis->create_staff();
    // $upstaff = $staffbmis->update_staff();
    // $staffbmis->delete_staff();
    $staffcount = $staffbmis->count_inventory();
    $staffbmis->delete_invetory();
    

?>

<?php 
    include('dashboard_sidebar_start.php');
?>

<!-- Begin Page Content -->

<div class="container-fluid">

    <!-- Page Heading -->

    
    
    <div class="row">
        <div class="col-md-6"><h1 class="mb-4">Inventory</h1></div>
        <div class="col-md-6"><a href="create_inventory.php" style="float:right;padding: 10px" class="btn btn-primary">Add Item</a></div>
    </div>
    <hr>

    <div class="row"> 
        <div class="col-md-12">
           <table class="table table-hover text-center table-bordered">
                <form action="" method="post">
                    <thead style="background: #0296be;color:#fff;"> 
                        <tr>
                            <th> Picture </th>
                            <th> Product Name </th>
                            <th> Price </th>
                            <th> Quantity </th>
                            <th> Date Created </th>
                            <th> Actions </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if(is_array($view)) {?>
                            <?php foreach($view as $view) {?>
                                <tr>
                                <td>
                                    <?php if (is_null($view['picture'])): ?>
                                        <img id="blah" src="../images/placeholder/item-placeholder.png" class="img-size" alt="Pet Picture">
                                    <?php else: ?>
                                        <img src="<?= $view['picture'] ?>" class="img-fluid img-size" alt="Modal Image">
                                        <?php endif; ?>
                                    </td>
                                    <td> <?= $view['name'];?> </td>
                                    <td>P<?= $view['price'];?> </td>
                                    <td> <?= $view['quantity'];?> </td>
                                    <td> <?= date("F d, Y - l", strtotime($view['created_at'])); ?> </td>
                                    <td>    
                                        <form action="" method="post">
                                            <a href="update_inventory_form.php?inv_id=<?= $view['inv_id'];?>" style="width: 70px;padding:5px; font-size: 15px; border-radius:5px; margin-bottom: 2px;" class="btn btn-success"> Update </a>
                                            <input type="hidden" name="inv_id" value="<?= $view['inv_id'];?>">
                                            <button class="btn btn-danger" type="submit" name="delete_inventory"style="width: 70px;padding:5px; font-size: 15px; border-radius:5px;"  onclick="return confirm('Are you sure you want to remove this data?')"> Remove </button>
                                        </form>
                                    </td>

                                    <!-- <td>    
                                        <form action="" method="post">
                                            <a href="update_staff_form.php?id_user=<?= $view['id_admin'];?>" style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;" class="btn btn-success"> Update </a>
                                            <input type="hidden" name="id_user" value="<?= $view['id_admin'];?>">
                                            <button class="btn btn-danger" type="submit" name="delete_staff"style="width: 90px; font-size: 17px; border-radius:30px;"> Archive </button>
                                        </form>
                                    </td> -->

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
