<?php
// Replace with your actual database credentials
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

// Get the selected time period from the query parameters
$timePeriod = $_GET['timePeriod'];

// Customize this query based on your database structure
switch ($timePeriod) {
    case 'week':
        $interval = 'INTERVAL 1 WEEK';
        break;
    case 'month':
        $interval = 'INTERVAL 1 MONTH';
        break;
    case 'year':
        $interval = 'INTERVAL 1 YEAR';
        break;
    default:
        $interval = 'INTERVAL 1 WEEK'; // Default to week
}

$sql = "SELECT DATE_FORMAT(created_at, '%Y-%m-%d') AS date, SUM(total) AS total FROM invoice WHERE created_at >= NOW() - $interval GROUP BY date";

$result = $conn->query($sql);

$data = array('dates' => array(), 'total' => array());

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data['dates'][] = $row['date'];
        $data['total'][] = $row['total'];
    }
}

$conn->close();

// Send JSON response
header('Content-Type: application/json');
echo json_encode($data);
?>
