<?php
session_start();

require_once '../pdf.php';
require_once '../config.php';
// Fetch today's date
$today = date('Y-m-d');
$currentMonth = date('Y-m');

// Connect to your database (replace with your own credentials)


// Fetch data from the shop_inventory table based on today's date
$query = "SELECT * FROM tbl_services WHERE DATE_FORMAT(created_at, '%Y-%m') = '$currentMonth'";
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


<h1 style="text-align:center">Yearly Availed Services Report</h1>
<h4>Year Generated:  '.date("Y", strtotime($today)).'</h4>

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
  // $total = $quantity * $unitPrice;
  while ($row = $result->fetch_assoc()) {
    $html .= '<tr>';
    $html .= '<td>' . $row['customer_name'] . '</td>';
    $html .= '<td>' . $row['service_availed'] . '</td>';
    $html .= '<td>' . $row['staff_name'] . '</td>';
    $html .= '<td>' . date('Y-m-d H:i:s', strtotime($row['created_at'])) . '</td>';


    $html .= '</tr>';
  }
} else {
  $html .= '<tr><td colspan="5">No Availed Services This Year.</td></tr>';
}
$html .= '</table>';
// $pdf = new Pdf();

// Load the HTML into dompdf
$pdf = new Pdf();
// $dompdf->loadHtml(html_entity_decode($html));
//landscape orientation
 $file_name = 'Yearly Report -'.$today.'.pdf';
 $pdf->loadHtml($html);
 $pdf->setPaper('A4', 'portrait');
 $pdf->render();
 $pdf->stream($file_name, array("Attachment" => false));

// Output the generated PDF to the browser
// $dompdf->stream('daily_report.pdf');
?>
