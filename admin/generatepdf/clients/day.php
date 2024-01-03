<?php
session_start();
// require_once '../dompdf/vendor/autoload.php'; // Include dompdf library

// use Dompdf\Dompdf;

// Create a new Dompdf instance
// $dompdf = new Dompdf();
require_once '../pdf.php';
// $user = $_SESSION['username'];
// Fetch today's date
$today = date('Y-m-d');

// Connect to your database (replace with your own credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dgvc";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die('Connection failed: ' . $conn->connect_error);
}

// Fetch data from the shop_inventory table based on today's date
$query = "SELECT * FROM tbl_user WHERE created_at = '$today'";
$result = $conn->query($query);


// $imagePath = '../images/icon.png';
// $imageData = file_get_contents($imagePath);
// $imageBase64_1 = base64_encode($imageData);
// Generate the report HTML
$html = '

<style>
.logo{
  text-align:center;
}
#customers {
  font-family: DejaVu Sans, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #d9534f;
  color: white;
}

@font-face {
  font-family: DejaVu Sans, sans-serif;
  font-style: normal;
  font-weight: normal;

}
body {
  font-family: DejaVu Sans, sans-serif;
</style>


<h1 style="text-align:center">Daily Clients Report</h1>
<h4>Day Generated:  '.date("F d, Y", strtotime($today)).'</h4>

';

$html .= '
<meta charset="UTF-8">
<table  id="customers">';
$html .= '<tr>
<th>Client Name</th>
<th>Date Registered</th>
</tr>';
$totalSales = 0;
if ($result->num_rows > 0) {
  // $total = $quantity * $unitPrice;
  while ($row = $result->fetch_assoc()) {
    $html .= '<tr>';
    $html .= '<td>' . $row['fname'] . '</td>';
    $html .= '<td>' . $row['created_at'] . '</td>';

    $html .= '</tr>';
  }
  $html .= '<tr>';
  
  $html .= '</tr>';
} else {
  $html .= '<tr><td colspan="5">No Client Registered today.</td></tr>';
}

$html .= '</table>';
// $pdf = new Pdf();

// Load the HTML into dompdf
$pdf = new Pdf();
// $dompdf->loadHtml(html_entity_decode($html));
//landscape orientation
 $file_name = 'Client Daily Report -'.$today.'.pdf';
 $pdf->loadHtml($html);
 $pdf->setPaper('A4', 'portrait');
 $pdf->render();
 $pdf->stream($file_name, array("Attachment" => false));

// Output the generated PDF to the browser
// $dompdf->stream('daily_report.pdf');
?>
