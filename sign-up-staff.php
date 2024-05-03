<?php 
 require('classes/resident.class.php');
$residentbmis->create_staff();
 //$data = $bms->get_userdata();
?>

<!DOCTYPE html> 
<html> 
    <head> 
        <title> Doc Gregg Veterinary Clinic </title>
        <!-- responsive tags for screen compatibility -->
        <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
        <!-- custom css --> 
        <link href="css/user.css" rel="stylesheet" type="text/css"> 
        <!-- bootstrap css -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"> 
        <!-- fontawesome icons --> 
        <script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>
        <!-- fontawesome icons --> 
        <script src="../BarangaySystem/customjs/main.js" type="text/javascript"></script>

        <style> 
            body {
                background: rgb(255,255,255);
                background: linear-gradient(180deg, rgba(255,255,255,1) 42%, rgba(2,150,190,1) 100%);
            }
            .login-container{
        padding: 0px 90px;
    }
    .login-container .card{
        border: none;
        margin-top: 20%;
        box-shadow: 0px 10px 13px 0px rgba(0,0,0,0.10);
    }
    .form-floating {
    width: 100%;
    /* padding: 10px; */
    outline: none;
    border: none;
    }
    .form-control {
    width: 100%;
    padding: 10px;
    outline: none;
    border-bottom: 3px #0296be solid;
    border-top: none;
    border-left: none;
    border-right: none;
    border-radius: 0;
    }
    .form-floating:focus {
        outline: none !important;
        outline-color: transparent;
    }
    .input:focus{
        outline: none !important;
        outline-color: transparent;
    }
    .text-primary{
        color: #0296be !important;
    }
            .bg-primary{
                background: #0296be !important;
            }

            .icon {
            padding: 15px;
            background: dodgerblue;
            color: white;
            min-width: 50px;
            text-align: center;
            }

            .input-field {
            width: 100%;
            padding: 10px;
            outline: none;
            }

            .input-field:focus {
            border: 2px solid dodgerblue;
            }

            /* Set a style for the submit button */
            .btn-primary {
                color: white;
                background: #0296be !important;
                padding: 10px 15px;
                border: none;
                cursor: pointer;
                width: 100%;
                opacity: 0.9;
            }
            .btn:hover {
                opacity: 1;
            }
            .banner-text{
                color: #0296be;
            }
        </style>

    </head>



    <body>
    <!-- <nav class="navbar sticky-top py-3 navbar-expand-lg navbar-dark bg-primary">
        <a class="mx-auto" style="text-decoration:none;color: #fff;font-size: 20px; font-weight: 600;" href="#">Registration Form</a>
    </nav> -->

        <!-- This is the heading and card section --> 
        <section >
            <div class="container-fluid login-container">
                <div class="row">
                    <div class="col-md-7 align-content-center">
                        <img src="assets/logo.png" width="150"> 
                        <h3 class="text-primary"> Doc Gregg Veterinary Clinic </h3>
                        <h4><i>"Where Care Meets Comfort"</i></h4>
                        <span>
                        A vet clinic is a compassionate hub
                        dedicated to providing expert medical care
                        and support for beloved pets.
                        </span>
                    </div>
                    <div class="col-md-5 align-items-center">
                        <div class="card p-3"> 
                            <h3 class="text-primary text-center">Sign Up</h3>
                                <form method="post" autocomplete="off"> 
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-floating mt-3">
                                                <input type="text" class="form-control" id="floatingInputInvalid" placeholder="" name="fname" required>
                                                <label for="floatingInputInvalid">First Name</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mt-3">
                                                <input type="text" class="form-control" id="floatingInputInvalid" placeholder="" name="lname" required>
                                                <label for="floatingInputInvalid">Last Name</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-floating mt-3">
                                                <select class="form-select" id="floatingSelect" name="position" aria-label="Floating label select example" required>
                                                    <option selected disabled></option>
                                                    <option value="Groomer">Groomer</option>
                                                    <option value="Assistant Groomer">Assistant Groomer</option>
                                                    <option value="Veterinary Assistant">Veterinary Assistant</option>
                                                </select>
                                                <label for="floatingSelect">Select Position</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-floating mt-3">
                                                <input type="email" class="form-control" id="floatingInputInvalid" placeholder="" autocomplete="off" name="email" required>
                                                <label for="floatingInputInvalid">Email</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mt-3">
                                                <input type="password" class="form-control" id="myInput" placeholder="" autocomplete="off" name="password" required>
                                                <label for="floatingInputInvalid">Password</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mt-3">
                                                <input type="password" class="form-control" id="myInput1" placeholder="" name="confirm_password" required>
                                                <label for="floatingInputInvalid">Confirm Password</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-check form-switch ms-3 mt-3">
                                        <input class="form-check-input" onclick="myFunction()" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                                        <label class="form-check-label" for="flexSwitchCheckDefault">Show Password</label>
                                    </div>
                                    <input type="hidden" name="role" value="Staff">   
                                    <div class="row">
                                        <div class="col-md-6"><a class="btn btn-danger w-100 p-2 mt-3" href="index.php"> Back to Login </a></div>
                                        <div class="col-md-6"><button class="btn btn-primary mt-3" type="submit" name="add_staff"> Register </button></div>         
                                    </div>          
                                    
                                </form>
                                <!-- <div class="registration-section mt-3"> 
                                    <p1> <strong> Register as Staff</strong> </p1> 
                                    <A class="btn btn-primary mt-3" href="sign-up-staff.php"> Create Account </A> 
                                </div> -->
                        </div>
                    </div>
                </div>
            </div>  
            <!-- <div class="container"> 
                <div class="row">
                        <div class="col-md-12"> 
                            <div class="card border-0 main-card mtop"> 
                                <div class="card-body"> 
                                    <form method="post" autocomplete="off">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-floating mt-3">
                                                    <input type="text" class="form-control" id="floatingInputInvalid" placeholder="" name="fname" required>
                                                    <label for="floatingInputInvalid">First Name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mt-3">
                                                    <input type="text" class="form-control" id="floatingInputInvalid" placeholder="" name="lname" required>
                                                    <label for="floatingInputInvalid">Last Name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-floating mt-3">
                                                    <select class="form-select" id="floatingSelect" name="position" aria-label="Floating label select example" required>
                                                        <option selected disabled></option>
                                                        <option value="Groomer">Groomer</option>
                                                        <option value="Assistant Groomer">Assistant Groomer</option>
                                                        <option value="Veterinary Assistant">Veterinary Assistant</option>
                                                    </select>
                                                    <label for="floatingSelect">Select Position</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-floating mt-3">
                                                    <input type="email" class="form-control" id="floatingInputInvalid" placeholder="" autocomplete="off" name="email" required>
                                                    <label for="floatingInputInvalid">Email</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mt-3">
                                                    <input type="password" class="form-control" id="myInput" placeholder="" autocomplete="off" name="password" required>
                                                    <label for="floatingInputInvalid">Password</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mt-3">
                                                    <input type="password" class="form-control" id="myInput1" placeholder="" name="confirm_password" required>
                                                    <label for="floatingInputInvalid">Confirm Password</label>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="form-check form-switch ms-3 mt-2">
                                                <input class="form-check-input" onclick="myFunction()" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                                                <label class="form-check-label" for="flexSwitchCheckDefault">Show Password</label>
                                            </div>
                                            <input type="hidden" name="role" value="Staff">

                                            <br>
                                            <div class="col-md-6"><a class="btn btn-danger w-100 p-2 mt-3" href="index.php"> Back to Login </a></div>
                                            <div class="col-md-6"><button class="btn btn-primary mt-3" type="submit" name="add_staff"> Register </button></div>
                                        
                                        </div> 
                                        
                                        
                                        
                                        
                                        

                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    <div class="col-sm"></div>
                </div>
                            
            </div> -->

        </section>

        <!-- Footer -->


        <script>
            function myFunction() {
                var x = document.getElementById("myInput");
                var y = document.getElementById("myInput1");
                    if (x.type === "password" && y.type === "password") {
                        x.type = "text";
                        y.type = "text";
                    }
                     else {
                        x.type = "password";
                        y.type = "password";
                }
            }

            function trying() {
                window.location.href = "staff_registration.php";
            }
        </script>

    </body>
</html>