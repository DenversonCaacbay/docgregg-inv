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

$query = "SELECT * FROM tbl_user WHERE DATE_FORMAT(created_at, '%Y-%m') = '$currentMonth'";
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
<h1 style="text-align:center">Monthly Clients Report</h1>
<h4>Month Generated:  '.date("F, Y", strtotime($today)).'</h4>

';
$rowCount = $result->num_rows;

$html .= '<h5>Total Clients Registered this Month: ' . $rowCount . '</h5>';

$html .= '<table  id="customers">';
$html .= '<tr>
<th>Client Name</th>
<th>Registered Date</th>
</tr>';
$totalSales = 0;
if ($result->num_rows > 0) {

  while ($row = $result->fetch_assoc()) {
    $html .= '<tr>';
    $html .= '<td>' . $row['fname'] . ' ' . $row['lname'] . '</td>';
    $html .= '<td>' . $row['created_at'] . '</td>';
    $html .= '</tr>';
  }
  $html .= '<tr>';

  $html .= '</tr>';
} else {
  $html .= '<tr><td colspan="5">No Client Registered this month.</td></tr>';
}

$html .= '</table>';

$pdf = new Pdf();

 $file_name = 'Monthly Report -'.$today.'.pdf';
 $pdf->loadHtml($html);
 $pdf->setPaper('A4', 'portrait');
 $pdf->render();
 $pdf->stream($file_name, array("Attachment" => false));

?>
