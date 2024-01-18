<!-- SweetAlert 2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">

<!-- SweetAlert 2 JS (including dependencies) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
<style>
    .your-custom-font-class {
        font-family: 'Nunito', sans-serif;
    }
</style>
<?php

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dgvc";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['verify'])) {
    $email = $_POST['email'];
    $verification_code = $_POST['verification_code'];

    // Check if the verification code matches
    $query = "SELECT * FROM tbl_admin WHERE email='$email' AND verification_code='$verification_code' AND verified=0";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // If a matching record is found, update the user as verified
        $updateQuery = "UPDATE tbl_admin SET verified=1 WHERE email='$email'";
        if ($conn->query($updateQuery) === TRUE) {
            // Redirect to a login page or wherever appropriate
            echo "<script type='text/javascript'>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Account Verified. You can now login',
                            showConfirmButton: false,
                            timer: 1500,
                            customClass: {
                                title: 'your-custom-font-class'
                            }
                        });
                    });
                  </script>";
            // Redirect after showing the alert
            header("refresh: 1; url=index.php");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "<script type='text/javascript'>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'warning',
                title: 'Incorrect Verification Code',
                showConfirmButton: false,
                timer: 1500,
                customClass: {
                    title: 'your-custom-font-class'
                }
            }).then(function() {
                // Redirect after showing the alert
                window.location.href = 'staff_verification.php?email=$email';
            });
        });
      </script>";


        
    }
}

// Close the database connection
$conn->close();
?>
<?php
      if (!isset($_GET['email'])) {
        // If email is not set in GET parameters, redirect to staff_verification.php
        header("Location: index.php");
        exit(); // Ensure that the script stops executing after the redirection
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification</title>
    <link href="css/user.css" rel="stylesheet" type="text/css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <style>
        .text-header{
            color: #0296be;
        }
        .bg-primary{
                background: #0296be !important;
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
    </style>
<nav class="navbar sticky-top py-3 navbar-expand-lg navbar-dark bg-primary">
    <a class="mx-auto" style="text-decoration:none;color: #fff;font-size: 20px; font-weight: 600;" href="#">Verifying...</a>
</nav>
<div class="container mt-5">
    <div class="card p-2">
        <form method="post" class="p-2" action="">
                <h5 class="text-header">Enter Verification code sent to your Email</h5>
                <div class="form-floating">
                <input type="text" class="form-control" id="floatingInputInvalid" placeholder="" name="verification_code" value="" required>
                    <label for="floatingInputInvalid">Verification Code: </label>
                </div>
                <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>"><br>
            <button class="btn btn-primary w-100" type="submit" name="verify">Verify</button>
        </form>
    </div>
</div>


    
</body>
</html>