<?php 
    error_reporting(E_ALL ^ E_WARNING);
    require('classes/resident.class.php');
    ini_set('display_errors',0);
    $userdetails = $residentbmis->get_userdata();
    $id_user = $_GET['id_user'];
    $resident = $residentbmis->get_single_resident($id_user);
    

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
</div>
    
    
