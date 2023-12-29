<?php 
    error_reporting(E_ALL ^ E_WARNING);
    require('classes/resident.class.php');
    ini_set('display_errors',0);
    $userdetails = $residentbmis->get_userdata();
    $id_resident = $_GET['id_user'];
    $resident = $residentbmis->get_single_resident($id_resident);
    

    $residentbmis->profile_update();

?>

<?php 
    include('user_navbar_start.php');
?>
    <div class="container">
        <div class="card mt-5 p-2">
           ONGOING
        </div>
        <div class="card mt-3 p-2">
            
        </div>
    </div>

