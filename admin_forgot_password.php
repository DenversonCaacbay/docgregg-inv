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
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoloader
require 'classes/PHPMailer/src/Exception.php';
require 'classes/PHPMailer/src/PHPMailer.php';
require 'classes/PHPMailer/src/SMTP.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Your database connection code here (replace with your actual credentials)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dgvc";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the user exists
    $checkUserQuery = "SELECT * FROM tbl_admin WHERE email = ?";
    $stmt = $conn->prepare($checkUserQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists, generate verification code and send email
        $verificationCode = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
        sendVerificationEmail($email, $verificationCode);

        // Update the verification_code column in the database
        $updateCodeQuery = "UPDATE tbl_admin SET verification_code = ? WHERE email = ?";
        $updateCodeStmt = $conn->prepare($updateCodeQuery);
        $updateCodeStmt->bind_param("ss", $verificationCode, $email);
        $updateCodeStmt->execute();

        // Redirect to verify_code.php
        header("Location: admin_forgot_verification_page.php?email=$email&code=$verificationCode");
        exit();
    } else {
        // User does not exist, redirect to login page
        echo "<script type='text/javascript'>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'warning',
                            title: 'No Account Found. Please Register First.',
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
        // header("Location: index.php");
        exit();
    }

    $stmt->close();
    $conn->close();
}

function sendVerificationEmail($email, $verificationCode) {
    $mail = new PHPMailer(true);

    try {
        // Your SMTP settings here
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'dgvetclinic@gmail.com';
        $mail->Password = 'uxpq syxi hxte ootg';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Set "From" address
        $mail->setFrom('dgvetclinic@gmail.com', 'DG Veterinary Clinic');

        // Set "To" address
        $mail->addAddress($email);

        // Set email subject and body
        $mail->Subject = 'Email Verification';
        $mail->Body = "Thank you for signing up! Your verification code is: $verificationCode";

        // Enable verbose debug output
        $mail->SMTPDebug = 2;

        // Send the email
        $mail->send();
    } catch (Exception $e) {
        // Log the error
        error_log("Email sending failed for $email: " . $mail->ErrorInfo, 1, "your_error_log.txt");
        echo "Email sending failed. Please try again later.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email</title>
    <link href="css/user.css" rel="stylesheet" type="text/css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <style>
        .text-header{
            color: #0296be;
        }
    </style>
<nav class="navbar sticky-top py-3 navbar-expand-lg navbar-dark">
    <a class="mx-auto" style="text-decoration:none;color: #fff;font-size: 20px; font-weight: 600;" href="#">Email...</a>
</nav>
<div class="container mt-5">
    <div class="card p-2">
        <form method="post" class="p-2">
                <h5 class="text-header">Your Email: </h5>
                <div class="form-floating">
                    <input type="text" class="floatingInputInvalid form-control" placeholder="" id="email" name="email" require>
                    <label for="floatingInputInvalid">Email </label>
                </div>
            <button class="btn btn-primary w-100 mt-3" type="submit" name="verify">Enter</button>
        </form>
    </div>
</div>


    
</body>
</html>