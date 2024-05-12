<?php

// Sample database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "dgvc";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch deworming medicines
$query = "SELECT * FROM tbl_inventory WHERE type='Internal' AND (category='Syringe' OR category='Vaccine')  AND quantity > 0";
$result = $conn->query($query);

if (!$result) {
    die("Error fetching medicines: " . $conn->error);
}

$medicines = array();

// Fetch medicines and store them in an array
while ($row = $result->fetch_assoc()) {
    $medicines[] = $row;
}

// Close database connection
$conn->close();

// Return medicines as JSON
echo json_encode($medicines);
?>
