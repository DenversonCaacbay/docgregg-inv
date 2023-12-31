<?php 
//      require('classes/resident.class.php');
//     $residentbmis->create_user();
//      //$data = $bms->get_userdata();

require('classes/resident.class.php');
// $residentbmis->create_user();
$userdetails = $bmis->get_userdata();
$residentbmis->create_vaccination_record($userdetails['id_user']);
    // print_r($userdetails['id_user']);
// ?>

<!DOCTYPE html> 
<html> 
    <head> 
        <title> Doc Gregg Veterinary Clinic </title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modalmanager.min.js" integrity="sha512-/HL24m2nmyI2+ccX+dSHphAHqLw60Oj5sK8jf59VWtFWZi9vx7jzoxbZmcBeeTeCUc7z1mTs3LfyXGuBU32t+w==" crossorigin="anonymous"></script>
        <!-- responsive tags for screen compatibility -->
        <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
        <!-- bootstrap css --> 
        <link href="css/user.css" rel="stylesheet" type="text/css"> 
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <!-- fontawesome icons -->
        <script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>
    </head>

    <style>
    
        .form-control{
            height:50px;
        }
        body::-webkit-scrollbar { 
            display: none;  /* Safari and Chrome */
        }
/* 
        .custom-file {
            position: relative;
        /* } */

         /* .custom-file img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            cursor: pointer;
        }  */


    </style>
    
<body >

        <!-- eto yung navbar -->
<nav class=" navbar sticky-top py-3 navbar-expand-lg navbar-dark">
    <a class="mx-auto" style="text-decoration: none;color: #fff;padding: 10px;" href="#">Add Vaccination Certificate</a>
</nav>

<div class="container"  style="margin-top: 12em;">       
    <div class="card p-3" style="margin-bottom: 3em;">     
        <form method="post" enctype='multipart/form-data' class="mt-1 p-2">
            <div class="row">
                <div class="col">
                    <div class="custom-file form-group">
                        <label for="customFile">Item Picture:</label>
                        <div class="d-flex align-items-center flex-column mb-2">
                            <img id="blah" src="images/placeholder/item-placeholder.png" class="img-thumbnail" style="margin-top:-200px;" width="150" alt="VaccinePicture">
                            <input type="file" onchange="readURL(this);" value="<?= $item['vac_picture']?>" class="custom-file-input" id="customFile" name="vac_picture">
                            <label class="custom-file-label" for="customFile">Choose File Photo</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col mt-3">
                    <div class="form-group">
                        <label for="pet_name">Pet Name:</label>
                        <input type="text" class="form-control" name="pet_name" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <button class="btn btn-primary w-100" type="submit" name="add_vac">Submit</button>
                    <input type="hidden" class="form-control" name="role" value="resident">
                    <a class="btn btn-danger w-100 mt-3" href="user_record.php">Back to Records</a>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>

