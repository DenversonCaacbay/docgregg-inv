<?php 
    error_reporting(E_ALL ^ E_WARNING);
    require('classes/resident.class.php');
    ini_set('display_errors',1);
    $userdetails = $residentbmis->get_userdata();
    $id_resident = $userdetails['id_user'];
    $resident = $residentbmis->get_single_resident($id_resident);
    // $view = $residentbmis->view_pet($id_resident);
    $view = $residentbmis->view_vaccine_record();
    
    $residentbmis->profile_update();
    // $residentbmis->delete_pet();

?>

<?php 
    include('user_navbar_start.php');
?>

<!-- Begin Page Content -->

<div class="container-fluid">

    <!-- Page Heading -->

    <div class="container">
        <div class="row mt-2">
            <div class="col-md-6"><div class="title">Pet Record</div></div>
        </div>

    <?php if(is_array($view) && count($view) > 0): ?>
    <?php foreach($view as $item): ?>
    <div class="container">
        <div class="card mt-4">
            <div class="card-header bg-primary text-white">Date:  <?=  date("F d, Y - l [g:i:s A]", strtotime($item["created_at"])); ?></div>
           
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h5>Vaccine Taken: <?= $item['vac_used']; ?></h5>
                        <h5>Pet Condition: <?= $item['vac_condition'];?> </h5>
                        <h5>Date Vaccinated:  <?= date("F d, Y - l [g:i:s A]", strtotime($item["created_at"])); ?></h5>
                        <h5>Next Vaccination: <?= $item["vac_next"] = !empty($item["vac_next"]) ? date("F d, Y - l [g:i:s A]", strtotime($item["vac_next"])) : "---"; ?></h5>
                        <form method="POST">
                            <h5>Remarks: 
                                <?php if($item['is_done'] == 0): ?>
                                    Not Yet
                                <?php else: ?>
                                    Done
                                <?php endif; ?>
                            </form>
                        </h5>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <?php endforeach; ?>
    <?php else: ?>
        <p>No data available.</p>
    <?php endif; ?>
    

    
    
    <!-- /.container-fluid -->
    
</div>
<!-- End of Main Content -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modalmanager.min.js" integrity="sha512-/HL24m2nmyI2+ccX+dSHphAHqLw60Oj5sK8jf59VWtFWZi9vx7jzoxbZmcBeeTeCUc7z1mTs3LfyXGuBU32t+w==" crossorigin="anonymous"></script>
<!-- responsive tags for screen compatibility -->
<meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
<!-- custom css --> 
<link href="../BarangaySystem/customcss/regiformstyle.css" rel="stylesheet" type="text/css">
<!-- bootstrap css --> 
<link href="../BarangaySystem/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"> 
<!-- fontawesome icons -->
<script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>
<script src="../BarangaySystem/bootstrap/js/bootstrap.bundle.js" type="text/javascript"> </script>

