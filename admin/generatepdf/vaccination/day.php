<?php
session_start();

require_once '../pdf.php';

$today = date('Y-m-d');


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dgvc";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die('Connection failed: ' . $conn->connect_error);
}

// Use DATE() function to get only the date part of created_at
$query = "SELECT * FROM tbl_user WHERE DATE(created_at) = '$today'";
$result = $conn->query($query);

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
  background-color: #0296be;
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

$rowCount = $result->num_rows;

$html .= '<h5>Total Clients Registered this Day: ' . $rowCount . '</h5>';
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
    $html .= '<td>' . $row['fname'] . ' ' . $row['lname'] . '</td>';
    $html .= '<td>' . date('Y-m-d H:i:s', strtotime($row['created_at'])) . '</td>';


    $html .= '</tr>';
  }
} else {
  $html .= '<tr><td colspan="2">No Client Registered today.</td></tr>';
}

$html .= '</table>';

$pdf = new Pdf();

$file_name = 'Client Daily Report -'.$today.'.pdf';
$pdf->loadHtml($html);
$pdf->setPaper('A4', 'portrait');
$pdf->render();
$pdf->stream($file_name, array("Attachment" => false));

?>
