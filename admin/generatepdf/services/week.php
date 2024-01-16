<?php
session_start();

require_once '../pdf.php';
require_once '../config.php';

$today = date('Y-m-d');
$startOfWeek = date('Y-m-d', strtotime('this week', strtotime($today)));
$endOfWeek = date('Y-m-d', strtotime('next week', strtotime($today)));



$query = "SELECT * FROM tbl_services WHERE created_at >= '$startOfWeek' AND created_at < '$endOfWeek'";
$result = $conn->query($query);

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

<h1 style="text-align:center">Weekly Availed Services Report</h1>
<h4>Week Generated:  '.date("F d, Y", strtotime($startOfWeek)).'  - '.date("F d, Y", strtotime($endOfWeek)).'</h4>';

// Count the number of rows
$rowCount = $result->num_rows;



$html .= '<table id="customers">';
$html .= '<tr>
<th>Customer Name</th>
<th>Service Availed</th>
<th>Staff Name</th>
<th>Date Created</th>
</tr>';
$totalSales = 0;
if ($rowCount > 0) {
  while ($row = $result->fetch_assoc()) {
    $html .= '<tr>';
    $html .= '<td>' . $row['customer_name'] . '</td>';
    $html .= '<td>' . $row['service_availed'] . '</td>';
    $html .= '<td>' . $row['staff_name'] . '</td>';
    $html .= '<td>' . date('Y-m-d H:i:s', strtotime($row['created_at'])) . '</td>';


    $html .= '</tr>';
  }
} else {
  $html .= '<tr><td colspan="5">No Availed Services this week.</td></tr>';
}

$html .= '</table>';

$pdf = new Pdf();
$file_name = 'Weekly Report -'.$today.'.pdf';
$pdf->loadHtml($html);
$pdf->setPaper('A4', 'portrait');
$pdf->render();
$pdf->stream($file_name, array("Attachment" => false));
?>
