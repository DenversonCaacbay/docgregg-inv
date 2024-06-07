<?php
session_start();

require_once 'config.php';
require_once 'print_pdf.php';

// Check if the city parameter is present in the URL
if (isset($_GET["city"])) {
    // Trim whitespace from the city name
    $city = trim($_GET["city"]);

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM tbl_user WHERE city = ?");
    $stmt->bind_param("s", $city);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Initialize HTML content
    $html = '
    <style>
        /* Define your CSS styles here */
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #0296be;
            color: white;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
    <h1>Customer Report for ' . htmlspecialchars($city) . '</h1>
    <table>
        <tr>
            <th>Customer Name</th>
            <th>Contact</th>
            <th>Email</th>
            <th>Street</th>
            <th>Barangay</th>
            <th>City</th>
            <th>Province</th>
        </tr>';

    // Check if there are rows in the result
    if ($result->num_rows > 0) {
        // Loop through each row
        while ($row = $result->fetch_assoc()) {
            // Add row data to HTML content
            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars($row['customer_name']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['customer_contact']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['customer_email']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['street']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['barangay']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['city']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['province']) . '</td>';
            $html .= '</tr>';
        }
    } else {
        // If no rows found, display a message
        $html .= '<tr><td colspan="7">No data found for the selected city.</td></tr>';
    }

    // Close the table and HTML content
    $html .= '</table>';

    // Create a new Dompdf instance
    $dompdf = new Pdf();

    // Load HTML content into Dompdf
    $dompdf->loadHtml($html);

    // Set paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // Render the PDF
    $dompdf->render();

    // Stream the PDF to the browser with a filename
    $dompdf->stream("Customer_Report_" . $city . ".pdf", array("Attachment" => false));
} else {
    // If city parameter is not present, display an error message
    echo "Invalid request.";
}
?>
