
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoloader
require '../classes/PHPMailer/src/Exception.php';
require '../classes/PHPMailer/src/PHPMailer.php';
require '../classes/PHPMailer/src/SMTP.php';

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
        $verificationCode = bin2hex(random_bytes(16));
        sendVerificationEmail($email, $verificationCode);

        // Update the verification_code column in the database
        $updateCodeQuery = "UPDATE tbl_admin SET verification_code = ? WHERE email = ?";
        $updateCodeStmt = $conn->prepare($updateCodeQuery);
        $updateCodeStmt->bind_param("ss", $verificationCode, $email);
        $updateCodeStmt->execute();

        // Redirect to verify_code.php
        header("Location: admin_verification_page.php?email=$email&code=$verificationCode");
        exit();
    } else {
        // User does not exist, redirect to login page
        header("Location: index.php");
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
        $mail->Username = 'rileyelijah052005@gmail.com';
        $mail->Password = 'zptq dkfa ommi azbl';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Set "From" address
        $mail->setFrom('rileyelijah052005@gmail.com', 'DG Veterinary Clinic');

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
    <title>Email Verification</title>
</head>
<body>
    <form method="post">
        <label for="email">Enter Email:</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">Submit</button>
    </form>
</body>
</html>