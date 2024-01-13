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

$query = "SELECT * FROM invoice WHERE DATE(created_at) = '$today'";
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

#customers td.product-name {
  word-wrap: break-word;
  max-width: 150px; /* Set a maximum width to control line breaks */
}
</style>


<h1 style="text-align:center">Daily Stocks Report</h1>
<h4>Day Generated:  '.date("F d, Y", strtotime($today)).'</h4>

';

$html .= '
<meta charset="UTF-8">
<table  id="customers">';
$html .= '<tr>
<th width="20%">Created At</th>
<th width="20%">Customer Name</th>
<th width="40%">Product Name</th>
<th width="20%">Total</th>
</tr>';

$totalSales = 0;

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $html .= '<tr>';
    $html .= '<td>' . date('Y-m-d H:i:s', strtotime($row['created_at'])) . '</td>';
    $html .= '<td>' . $row['customer_name'] .  '</td>';
    $html .= '<td class="product-name">' . $row['product'] .  '</td>';
    $html .= '<td> ₱' . $row['total'] .  '.00</td>';
    $totalSales += $row['total']; // Accumulate total sales

    $html .= '</tr>';
  }

  // Display total sales row
  $html .= '<tr>';
  $html .= '<td colspan="3" style="text-align: right;">Total Sales:</td>';
  $html .= '<td> ₱' . $totalSales . '.00</td>';
  $html .= '</tr>';
} else {
  $html .= '<tr><td colspan="4">No Sales Recorded today.</td></tr>';
}

$html .= '</table>';

$pdf = new Pdf();

$file_name = 'Client Daily Report -'.$today.'.pdf';
$pdf->loadHtml($html);
$pdf->setPaper('A4', 'portrait');
$pdf->render();
$pdf->stream($file_name, array("Attachment" => false));

?>
