<?php
session_start();

require_once '../pdf.php';
require_once '../config.php';

// Check if the form is submitted with date inputs
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fromDate = $_POST["fromDate"];
    $toDate = $_POST["toDate"];

    // Use DATE() function to get only the date part of created_at within the specified date range
    $query = "SELECT  * FROM tbl_log_services 
        INNER JOIN tbl_user 
        ON tbl_log_services.cli_id = tbl_user.id_user WHERE DATE(log_date) BETWEEN '$fromDate' AND '$toDate'";
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
    
    <h1 style="text-align:center">Daily Availed Services Report</h1>
    <h4>From: ' . $fromDate . '</h4>
    <h4>To:   	&nbsp;	&nbsp;	&nbsp;' . $toDate . '</h4>
    ';

    $html .= '
    <meta charset="UTF-8">
    <table  id="customers">';
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
    } else {
        $html .= '<tr><td colspan="3">No Registered User.</td></tr>';
    }

    $html .= '</table>';

    $pdf = new Pdf();

    $file_name = 'Client_Report_' . $fromDate . '_to_' . $toDate . '.pdf';
    $pdf->loadHtml($html);
    $pdf->setPaper('A4', 'portrait');
    $pdf->render();
    $pdf->stream($file_name, array("Attachment" => false));
}
?>
