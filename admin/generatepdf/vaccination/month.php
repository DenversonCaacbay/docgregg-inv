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

// $query = "SELECT * FROM tbl_pet
// INNER JOIN tbl_vaccination ON tbl_pet.pet_id = tbl_vaccination.pet_id 
// WHERE DATE_FORMAT(tbl_pet.created_at, '%Y-%m') = '$currentMonth'";
$query = "SELECT * FROM tbl_pet
          INNER JOIN tbl_vaccination ON tbl_pet.pet_id = tbl_vaccination.pet_id 
          WHERE DATE_FORMAT(tbl_pet.created_at, '%Y-%m') = '$currentMonth'";

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
<h1 style="text-align:center">Monthly Vaccination Report</h1>
<h4>Month Generated:  '.date("F, Y", strtotime($today)).'</h4>

';
$rowCount = $result->num_rows;

$html .= '<h5>Total Vaccinated this Day: ' . $rowCount . '</h5>';

$html .= '<table  id="customers">';
$html .= '<tr>
<th width="50%">Pet Name</th>
<th width="50%">Pet Condition</th>
<th width="50%">Vaccine Taken</th>
<th width="50%">Date Vaccinated</th>
</tr>';
$totalSales = 0;
if ($result->num_rows > 0) {

  while ($row = $result->fetch_assoc()) {
    $html .= '<tr>';
    $html .= '<td>' . $row['pet_name'] .'</td>';
    $html .= '<td>' . $row['pet_condition'] .'</td>';
    $html .= '<td>' . $row['vaccine_taken'] .'</td>';
    $html .= '<td>' . $row['created_at'] .  '.00</td>';

    $html .= '</tr>';
  }
} else {
  $html .= '<tr><td colspan="4">No Pet Vaccinated this month.</td></tr>';
}

$html .= '</table>';

$pdf = new Pdf();

 $file_name = 'Monthly Report -'.$today.'.pdf';
 $pdf->loadHtml($html);
 $pdf->setPaper('A4', 'portrait');
 $pdf->render();
 $pdf->stream($file_name, array("Attachment" => false));

?>
