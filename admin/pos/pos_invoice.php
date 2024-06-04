<?php 
    $pdo = require 'connection.php';
    session_start();
    date_default_timezone_set('Asia/Manila'); // Ensure timezone is set correctly
    $date_timezone = date('Y-m-d H:i:s'); // Get the current date and time

    $productAll = '';
    $processTotal = '';
    $processProfit = '';
    $processCustomer = '';
    $processCash = '';
    $processChange = '';
    $processTotalQty = 0;
    $staff_name = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if it has qty
        foreach ($_SESSION['shopping_cart'] as $data) {
            $prod_id = $data['item_id'];
            $prod_qty = $data['item_quantity'];
            $processTotalQty += $data['item_quantity'];

            // Fetch the product details
            $searchProd = "SELECT * FROM tbl_inventory WHERE inv_id = :prod_id";
            $statement = $pdo->prepare($searchProd);
            $statement->bindParam(':prod_id', $prod_id, PDO::PARAM_INT);
            $statement->execute();
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);

            foreach ($results as $result) {
                $old_qty = $result['quantity'];
                // Reduce qty
                $newQty = $old_qty - $prod_qty;

                // Update quantity
                $reduce_qty = "UPDATE tbl_inventory SET quantity = :quantity WHERE inv_id = :prod_id";
                $statement = $pdo->prepare($reduce_qty);
                $statement->bindParam(':quantity', $newQty, PDO::PARAM_INT);
                $statement->bindParam(':prod_id', $prod_id, PDO::PARAM_INT);
                $statement->execute();
            }
        }

        // Create invoice
        $sql = 'INSERT INTO invoice (customer_name, product, total, profit, totalQty, cash, cash_change, staff_name, created_at) 
                VALUES (:customer_name, :products, :total, :profit, :totalQty, :cash, :cash_change, :staff_name, :date_timezone)';
        $statement = $pdo->prepare($sql);

        $statement->bindParam(':customer_name', $_POST['processCustomer']);
        $statement->bindParam(':products', $_POST['productAll']);
        $statement->bindParam(':total', $_POST['processTotal']);
        $statement->bindParam(':profit', $_POST['processProfit']);
        $statement->bindParam(':totalQty', $processTotalQty);
        $statement->bindParam(':cash', $_POST['processCash']);
        $statement->bindParam(':cash_change', $_POST['processChange']);
        $statement->bindParam(':staff_name', $_POST['staff_name']);
        $statement->bindParam(':date_timezone', $date_timezone); // Use the captured date and time

        // Execute the query
        $statement->execute();

        // Clear the shopping cart
        unset($_SESSION["shopping_cart"]);

        echo "<script type='text/javascript'>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Successful, Create New Transaction',
                    showConfirmButton: false,
                    timer: 1500,
                    customClass: {
                        title: 'your-custom-font-class'
                    }
                });
            });
        </script>";

        // Redirect after showing the alert
        header("refresh: 1; url=../admin_product_sale.php");
        exit();
    }
?>
