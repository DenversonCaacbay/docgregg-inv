<?php 
    error_reporting(E_ALL ^ E_WARNING);
    require('classes/resident.class.php');
    ini_set('display_errors',0);
    $userdetails = $residentbmis->get_userdata();
    $id_user = $_GET['id_user'];
    $resident = $residentbmis->get_single_resident($id_user);
    $low_items = $residentbmis->view_low_inventory();
    // print_r($low_items);
    

    $residentbmis->profile_update();

?>

<?php 
    include('user_navbar_start.php');
?>


<div class="container">
    <div class="card mt-5 p-2">
        Recent Vaccine
        <h5>Date: January 5, 2024</h5>
    </div>
    <div class="card mt-3 p-2">
        <h4>This List of Vaccines are low on Stocks</h4>
    </div>
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
                        </tr>
                    </thead>

                    <tbody>
                        <?php if(is_array($low_items)) {?>
                            <?php foreach($low_items as $view) {?>
                                <tr>
                                <td>
                                    <?php if (is_null($view['picture'])): ?>
                                        <img id="blah" src="../images/placeholder/item-placeholder.png" class="img-size" alt="Item Picture" width="150">
                                    <?php else: ?>
                                        <img src="<?= $view['picture'] ?>" class="img-fluid" alt="Item Image" width="100">

                                        <?php endif; ?>
                                    </td>
                                    <td> <?= $view['name'];?> </td>
                                    <td>₱ <?= $view['price'];?> </td>
                                    <td> <?= $view['quantity'];?> </td>
                                    <td> <?= date("F d, Y - l", strtotime($view['created_at'])); ?> </td>
                                </tr>
                            <?php }?>
                        <?php } ?>
                    </tbody>
                </form>
            </table>
                                    </div>
                                    </div>
</div>
    
    
