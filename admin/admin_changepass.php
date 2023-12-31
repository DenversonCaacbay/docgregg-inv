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
            echo "<script type='text/javascript'>alert('Password updated successfully.');</script>";
            // Redirect to a login page or wherever appropriate
            header("Location: index.php");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "<script type='text/javascript'>alert('Passwords do not match.');</script>";
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
    <link href="../css/user.css" rel="stylesheet" type="text/css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <style>
        .text-header{
            color: #0296be;
        }
    </style>
<nav class="navbar sticky-top py-3 navbar-expand-lg navbar-dark">
    <a class="mx-auto" style="text-decoration:none;color: #fff;font-size: 20px; font-weight: 600;" href="#">Verifying...</a>
</nav>
<div class="container mt-5">
    <div class="card p-2">
    <form method="post" class="p-2">
    <h5 class="text-header">Change Your Password</h5>
    <div class="form-floating">
        <input type="password" class="form-control" id="floatingInputInvalid" placeholder="New Password" name="new_password" required>
        <label for="floatingInputInvalid">New Password</label>
    </div>
    <div class="form-floating mt-3">
        <input type="password" class="form-control" id="floatingInputInvalid" placeholder="Confirm Password" name="confirm_password" required>
        <label for="floatingInputInvalid">Confirm Password</label>
    </div>
    <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
    <button class="btn btn-primary w-100 mt-3" type="submit" name="update_password">Update Password</button>
</form>

    </div>
</div>


    
</body>
</html>