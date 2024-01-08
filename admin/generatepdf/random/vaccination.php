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
    $query = "SELECT * FROM tbl_pet
          INNER JOIN tbl_vaccination ON tbl_pet.pet_id = tbl_vaccination.pet_id 
          WHERE DATE(tbl_pet.created_at) BETWEEN '$fromDate' AND '$toDate'";

   
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
    
    <h1 style="text-align:center">Client Report</h1>
    <h4>From: ' . $fromDate . '</h4>
    <h4>To:   	&nbsp;	&nbsp;	&nbsp;' . $toDate . '</h4>
    ';

    $html .= '
    <meta charset="UTF-8">
    <table  id="customers">';
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
            $html .= '<td>' . $row['vac_condition'] .'</td>';
            $html .= '<td>' . $row['vac_used'] .'</td>';
            $html .= '<td>' . $row['created_at'] .  '.00</td>';

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
