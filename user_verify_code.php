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
    $query = "SELECT * FROM tbl_user WHERE email='$email' AND verification_code='$verification_code' AND verified=0";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // If a matching record is found, update the user as verified
        $updateQuery = "UPDATE tbl_user SET verified=1 WHERE email='$email'";
        if ($conn->query($updateQuery) === TRUE) {
            // Redirect to a login page or wherever appropriate
            header("Location: index.php");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "Verification failed.";
    }
}

// Close the database connection
$conn->close();
?>
