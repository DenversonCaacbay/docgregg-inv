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
    require('classes/main.class.php');
    $bmis->user_login();

   
?>

<!DOCTYPE html> 
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Doc Gregg Veterinary Clinic</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    
    <!-- Custom styles for this template-->
    <link href="css/user.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>
    <link rel="manifest" href="manifest.json">
    <script>
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('service-worker.js')
        .then(function(registration) {
            console.log('Service Worker registered with scope:', registration.scope);
        }).catch(function(error) {
            console.log('Service Worker registration failed:', error);
        });
    }
    </script>
</head>


<style> 
    body {
        background: rgb(255,255,255);
        background: linear-gradient(180deg, rgba(255,255,255,1) 42%, rgba(2,150,190,1) 100%);
    }
    .card{
        border: none;
    }
    .input-container {
    display: -ms-flexbox;
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
    .text-primary{
        color: #0296be !important;
    }
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
    .main-section {
    height: 100vh;
    padding:50px;
    }
    @media only screen and (max-width: 600px) { 
        .container-fluid{
            margin-top:15%;
        } 
        .main-section {
            padding:10px;
        }
        .btn {
            width: 100%;
            opacity: 0.9;
        }
    }
</style>
<body>

<section class="main-section"> 
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-sm"></div>
                        <div class="col-sm main-heading text-center text-white" >
                            <img src="assets/logo.png" width="150"> 
                            <h3 class="text-primary"> Doc Gregg <br>Veterinary Clinic  </h3>

                        </div>
                    <div class="col-sm"></div>
                </div>
                <div class="row">
                    <div class="col-sm"></div>
                        <div class="col-sm"> 
                            <div class="card main-card mtop"> 
                                <div class="card-body"> 
                                    <form method="post" autocomplete="off"> 

                                        <div class="form-floating">
                                            <input type="email" class="form-control" id="floatingInputInvalid" placeholder="" name="email" autocomplete="off" require>
                                            <label for="floatingInputInvalid">Email</label>
                                        </div>
                                        <br>
                                        <div class="form-floating">
                                            <input type="password" class="form-control" id="myInput" placeholder="" name="password" autocomplete="off" require>
                                            <label for="floatingInputInvalid">Password</label>
                                        </div>
                                        <br>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" onclick="myFunction()" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                                            <label class="form-check-label" for="flexSwitchCheckDefault">Show Password</label>
                                        </div>
                                        <br>                                       
                                        <button class="btn btn-primary login-button" type="submit" name="user_login"> Log-in </button>
                                        <a href="admin_forgot_password.php" class="mt-2" style="float:right">Forgot Password</a>
                                    
                                    </form>
                                    <br>

                                    <hr class="mt-3">

                                    <div class="registration-section mt-3"> 
                                        <p1> <strong> Register as Staff</strong> </p1> 


                                        <A class="btn btn-primary mt-3" href="sign-up-staff.php"> Create Account </A> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="col-sm"></div>
                </div>
                            
            </div>

        </section>

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
                window.location.href = "sign-up-staff.php";
            }
        </script>

        


</body>
</html>