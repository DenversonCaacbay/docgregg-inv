<?php
session_start();

require_once '../pdf.php';
require_once '../config.php';
$today = date('Y-m-d');
$currentMonth = date('Y-m');


$query = "SELECT * FROM tbl_log_services 
        INNER JOIN tbl_user 
        ON tbl_log_services.cli_id = tbl_user.id_user WHERE DATE_FORMAT(log_date, '%Y-%m') = '$currentMonth' ORDER BY tbl_log_services.log_date ASC";
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
<h1 style="text-align:center">Monthly Availed Services Report</h1>
<h4>Month Generated:  '.date("F, Y", strtotime($today)).'</h4>

';
$rowCount = $result->num_rows;


$html .= '<table  id="customers">';
$html .= '<tr>
<th>Customer Name</th>
<th>Service Availed</th>
<th>Staff Name</th>
<th>Date Created</th>
</tr>';
$totalSales = 0;
if ($result->num_rows > 0) {

  while ($row = $result->fetch_assoc()) {
    $html .= '<tr>';
    $html .= '<td>' . $row['customer_name'] . '</td>';
    $html .= '<td>' . $row['service_availed'] . '</td>';
    $html .= '<td>' . $row['staff_name'] . '</td>';
    $html .= '<td>' . date('Y-m-d H:i:s', strtotime($row['created_at'])) . '</td>';


    $html .= '</tr>';
  }
  $html .= '<tr>';

} else {
  $html .= '<tr><td colspan="5">No Availed Services this month.</td></tr>';
}

$html .= '</table>';

$pdf = new Pdf();

 $file_name = 'Monthly Report -'.$today.'.pdf';
 $pdf->loadHtml($html);
 $pdf->setPaper('A4', 'portrait');
 $pdf->render();
 $pdf->stream($file_name, array("Attachment" => false));

?>
