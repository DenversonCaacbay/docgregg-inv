<?php 
    require('classes/resident.class.php');
    // $residentbmis->create_user();
    $userdetails = $bmis->get_userdata();
    $residentbmis->create_pet($userdetails['id_user']);
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
                <!-- css -->
        <link href="../css/custom.css" rel="stylesheet" type="text/css">
    </head>

    <style>
    
        .form-control{
            height:50px;
        }
        body::-webkit-scrollbar { 
            display: none;  /* Safari and Chrome */
        }


    </style>
    
    <body >

        <!-- eto yung navbar -->
        <nav class=" navbar sticky-top py-3 navbar-expand-lg navbar-dark">
            <a class="mx-auto" style="text-decoration: none;color: #fff;padding: 10px;" href="#">Add your Pet</a>
        </nav>

        <div class="container"  style="margin-top: 1em;">
            
                <div class="card" style="margin-bottom: 3em;">     
                    <form method="post" enctype='multipart/form-data' class=" mt-1 p-2">                
                        <!-- <label>Item Picture:</label> -->
                        <div class="row">
                            <div class="col">
                                <div class="custom-file form-group">
                                    <img id="blah" src="images/placeholder/item-placeholder.png" class="img-size" alt="Pet Picture">
                                    <input type="file" onchange="readURL(this);" value="<?= $item['pet_picture']?>" class="custom-file-input" id="customFile" name="pet_picture">
                                    <label class="custom-file-label" for="customFile">Choose File Photo</label>
                                <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                            </div>
                        </div>
                        <br><br>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label> Pet Name: </label>
                                    <input type="text" class="form-control" name="pet_name" required>
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col">
                                <input type="submit" class="btn btn-primary" name="add_pet" value="Submit"/>
                                <a class="btn btn-danger" href="user_pet.php"> Back to Pets</a>
                            </div>
                        </div>
                    </form>
                </div>
            
        </div>
    </body>
</html>

