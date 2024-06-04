<?php
    // var_dump($_POST["tableData"]);
    // var_dump($_GET["id_user"]);

    // Check if tableData and id_user are set in the POST request and URL respectively
    if(isset($_POST["tableData"]) && isset($_GET["id"])) {
        date_default_timezone_set('Asia/Manila'); // Ensure timezone is set correctly
       // Get the current date and time
        // Establish database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "dgvc";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check for connection errors
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve table data from the form
        $tableData = $_POST["tableData"];
        $tableData = json_decode($tableData, true);

        foreach ($tableData as $row) {
            $inventory_id = explode("|", $row['id'])[0];
            $stock_left = (int) explode("|", $row['id'])[1];
            $stock_demand = (int)$row['quantity'];
            $deduct_stock = $stock_left - $stock_demand;
            $date_timezone = date('Y-m-d H:i:s'); 
            // deduct inventory
            $stmt_inventory = $conn->prepare("UPDATE tbl_inventory SET quantity = ? WHERE inv_id = ?");
            $stmt_inventory->bind_param("ii", $deduct_stock, $inventory_id);
            $stmt_inventory->execute();
            $stmt_inventory->close();

            // insert to tbl_services 
            $cli_id = $_GET["id"]; // Retrieve id_user from the URL
            $pet_name = $row['pet'];
            $pet_type = $row['type'];
            $service_availed = $row['service'];
            $type_med_equip_serialized = json_encode($row['options']); // Serialize the $type_med_equip array
            $quantity = $row['quantity'];
            $staff = $row['staff'] ;

            // Prepare and execute SQL statement to insert data into the database
            $stmt = $conn->prepare("INSERT INTO tbl_services (cli_id, pet_name, pet_type, service_availed, type_med_equip, quantity, staff, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issssiss", $cli_id, $pet_name, $pet_type, $service_availed, $type_med_equip_serialized, $quantity, $staff, $date_timezone);
            $stmt->execute();
            $stmt->close();
            
            $stmt_logs = $conn->prepare("INSERT INTO tbl_log_services (cli_id, service_availed, staff_name, log_date) VALUES (?, ?, ?, ?)");
            $stmt_logs->bind_param("isss", $cli_id, $service_availed, $staff, $date_timezone);
            $stmt_logs->execute();
            $stmt_logs->close();
            
        }
        echo "<script type='text/javascript'>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Service Created',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        </script>";
        // Redirect after showing the alert
        header("refresh: 1; url=../admin/view_customer.php?id=" . $cli_id);
        // Redirect back to the form page or display a success message
        header("Location: ../admin/view_customer.php?id=" . $cli_id);
        exit();
    } else {
        // If tableData or id_user is not set, display an error message
        die("Error: tableData or id_user is not set in the POST request or URL.");
    }
?>

