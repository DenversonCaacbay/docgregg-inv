<?php 
    error_reporting(E_ALL ^ E_WARNING);
    require('classes/resident.class.php');
    ini_set('display_errors',0);
    $userdetails = $residentbmis->get_userdata();
    // $id_user = $_GET['id_user'];

    $id_resident = $userdetails['id_user'];
    $resident = $residentbmis->get_single_resident($id_user);
    // $low_items = $residentbmis->view_low_inventory();
    $view = $residentbmis->view_recent($id_resident);
    // print_r($low_items);
    
    // print_r($view);
    $residentbmis->profile_update();

?>

<style>
        body::-webkit-scrollbar { 
            display: none;  /* Safari and Chrome */
        }
</style>
<?php 
    include('user_navbar_start.php');
?>



<div class="container">
    <div class="card bgcard border-0 mt-5 p-3">
    <h4 class="text-light">Recent Vaccinated</h4>
    <?php if(is_array($view) && count($view) > 0): ?>
    <?php foreach($view as $item): ?>
        <div class="card border-0 p-2 ">
            <div class="row">
                <div class="col-md-12">
                    <h5>Pet Name: <?= $item['pet_name']; ?></h5>
                    <h5>Pet Condition: </h5>
                    <h5>Vaccine Taken </h5>
                    <h5>Next Vaccination: </h5>
                    <h5>Date Vaccinated: <?= date("F d, Y - l", strtotime($item['created_at'])); ?></h5>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No data available.</p>
<?php endif; ?>

    </div>
    
    <div class="row mt-3"> 
        <div class="col-md-12">

                                    </div>
                                    </div>
</div>
    
    
