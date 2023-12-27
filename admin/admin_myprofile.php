<?php
    
    error_reporting(E_ALL ^ E_WARNING);
    ini_set('display_errors',0);
    require('../classes/resident.class.php');
    $userdetails = $bmis->get_userdata();
    // $bmis->validate_admin();
    // $bmis->delete_brgyid();
    // $view = $bmis->view_brgyid();
    // $id_resident = $_GET['id_resident'];
    // $resident = $residentbmis->get_single_certofres($id_resident);
   
?>

<?php 
    include('dashboard_sidebar_start.php');
?>

<style>
    .input-icons i {
        position: absolute;
    }
        
    .input-icons {
        width: 30%;
        margin-bottom: 10px;
        margin-left: 34%;
    }
        
    .icon {
        padding: 10px;
        min-width: 40px;
    }
    .form-control{
        text-align: center;
    }
</style>

<!-- Begin Page Content -->

<div class="container-fluid">

    <!-- Page Heading -->

    <div class="row"> 
        <div class=""> 
            <h1> My Profile</h1>
        </div>
    </div>

    <br><br>

    <div class="row"> 
        
    </div>

    <br>

    <div class="row"> 
       
    </div>
    
    <!-- /.container-fluid -->
    
</div>
<!-- End of Main Content -->

<?php 
    include('dashboard_sidebar_end.php');
?>
