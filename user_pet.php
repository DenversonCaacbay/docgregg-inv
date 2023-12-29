<?php 
    error_reporting(E_ALL ^ E_WARNING);
    require('classes/resident.class.php');
    ini_set('display_errors',0);
    $userdetails = $residentbmis->get_userdata();
    $id_resident = $userdetails['id_user'];
    $resident = $residentbmis->get_single_resident($id_resident);
    $view = $residentbmis->view_pet($id_resident);
    
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

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    
    <!-- Custom styles for this template-->
    <link href="css/user.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
.create-btn {  
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background: #0296be !important;
    font-size: 25px;
    padding: 10px;
    /* float: right; */ /* Remove this line */
    /* color: white; */
}


 .create-btn:hover {
    border-radius: 50%;
    width: 70px;
    height: 70px;
    background: #0296be !important;
    font-size: 25px;
    padding: 10px;
}

</style>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
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
                    <a class="nav-link" aria-current="page" href="user_home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active border-bottom" href="user_pet.php">Pets</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="user_record.php">Records</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?= $userdetails['surname'];?>, <?= $userdetails['firstname'];?>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="user_logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <!-- <div class="container-fluid">
        <div class="card mt-5 p-2">
            ONGOING
        </div>
        <div class="card mt-3 p-2">
            
        </div>
    </div> -->
    
    <div class="container-fluid">
        <div class="row mt-2">
            <div class="col-md-6"><div class="title">My Pets</div></div>
            <div class="col-md-6">
                <div class="desk-create">
                    <a class="btn desk-create-btn text-light" href="create_user_pet.php">Add Pet</a>
                </div>
            </div>
        </div>
        
        


        <div class="card p-2 mt-4">
            <div class="row">
                <div class="col-md-3 text-center ">
                    <?php if(is_array($view) && count($view) > 0): ?>
                    <?php foreach($view as $item): ?>
                            <?php if (is_null($item['picture'])): ?>
                                <img src="images/placeholder/pet-placeholder.png" width="150px;">
                            <?php else: ?>
                    <?php endif; ?>
                </div>
                <div class="col-md-9">
                    <h5><?= $item['pet_name']; ?></h5>
                    <h5><?= date("F d, Y - l", strtotime($item['created_at'])); ?></h5>
                    <form action="" method="post" class="mt-4">
                        <a href="update_staff_form.php?id_user=<?= $item['id_admin']; ?>" class="btn btn-success">Update</a>
                        <input type="hidden" name="id_user" value="<?= $item['id_admin']; ?>">
                        <button class="btn btn-danger" type="submit" name="delete_staff">Archive</button>
                    </form>
                </div>
            </div>  
        </div>
        <?php endforeach; ?>
        <?php else: ?>
            <p>No data available.</p>
        <?php endif; ?>

        <div class="mob-create">
            <a class="btn create-btn text-light" href="create_user_pet.php">+</a>
        </div>
    </div>


        
    
    

</body>
</html>