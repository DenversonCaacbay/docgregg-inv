<?php 
     require('classes/resident.class.php');
    $residentbmis->create_user();
     //$data = $bms->get_userdata();

     
?>

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
        
        .field-icon {
        margin-left: 81%;
        margin-top: -5.5%;
        position: absolute;
        z-index: 2;
        }
        .form-control{
            height:50px;
        }
        body::-webkit-scrollbar { 
            display: none;  /* Safari and Chrome */
        }
        body{
            background: rgb(255,255,255);
            background: linear-gradient(180deg, rgba(255,255,255,1) 42%, rgba(2,150,190,1) 100%);
        }

    </style>
    
    <body >

        <!-- eto yung navbar -->
        <nav class="navbar sticky-top py-3 navbar-expand-lg navbar-dark">
            <a class="mx-auto" style="text-decoration:none;color: #fff;font-size: 20px; font-weight: 600;" href="#">Registration Form</a>
        </nav>

        <div class="container">

            <div class="row mt-3"> 

                <div class="col-sm-12">
                    <div class="card col-lg-12">
                        
                            <form method="post" enctype='multipart/form-data' class="row g-2 p-2 form-style was-validated">
                                
                                    <div class="col-md-4">
                                      <div class="form-group">
                                            <label>Last Name: </label>
                                            <input type="text" class="form-control" name="lname" placeholder="Enter Last Name" value="<?php echo isset($_POST['lname']) ? htmlspecialchars($_POST['lname']) : ''; ?>" required>
                                            <!-- <div class="valid-feedback">Valid.</div> -->
                                            <!-- <div class="invalid-feedback">Please fill out this field.</div> -->
                                        </div>  
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>First Name: </label>
                                            <input type="text" class="form-control" name="fname" placeholder="Enter First Name" value="<?php echo isset($_POST['fname']) ? htmlspecialchars($_POST['fname']) : ''; ?>" required>
                                            <!-- <div class="valid-feedback">Valid.</div> -->
                                            <!-- <div class="invalid-feedback">Please fill out this field.</div> -->
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Middle Name: </label>
                                            <input type="text" class="form-control" name="mi" placeholder="Enter Middle Name" value="<?php echo isset($_POST['mi']) ? htmlspecialchars($_POST['mi']) : ''; ?>" required>
                                            <!-- <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div> -->
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Contact Number:</label>
                                            <input type="tel" class="form-control" name="contact" maxlength="11" pattern="[0-9]{11}" placeholder="Enter Contact Number" value="<?php echo isset($_POST['contact']) ? htmlspecialchars($_POST['contact']) : ''; ?>" required>
                                            <!-- <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div> -->
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email: </label>
                                            <input type="email" class="form-control" name="email" placeholder="Enter Email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                                            <!-- <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div> -->
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Password:</label>
                                            <input type="password" class="form-control" id="password-field" name="password" placeholder="Enter Password" required>
                                            <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                            <!-- <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div> -->
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Confirm Password:</label>
                                            <input type="password" class="form-control" id="confirm-password-field" name="confirm_password" placeholder="Enter Confirm Password" required>
                                            <span toggle="#confirm-password-field" class="fa fa-fw fa-eye field-icon toggle-confirm-password"></span>
                                            <!-- <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div> -->
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label> Address: </label>
                                            <input type="text" class="form-control" name="address" placeholder="Enter Address" value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?>" required>
                                            <!-- <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div> -->
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="mtop">Birth Date: </label>
                                            <input type="date" class="form-control" name="bdate" value="<?php echo isset($_POST['bdate']) ? htmlspecialchars($_POST['bdate']) : ''; ?>" required>
                                            <!-- <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div> -->
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="mtop">Nationality: </label>
                                            <input type="text" class="form-control" name="nationality" placeholder="Enter Nationality" value="<?php echo isset($_POST['nationality']) ? htmlspecialchars($_POST['nationality']) : ''; ?>" required>
                                            <!-- <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div> -->
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="mtop">Sex</label>
                                            <select class="form-control" name="sex" id="sex" required>
                                                <option value="" <?php echo empty($_POST['sex']) ? 'selected' : ''; ?>>Choose your Sex</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                            <!-- <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div> -->
                                        </div>
                                    </div>
    
                                <br>
                                <button class="btn btn-primary" type="submit" name="add_user"> Create an Account </button>
                                <input type="hidden" class="form-control" name="role" value="resident">
                                <a class="btn btn-danger" href="index.php"> Back to Login</a>
                                

                            </form>
                     
                    </div>
                </div>
            </div>
        </div>


        <script>
            $(".toggle-password").click(function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
            input.attr("type", "text");
            } else {
            input.attr("type", "password");
            }
            });

            $(".toggle-confirm-password").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
        </script>

        <!-- <script src="../BarangaySystem/bootstrap/js/bootstrap.bundle.js" type="text/javascript"> </script> -->
    </body>
</html>

