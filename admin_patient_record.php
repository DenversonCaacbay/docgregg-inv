<?php
    ini_set('display_errors',0);
    error_reporting(E_ALL ^ E_WARNING);
    require('classes/staff.class.php');
    $userdetails = $bmis->get_userdata();
    $bmis->validate_admin();
    $view = $staffbmis->view_staff();
    $staffbmis->create_staff();
    $upstaff = $staffbmis->update_staff();
    $staffbmis->delete_staff();
    $staffcount = $staffbmis->count_staff();
    
?>

<?php 
    include('dashboard_sidebar_start.php');
?>
<!-- Begin Page Content -->

<div class="container-fluid">

    <!-- Page Heading -->

    <h1 class="mb-4">Patient Record</h1>

    <hr>

    <div class="row"> 
        <div class="col-md-12">
           <table class="table table-hover text-center table-bordered table-responsive" id="dataTable" width="100%" cellspacing="0">
                <form action="" method="post">
                    <thead class="alert-info"> 
                        <tr>
                            <th> Actions </th>
                            <th> Email </th>
                            <th> Surname </th>
                            <th> First name </th>
                            <th> Middle Name </th>
                            <th> Role </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if(is_array($view)) {?>
                            <?php foreach($view as $view) {?>
                                <tr>
                                    <td>    
                                        <form action="" method="post">
                                            <a href="update_staff_form.php?id_user=<?= $view['id_admin'];?>" style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;" class="btn btn-success"> Update </a>
                                            <input type="hidden" name="id_user" value="<?= $view['id_admin'];?>">
                                            <button class="btn btn-danger" type="submit" name="delete_staff"style="width: 90px; font-size: 17px; border-radius:30px;"> Archive </button>
                                        </form>
                                    </td>
                                    <td> <?= $view['email'];?> </td>
                                    <td> <?= $view['lname'];?> </td>
                                    <td> <?= $view['fname'];?> </td>
                                    <td> <?= $view['mi'];?> </td>
                                    <td> <?= $view['role'];?> </td>
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