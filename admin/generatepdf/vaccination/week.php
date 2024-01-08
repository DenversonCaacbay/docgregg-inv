<?php
session_start();

require_once '../pdf.php';

$today = date('Y-m-d');
$startOfWeek = date('Y-m-d', strtotime('this week', strtotime($today)));
$endOfWeek = date('Y-m-d', strtotime('next week', strtotime($today)));

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dgvc";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$query = "SELECT * FROM tbl_pet
LEFT JOIN tbl_vaccination ON tbl_pet.pet_id = tbl_vaccination.pet_id 
WHERE DATE(tbl_vaccination.created_at) BETWEEN '$startOfWeek' AND '$endOfWeek'";

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

<h1 style="text-align:center">Weekly Vaccination Report</h1>
<h4>Week Generated:  ' . date("F d, Y", strtotime($startOfWeek)) . '  - ' . date("F d, Y", strtotime($endOfWeek)) . '</h4>
';

$rowCount = $result->num_rows;

$html .= '<h5>Total Vaccinated this Week: ' . $rowCount . '</h5>';
$html .= '
<meta charset="UTF-8">
<table  id="customers">';
$html .= '<tr>
<th width="50%">Pet Name</th>
<th width="50%">Pet Condition</th>
<th width="50%">Vaccine Taken</th>
<th width="50%">Date Vaccinated</th>
</tr>';
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
      $html .= '<tr>';
      $html .= '<td>' . $row['pet_name'] . '</td>';
      $html .= '<td>' . ($row['vac_condition'] ?? '') . '</td>'; // Check if pet_condition is not NULL
      $html .= '<td>' . ($row['vac_used'] ?? '') . '</td>'; // Check if vaccine_taken is not NULL
      $html .= '<td>' . ($row['created_at'] ?? '') . '.00</td>'; // Check if created_at is not NULL
      $html .= '</tr>';
  }
} else {
  $html .= '<tr><td colspan="4">No Pet Vaccinated this week.</td></tr>';
}
$html .= '</table>';

$pdf = new Pdf();

$file_name = 'Vaccination Weekly Report -' . $startOfWeek . '-' . $endOfWeek . '.pdf';
$pdf->loadHtml($html);
$pdf->setPaper('A4', 'portrait');
$pdf->render();
$pdf->stream($file_name, array("Attachment" => false));
?>
