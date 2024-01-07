
<?php
function isPageActive($page) {
    $currentPage = basename($_SERVER['PHP_SELF']);
    return ($currentPage === $page) ? 'active' : '';
}
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

<style>
 .navbar-nav .nav-link.active {
        border-bottom: 2px solid #0296be; /* Set the desired border color and thickness */
    }
</style>

<nav class="navbar sticky-top py-3 navbar-expand-lg navbar-dark">
    <div class="container">
            <a class="navbar-brand" href="user_home.php" style="color: #0296be;">
                <img src="user/logo.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                DG Veterinary Clinic
            </a>
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link <?= isPageActive('user_home.php'); ?>" aria-current="page" href="user_home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= isPageActive('user_pet.php'); ?>" href="user_pet.php">Pets</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link <?= isPageActive('user_record.php'); ?>" href="user_record.php">Records</a>
                </li> -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle  text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Include Bootstrap JS -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script> -->


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var links = document.querySelectorAll(".navbar-nav .nav-link");

        links.forEach(function (link) {
            if (link.getAttribute('href') === '<?= basename($_SERVER['PHP_SELF']); ?>') {
                link.classList.add('active');
            }
        });
    });
</script>
<!-- <script>
    document.addEventListener("DOMContentLoaded", function () {
        var links = document.querySelectorAll(".navbar-nav .nav-link");

        // Retrieve the active link from local storage
        var activeLink = localStorage.getItem('activeLink');

        // Set the active class on the stored active link
        if (activeLink) {
            links.forEach(function (link) {
                if (link.getAttribute('href') === activeLink) {
                    link.classList.add('active');
                }
            });
        }

        // Add click event listeners to the links
        links.forEach(function (link) {
            link.addEventListener("click", function (event) {
                // Remove 'active' class from all links
                links.forEach(function (l) {
                    l.classList.remove("active");
                });

                // Add 'active' class to the clicked link
                this.classList.add("active");

                // Store the clicked link in local storage
                localStorage.setItem('activeLink', this.getAttribute('href'));
            });
        });
    });
</script> -->



