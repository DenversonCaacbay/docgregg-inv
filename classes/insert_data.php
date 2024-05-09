<?php
var_dump($_POST["tableData"]);
var_dump($_GET["id_user"]);

// Check if tableData and id_user are set in the POST request and URL respectively
// if(isset($_POST["tableData"]) && isset($_GET["id"])) {
//     // Establish database connection
//     $servername = "localhost";
//     $username = "root";
//     $password = "";
//     $dbname = "dgvc";

//     $conn = new mysqli($servername, $username, $password, $dbname);

//     // Check for connection errors
//     if ($conn->connect_error) {
//         die("Connection failed: " . $conn->connect_error);
//     }

//     // Retrieve table data from the form
//     $tableData = $_POST["tableData"];
//     $tableData = json_decode($tableData, true);

//     // Retrieve id_user from the URL
//     $cli_id = $_GET["id"];

//     // Prepare and execute SQL statement to insert data into the database
//     $stmt = $conn->prepare("INSERT INTO tbl_services (cli_id, pet_name, pet_type, service_availed, type_med_equip, quantity, staff) VALUES (?, ?, ?, ?, ?, ?, ?)");

//     // Bind parameters and execute the statement for each row of data
//     foreach ($tableData as $row) {
//         $pet_name = $row['pet'];
//         $pet_type = $row['type'];
//         $service_availed = $row['service'];

//         // Serialize the $type_med_equip array
//         $type_med_equip_serialized = json_encode($row['options']);
//         $quantity = $row['quantity'];
//         $staff = $row['staff'] ;
//         // $stmt->bind_param("issssss", $cli_id, $pet_name, $pet_type, $service_availed, $type_med_equip_serialized, $quantity, $staff);

//         $stmt->execute();
//     }

//     // Close the statement and database connection
//     $stmt->close();
//     $conn->close();
//     // echo "<script type='text/javascript'>
//     //     document.addEventListener('DOMContentLoaded', function() {
//     //         Swal.fire({
//     //             icon: 'success',
//     //             title: 'Service Created',
//     //             showConfirmButton: false,
//     //             timer: 1500
//     //         });
//     //     });
//     // </script>";
//     // Redirect after showing the alert
//     // header("refresh: 1; url=../admin/view_customer.php?id=" . $cli_id);
//     // Redirect back to the form page or display a success message
//     header("Location: ../admin/view_customer.php?id=" . $cli_id);
//     exit();
// } else {
//     // If tableData or id_user is not set, display an error message
//     die("Error: tableData or id_user is not set in the POST request or URL.");
// }
?>

