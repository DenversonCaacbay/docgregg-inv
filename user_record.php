<?php 
    error_reporting(E_ALL ^ E_WARNING);
    require('classes/resident.class.php');
    ini_set('display_errors',0);
    $userdetails = $residentbmis->get_userdata();
    $id_resident = $_GET['id_user'];
    $resident = $residentbmis->get_single_resident($id_resident);
    

    $residentbmis->profile_update();

?>

<style>

</style>

<?php 
    include('user_navbar_start.php');
?>
    <div class="container">
        <div class="row mt-2">
            <div class="col-md-6"><div class="title">Vaccination Records</div></div>
            <div class="col-md-6">
                <div class="desk-create">
                    <a class="btn btn-primary text-light" href="create_user_vaccination.php">Add Vaccination Certificate</a>
                </div>
            </div>
        </div>
    </div>

