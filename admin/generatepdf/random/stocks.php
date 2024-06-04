<?php
session_start();

require_once '../pdf.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dgvc";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Check if the form is submitted with date inputs
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fromDate = $_POST["fromDate"];
    $toDate = $_POST["toDate"];

    // Use DATE() function to get only the date part of created_at within the specified date range
    $query = "SELECT * FROM invoice WHERE DATE(created_at) BETWEEN '$fromDate' AND '$toDate'";
    $result = $conn->query($query);

    $html = '
    <style>
        .logo {
            text-align: center;
        }

        #customers {
            font-family: DejaVu Sans, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

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
        @font-face {
            font-family: DejaVu Sans, sans-serif;
            font-style: normal;
            font-weight: normal;
        }
    </style>
    
    <h1 style="text-align:center">Sales Report</h1>
    <h4>From: ' . date('F d, Y', strtotime($fromDate)) . '</h4>
    <h4>To:   	&nbsp;	&nbsp;	&nbsp;' .date('F d, Y', strtotime($toDate)). '</h4>
    ';

    $html .= '
    <meta charset="UTF-8">
    <table  id="customers">';
    $html .= '<tr>
    <th width="20%">Created At</th>
    <th width="40%">Product Name</th>
    <th width="20%">Staff</th>
    <th width="20%">Total</th>
    </tr>';

    $totalSales = 0;
    $totalProfit = 0;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $html .= '<tr>';
            $html .= '<td>' . date('F d, Y h:i A', strtotime($row['created_at'])) . '</td>';
            $html .= '<td class="product-name">' . $row['product'] .  '</td>';

            $html .= '<td style="display:none">' . $row['profit'] .'</td>';
             $html .= '<td> ' . $row['staff_name'] .  '</td>';
            $html .= '<td> ₱' . $row['total'] .  '.00</td>';
           
            $totalSales += $row['total']; // Accumulate total sales
            $totalProfit += $row['profit'];

            $html .= '</tr>';
        }

        // Display total sales row
        $html .= '<tr>';
        $html .= '<td colspan="3" style="text-align: right;">Total Sales:</td>';
        $html .= '<td> ₱' . $totalSales . '.00</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td colspan="3" style="text-align: right;">Total Profit:</td>';
        $html .= '<td> ₱' . $totalProfit . '.00</td>';
        // $html .= '<td> ₱' . $totalProfit . '.00</td>';

  $html .= '</tr>';
    } else {
        $html .= '<tr><td colspan="3">No Sales Recorded today.</td></tr>';
    }

    $html .= '</table>';

    $pdf = new Pdf();

    $file_name = 'Daily_Stocks_Report_' . $fromDate . '_to_' . $toDate . '.pdf';
    $pdf->loadHtml($html);
    $pdf->setPaper('A4', 'portrait');
    $pdf->render();
    $pdf->stream($file_name, array("Attachment" => false));
}
?>
