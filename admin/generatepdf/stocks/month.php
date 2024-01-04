<?php
session_start();

require_once '../pdf.php';

$today = date('Y-m-d');
$currentMonth = date('Y-m');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dgvc";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die('Connection failed: ' . $conn->connect_error);
}

$query = "SELECT * FROM invoice WHERE DATE_FORMAT(created_at, '%Y-%m') = '$currentMonth'";
$result = $conn->query($query);

// Generate the report HTML
$html = '
<style>
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
  background-color: #0296be;
  color: white;
}

</style>
<h1 style="text-align:center">Monthly Sales Report</h1>
<h4>Month Generated:  '.date("F, Y", strtotime($today)).'</h4>

';
$rowCount = $result->num_rows;


$html .= '<table  id="customers">';
$html .= '<tr>
<th>Created At</th>
<th>Product Name</th>
<th>Total</th>
</tr>';
$totalSales = 0;
if ($rowCount > 0) {
  while ($row = $result->fetch_assoc()) {
    $html .= '<tr>';
    $html .= '<td>' . date('Y-m-d H:i:s', strtotime($row['created_at'])) . '</td>';
    $html .= '<td>' . $row['product'] .  '</td>';
    $html .= '<td> ₱' . $row['total'] .  '.00</td>';
    $totalSales += $row['total']; // Accumulate total sales
    $html .= '</tr>';
  }
    // Display total sales row
    $html .= '<tr>';
    $html .= '<td colspan="2" style="text-align: right;">Total Sales:</td>';
    $html .= '<td> ₱' . $totalSales . '.00</td>';
    $html .= '</tr>';
} else {
  $html .= '<tr><td colspan="3">No sales this week.</td></tr>';
}

$html .= '</table>';

$pdf = new Pdf();

 $file_name = 'Monthly Report -'.$today.'.pdf';
 $pdf->loadHtml($html);
 $pdf->setPaper('A4', 'portrait');
 $pdf->render();
 $pdf->stream($file_name, array("Attachment" => false));

?>
