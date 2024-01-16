<?php
// Connect to your database
$host = 'localhost';
$dbname = 'dgvc';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Fetch data from tbl_services
$query = "SELECT service_availed FROM tbl_services";
$stmt = $pdo->prepare($query);
$stmt->execute();
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
