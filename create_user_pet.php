<?php 
//      require('classes/resident.class.php');
//     $residentbmis->create_user();
//      //$data = $bms->get_userdata();

     
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

        .navbar{
            background: #312065 !important;
             
        }

    </style>
    
    <body >

        <!-- eto yung navbar -->
        <nav class="navbar sticky-top navbar-expand-lg bg-light">
            <a class="navbar-brand mx-auto" style="color: #fff;font-size: 20px; font-weight: 600;" href="#">Add your Pet</a>
        </nav>

        <div class="container-fluid"  style="margin-top: 1em;">
            
                <div class="card" style="margin-bottom: 3em;">     
                    <form method="post" enctype='multipart/form-data' class=" mt-1 p-2">                
                        <!-- <label>Item Picture:</label> -->
                        <div class="custom-file form-group">
                            <input type="file" onchange="readURL(this);" value="<?= $item['pet_picture']?>" class="custom-file-input" id="customFile" name="pet_picture">
                            <label class="custom-file-label" for="customFile">Choose File Photo</label>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                        <br><br>
                        <div class="col">
                            <div class="form-group">
                                <label> Pet Name: </label>
                                <input type="text" class="form-control" name="pet_name" required>
                            </div>
                        </div>
                        <br>
                        <button class="btn btn-primary" type="submit" name="add_user"> Submit </button>
                        <input type="hidden" class="form-control" name="role" value="resident">
                        <a class="btn btn-danger" href="user_pet.php"> Back to Pets</a>
                    </form>
                </div>
            
        </div>
    </body>
</html>

