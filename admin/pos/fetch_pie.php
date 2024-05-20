<?php
// Connect to your database
$host = 'localhost';
$dbname = 'dgvc';
$username = 'root';
$password = '';

// Get the pet type and timeframe from the query string
$pet_type = isset($_GET['pet_type']) ? $_GET['pet_type'] : '';
$timeframe = isset($_GET['timeframe']) ? $_GET['timeframe'] : '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Determine the date range based on the timeframe
$dateCondition = '';
switch ($timeframe) {
    case 'daily':
        $dateCondition = "DATE(created_at) = CURDATE()";
        break;
    case 'weekly':
        $dateCondition = "YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)";
        break;
    case 'monthly':
        $dateCondition = "MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())";
        break;
    case 'yearly':
        $dateCondition = "YEAR(created_at) = YEAR(CURDATE())";
        break;
    default:
        // If no valid timeframe is provided, default to no date filtering
        $dateCondition = "1";
        break;
}

// Fetch data from tbl_services based on pet type and date condition
$query = "SELECT service_availed FROM tbl_services WHERE pet_type = ? AND $dateCondition";
$stmt = $pdo->prepare($query);
$stmt->execute([$pet_type]);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Process the data to count occurrences of each service
$serviceCounts = [];
foreach ($data as $row) {
    $services = explode(', ', $row['service_availed']); // Assuming services are separated by ', '
    foreach ($services as $service) {
        $service = trim($service); // Remove extra spaces
        $serviceCounts[$service] = isset($serviceCounts[$service]) ? $serviceCounts[$service] + 1 : 1;
    }
}

// Format the data for JavaScript
$result = [];
foreach ($serviceCounts as $service => $count) {
    $result[] = ['service_name' => $service, 'count' => $count];
}

// Output the result as JSON
header('Content-Type: application/json');
echo json_encode($result);
?>
