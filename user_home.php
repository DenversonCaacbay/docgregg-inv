<?php 
    error_reporting(E_ALL ^ E_WARNING);
    require('classes/resident.class.php');
    ini_set('display_errors',0);
    $userdetails = $residentbmis->get_userdata();
    $id_user = $_GET['id_user'];
    $resident = $residentbmis->get_single_resident($id_user);
    

    $residentbmis->profile_update();

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Doc Gregg Veterinary Clinic</title>
    <link href="css/user.css" rel="stylesheet" type="text/css">
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    
    <!-- Custom styles for this template-->
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar sticky-top navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
            <a class="navbar-brand" href="#">
            <img src="user/logo.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
            DG Veterinary Clinic
            </a>
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        
        <div class="collapse navbar-collapse ms-auto" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active border-bottom" aria-current="page" href="user_home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="user_pet.php">Pets</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="user_record.php">Records</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?= $userdetails['surname'];?>, <?= $userdetails['firstname'];?>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="user_myprofile.php">Profile</a></li>
                        <li><a class="dropdown-item" href="user_logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <div class="container-fluid">
        <div class="card mt-5 p-2">
            Recent Vaccine
            <h5>Date: January 5, 2024</h5>
        </div>
        <div class="card mt-3 p-2">
            <h4>This List of Vaccines are low on Stocks</h4>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>