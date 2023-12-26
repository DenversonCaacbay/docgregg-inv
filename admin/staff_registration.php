<?php 
     require('../classes/staff.class.php');
    $residentbmis->create_staff();
    //  $data = $bms->get_userdata();

     
?>

<!DOCTYPE html> 
<html> 
    <head> 
        <title> Barangay Santa Rita Management System </title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modalmanager.min.js" integrity="sha512-/HL24m2nmyI2+ccX+dSHphAHqLw60Oj5sK8jf59VWtFWZi9vx7jzoxbZmcBeeTeCUc7z1mTs3LfyXGuBU32t+w==" crossorigin="anonymous"></script>
        <!-- responsive tags for screen compatibility -->
        <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
        <!-- bootstrap css --> 
        <link href="../BarangaySystem/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"> 
        <!-- fontawesome icons -->
        <script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>
    </head>

    <style>
        
        .field-icon {
        margin-left: 74%;
        margin-top: -8%;
        position: absolute;
        z-index: 2;
        }

    </style>
    
    <body >

        <!-- eto yung navbar -->
        <nav class="navbar navbar-dark bg-primary sticky-top">
            <a class="navbar-brand" style="color: white;">Barangay Santa Rita Information & E-Servicesㅤㅤㅤㅤㅤㅤㅤㅤㅤ</a>
        </nav>

        <div class="container-fluid"  style="margin-top: 4em;">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center">Registration Form</h1>
                    <br>
                </div>
            </div>

            <div class="row margin mtop"> 
                <div class="col-sm"> </div>

                <div class="col-sm-8">
                    <div class="card mbottom" style="margin-bottom: 3em;">
                        <div class="card-body">
                            <form method="post" enctype='multipart/form-data' class="was-validated">

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Last Name: </label>
                                            <input type="text" class="form-control" name="lname" placeholder="Enter Last Name" value="<?php echo isset($_POST['lname']) ? htmlspecialchars($_POST['lname']) : ''; ?>" required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label class="mtop">First Name: </label>
                                            <input type="text" class="form-control" name="fname" placeholder="Enter First Name" value="<?php echo isset($_POST['fname']) ? htmlspecialchars($_POST['fname']) : ''; ?>" required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label class="mtop">Middle Name: </label>
                                            <input type="text" class="form-control" name="mi" placeholder="Enter Middle Name" value="<?php echo isset($_POST['mi']) ? htmlspecialchars($_POST['mi']) : ''; ?>" required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="mtop">Contact Number:</label>
                                            <input type="tel" class="form-control" name="contact" maxlength="11" pattern="[0-9]{11}" placeholder="Enter Contact Number" value="<?php echo isset($_POST['contact']) ? htmlspecialchars($_POST['contact']) : ''; ?>" required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label>Email: </label>
                                            <input type="email" class="form-control" name="email" placeholder="Enter Email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label>Password:</label>
                                            <input type="password" class="form-control" id="password-field" name="password" placeholder="Enter Password" required>
                                            <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label>Confirm Password:</label>
                                            <input type="password" class="form-control" id="confirm-password-field" name="confirm_password" placeholder="Enter Confirm Password" required>
                                            <span toggle="#confirm-password-field" class="fa fa-fw fa-eye field-icon toggle-confirm-password"></span>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label> House No: </label>
                                            <input type="text" class="form-control" name="houseno" placeholder="Enter House No." value="<?php echo isset($_POST['houseno']) ? htmlspecialchars($_POST['houseno']) : ''; ?>" required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label> Street: </label>
                                            <input type="text" class="form-control" name="street" placeholder="Enter Street" value="<?php echo isset($_POST['street']) ? htmlspecialchars($_POST['street']) : ''; ?>" required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label> Barangay: </label>
                                            <input type="text" class="form-control" name="brgy" placeholder="Enter Barangay" value="<?php echo isset($_POST['brgy']) ? htmlspecialchars($_POST['brgy']) : ''; ?>" required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label> Municipality: </label>
                                            <input type="text" class="form-control" name="municipal" placeholder="Enter Municipality" value="<?php echo isset($_POST['municipal']) ? htmlspecialchars($_POST['municipal']) : ''; ?>" required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="mtop">Birth Date: </label>
                                            <input type="date" class="form-control" name="bdate" value="<?php echo isset($_POST['bdate']) ? htmlspecialchars($_POST['bdate']) : ''; ?>" required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label class="mtop">Birth Place </label>
                                            <input type="text" class="form-control" name="bplace" placeholder="Enter Birth Place" value="<?php echo isset($_POST['bplace']) ? htmlspecialchars($_POST['bplace']) : ''; ?>" required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label class="mtop">Nationality: </label>
                                            <input type="text" class="form-control" name="nationality" placeholder="Enter Nationality" value="<?php echo isset($_POST['nationality']) ? htmlspecialchars($_POST['nationality']) : ''; ?>" required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Status: </label>
                                            <select class="form-control" name="status" id="status" required>
                                                <option value="" <?php echo empty($_POST['status']) ? 'selected' : ''; ?>>Choose your Status</option>
                                                <option value="Single">Single</option>
                                                <option value="Married">Married</option>
                                                <option value="Widowed">Widowed</option>
                                                <option value="Divorced">Divorced</option>
                                            </select>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>

                                    <!-- <div class="col">
                                        <div class="form-group">
                                            <label>Age</label>
                                            <input type="number" class="form-control" name="age" placeholder="Enter Age" value="<?php echo isset($_POST['age']) ? htmlspecialchars($_POST['age']) : ''; ?>" required>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div> -->

                                    <div class="col rb">
                                        <div class="form-group">
                                            <label class="mtop">Sex</label>
                                            <select class="form-control" name="sex" id="sex" required>
                                                <option value="" <?php echo empty($_POST['sex']) ? 'selected' : ''; ?>>Choose your Sex</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col">
                                        <div class="form-group">
                                            <label>Are you a registered voter? </label>
                                            <select class="form-control" name="voter" id="regvote" required>
                                                <option value="" <?php echo empty($_POST['voter']) ? 'selected' : ''; ?>>...</option>
                                                <option value="Yes" >Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label>Are you head of the family? </label>
                                            <select class="form-control" name="family_role" id="famhead" required>
                                                <option value="" <?php echo empty($_POST['family_role']) ? 'selected' : ''; ?>>...</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                            <div class="valid-feedback">Valid.</div>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </div>

                                </div>

                                <br>

                                <input type="hidden" class="form-control" name="role" value="resident">
                                <a style="width: 130px; margin-left:35%;" class="btn btn-danger" href="index.php"> Back to Login</a>
                                <button style="width: 130px;" class="btn btn-primary" type="submit" name="add_resident"> Submit </button>

                            </form>
                        </div>
                    </div>
                </div>

                
                <div class="col-sm"> </div>
            </div>
        </div>

        <!-- Footer -->

        <footer id="footer" class="bg-primary text-white d-flex-column text-center">

            <!--Copyright-->

            <div class="py-3 text-center">
                Copyright
                <script>
                document.write(new Date().getFullYear())
                </script> 
                BI & ESMS 
            </div>

        </footer>

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

        <script src="../BarangaySystem/bootstrap/js/bootstrap.bundle.js" type="text/javascript"> </script>
    </body>
</html>

