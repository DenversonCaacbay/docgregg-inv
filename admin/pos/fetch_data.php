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
$timePeriod = $_GET['timePeriod'] ?? 'weekly';

// Assuming you have a function to fetch data based on the time period
$data = fetchDataFromDatabase($conn, $timePeriod);

// Close the database connection
$conn->close();

// Convert data to JSON for JavaScript processing
header('Content-Type: application/json');
echo json_encode($data);

// Function to fetch data based on the time period
function fetchDataFromDatabase($conn, $timePeriod) {
    switch ($timePeriod) {
        case 'daily':
            $interval = 'INTERVAL 1 DAY';
            // $date_format = '%Y-%m-%d'; // Display as Year-Month-Day
            $date_format = '%M-%d-%Y';
            $group_by = 'DATE(created_at)';
            break;
        case 'weekly':
            $interval = 'INTERVAL 1 WEEK';
            $date_format = '%M-%d-%Y'; // Display as Year-Month-Day
            $group_by = 'YEARWEEK(created_at)';
            break;
        case 'monthly':
            $interval = 'INTERVAL 1 MONTH';
            $date_format = '%M-%Y'; // Display as Year-Month
            $group_by = 'DATE_FORMAT(created_at, "%Y-%m")';
            break;
        case 'yearly':
            $interval = 'INTERVAL 1 YEAR';
            $date_format = '%Y'; // Display as Year
            $group_by = 'YEAR(created_at)';
            break;
        default:
            $interval = 'INTERVAL 1 DAY'; // Default to daily
            $date_format = '%Y-%m-%d'; // Default format
            $group_by = 'DATE(created_at)';
    }

    $sql = "SELECT MIN(DATE_FORMAT(created_at, '$date_format')) AS start_date,
    MAX(DATE_FORMAT(created_at, '$date_format')) AS end_date,
    SUM(total) AS total
FROM invoice GROUP BY $group_by";


    $result = $conn->query($sql);

$data = array(
    'labels' => array(),
    'datasets' => array(
        array(
            'label' => 'Total Sales',
            'backgroundColor' => array(),
            'borderWidth' => 0,
            'data' => array()
        )
    )
);



        if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $label = '';
    
            switch ($timePeriod) {
                case 'daily':
                    $label = $row['start_date'];
                    break;
                case 'weekly':
                    $label = "From: " . $row['start_date'] . " To: " . $row['end_date'];
                    break;
                case 'monthly':
                    $label = $row['start_date'];
                    break;
                case 'yearly':
                    $label = $row['start_date'];
                    break;
                default:
                    $label = $row['start_date'];
            }
    
            $data['labels'][] = $label;
            $data['datasets'][0]['data'][] = $row['total'];
            $data['datasets'][0]['backgroundColor'][] = ($row['total'] > 20000) ? 'rgb(49,32,108,0.9)' : 'rgb(33, 150, 243)';
        }
    }

    return $data;
}
?>
