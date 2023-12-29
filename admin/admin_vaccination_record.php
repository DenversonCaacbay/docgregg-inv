<?php
    ini_set('display_errors',0);
    error_reporting(E_ALL ^ E_WARNING);
    require('../classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $bmis->validate_admin();
    $view = $staffbmis->view_vaccine_record();
    // $staffbmis->create_staff();
    // $upstaff = $staffbmis->update_staff();
    // $staffbmis->delete_staff();
    $staffcount = $staffbmis->count_vaccine_record();
    
?>

<?php 
    include('dashboard_sidebar_start.php');
?>
<!-- Begin Page Content -->

<div class="container-fluid">

    <!-- Page Heading -->
<div class="row">
    <div class="col-md-6"><h1 class="mb-4">Vaccination Record</h1></div>
    <div class="col-md-6"><a href="create_vaccination_record.php" style="float:right;padding: 10px" class="btn btn-primary">Add Vaccination Record</a></div>
</div>
    
    
    <hr>

    <div class="row"> 
        <div class="col-md-12">
           <table class="table table-hover text-center table-bordered">
                <form action="" method="post">
                    <thead style="background: #0296be;color:#fff;"> 
                        <tr>
                           
                            <th> Pet Owner </th>
                            <th> Pet Name </th>
                            <th> Vaccine Certificate </th>
                            <th> Date Vaccinated </th>
                            <!-- <th> Actions </th> -->
                            
                        </tr>
                    </thead>

                    <tbody>
                        <?php if(is_array($view)) {?>
                            <?php foreach($view as $view) {?>
                                <tr>
                                    
                                    <td> <?= $view['fname'];?> <?= $view['lname'];?></td>
                                    <td> <?= $view['pet_name'];?> </td>
                                    <td>
                                        <?php if (empty($view['vac_certf'])): ?>
                                            <img id="blah" src="../images/placeholder/item-placeholder.png" class="img-size" alt="Item Picture" width="150">
                                        <?php else: ?>
                                            <img src="<?= $view['vac_certf'] ?>" class="img-fluid" alt="Modal Image" width="100">
                                        <?php endif; ?>
                                    </td>
                                    <td> <?= date("F d, Y - l", strtotime($view['date_vaccinated'])); ?> </td>
                                    <!-- <td>    
                                        <form action="" method="post">
                                            <a href="update_vaccination_record_form.php?id_user=<?= $view['id_admin'];?>" style="width: 70px;padding:5px; font-size: 15px; border-radius:5px; margin-bottom: 2px;" class="btn btn-success"> Update </a>
                                            <input type="hidden" name="id_user" value="<?= $view['id_admin'];?>">
                                            <button class="btn btn-danger" type="submit" name="delete_staff"style="width: 70px;padding:5px; font-size: 15px; border-radius:5px;"> Archive </button>
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

<?php 
    include('dashboard_sidebar_end.php');
?>