<?php 
    error_reporting(E_ALL ^ E_WARNING);
    
    if(!isset($_SESSION)) {
        $showdate = date("Y-m-d");
        date_default_timezone_set('Asia/Manila');
        $showtime = date("h:i:a");
        $_SESSION['storedate'] = $showdate;
        $_SESSION['storetime'] = $showdate;
        session_start();
    }

    // redirect user if already logged in
    $user_role = $_SESSION['userdata']['role'];

    if($_SESSION['userdata']){
        if($user_role == 'administrator'){
            header('Location: admin_dashboard.php');
        }

        if($user_role == 'staff'){
            header('Location: staff_dashboard.php');
        }

        if($user_role == 'resident'){
            header('Location: resident_homepage.php');
        }
        
    }

    //include('autoloader.php');
    require('../classes/main.class.php');
    $bmis->login();

   
?>

<!DOCTYPE html> 
<html> 
    <head> 
        <title> Doc Gregg Veterinary Clinic </title>
        <!-- responsive tags for screen compatibility -->
        <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
        <!-- custom css --> 
        <link href="../css/index.css" rel="stylesheet" type="text/css">
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
            .input-container {
            display: -ms-flexbox; /* IE10 */
            display: flex;
            width: 100%;
            margin-bottom: 10px;
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
            .btn {
            color: white;
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


        <!-- This is the heading and card section --> 
        <section class="main-section"> 
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-sm"></div>
                        <div class="col-sm main-heading text-center text-white" > 
                        <img src="../user/logo.png" width="150"> 
                            <h3 class="banner-text"> Doc Gregg <br>Veterinary Clinic  </h3>

                        </div>
                    <div class="col-sm"></div>
                </div>
                <div class="row">
                    <div class="col-sm"></div>
                        <div class="col-sm"> 
                            <div class="card main-card mtop"> 
                                <div class="card-body"> 
                                    <form method="post"> 

                                        <div class="form-floating">
                                            <input type="email" class="form-control" id="floatingInputInvalid" placeholder="" name="email" require>
                                            <label for="floatingInputInvalid">Email</label>
                                        </div>
                                        <br>
                                        <div class="form-floating">
                                            <input type="password" class="form-control" id="myInput" placeholder="" name="password" require>
                                            <label for="floatingInputInvalid">Password</label>
                                        </div>

                                        <br>

                                        <div class="form-check form-switch">
                                            <input class="form-check-input" onclick="myFunction()" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                                            <label class="form-check-label" for="flexSwitchCheckDefault">Show Password</label>
                                        </div>

                                        <br>
                                        
                                        <button class="btn btn-primary login-button" type="submit" name="login"> Log-in </button>
                                    
                                    </form>

                                    <hr>

                                    <!-- <div class="registration-section"> 
                                        <p1> <strong> Haven't registered yet? </strong> </p1> 

                                        <br>

                                        <p1> Hindi ka pa rehistrado? </p1> 

                                        <br>

                                        <button class="btn btn-success create-button" onclick="trying();"> Create Account </button> 
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    <div class="col-sm"></div>
                </div>
                            
            </div>

        </section>

        <!-- Footer -->


        <script>
            function myFunction() {
                var x = document.getElementById("myInput");
                    if (x.type === "password") {
                        x.type = "text";
                    } else {
                        x.type = "password";
                }
            }

            function trying() {
                window.location.href = "staff_registration.php";
            }
        </script>

    </body>
</html>