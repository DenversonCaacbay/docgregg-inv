<?php
// Check if email is not set in the GET parameters
if (!isset($_GET['email'])) {
    // Redirect to user_registration.php
    header("Location: index.php");
    exit(); // Ensure that the script stops executing after the redirection
}
?>
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

if (isset($_POST['update_password'])) {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($new_password === $confirm_password) {
        // Update the password in tbl_user
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $updateQuery = "UPDATE tbl_admin SET password='$hashed_password' WHERE email='$email'";

        if ($conn->query($updateQuery) === TRUE) {
            echo "<script type='text/javascript'>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Password updated successfully',
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
                            icon: 'success',
                            title: 'Password did not match',
                            showConfirmButton: false,
                            timer: 1500,
                            customClass: {
                                title: 'your-custom-font-class'
                            }
                        });
                    });
                  </script>";
            // Redirect after showing the alert
            header("refresh: 1; url=admin_changepass.php");
    }
}

// Close the database connection
$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link href="css/user.css" rel="stylesheet" type="text/css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <style>
        .text-header{
            color: #0296be;
        }
        .form-control{
            padding:10px;
        }
    </style>
<nav class="navbar sticky-top py-3 navbar-expand-lg navbar-dark">
    <a class="mx-auto" style="text-decoration:none;color: #fff;font-size: 20px; font-weight: 600;" href="#">Changing Password...</a>
</nav>
<div class="container mt-5">
    <div class="card p-2">
    <form method="post" class="p-2">
    <h5 class="text-header">Change Your Password</h5>
    <!-- <div class="form-floating">
        <input type="password" class="form-control" id="floatingInputInvalid newPassword" placeholder="New Password" name="new_password" required>
        <label for="floatingInputInvalid">New Password</label>
    </div>
    <div class="form-floating mt-3">
        <input type="password" class="form-control" id="floatingInputInvalid confirmPassword" placeholder="Confirm Password" name="confirm_password" required>
        <label for="floatingInputInvalid">Confirm Password</label>
    </div> -->
    <div class="form-group">
        <label> New Password </label>
        <input type="password" class="form-control" id="newPassword" placeholder="New Password" name="new_password" required>
    </div>
    <div class="form-group mt-3">
        <label> Confirm Password </label>
        <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password" name="confirm_password" required>
    </div>
    <div class="form-check form-switch mt-2">
        <input class="form-check-input" onclick="togglePasswordVisibility()" type="checkbox" role="switch" id="showPasswordCheckbox">
        <label class="form-check-label" for="flexSwitchCheckDefault">Show Password</label>
    </div>
    <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
    <button class="btn btn-primary w-100 mt-3" type="submit" name="update_password">Update Password</button>
</form>

    </div>
</div>

<script>
    function togglePasswordVisibility() {
        var newPasswordInput = document.getElementById('newPassword');
        var confirmPasswordInput = document.getElementById('confirmPassword');
        var showPasswordCheckbox = document.getElementById('showPasswordCheckbox');

        if (showPasswordCheckbox.checked) {
            newPasswordInput.type = 'text';
            confirmPasswordInput.type = 'text';
        } else {
            newPasswordInput.type = 'password';
            confirmPasswordInput.type = 'password';
        }
    }
</script>


    
</body>
</html>