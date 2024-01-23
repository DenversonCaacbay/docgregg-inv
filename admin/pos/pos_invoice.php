<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- SweetAlert 2 JS (including dependencies) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
<style>
    .your-custom-font-class {
        font-family: 'Nunito', sans-serif;
    }
</style>

<?php 
    $pdo = require 'connection.php';
    session_start();

    //
    $productAll = '';
    $processTotal = '';
    $processCustomer = '';
    $processCash = '';
    $processChange = '';
    $processTotalQty = 0;
    $staff_name = '';

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // check if it has qty
        foreach($_SESSION['shopping_cart'] as $data){
            $prod_id = $data['item_id'];
            $prod_qty = $data['item_quantity'];
            $processTotalQty += $data['item_quantity'];;

            // echo $data['item_id']."<br>";
            // echo $data['item_quantity']."<br>";
            $searchProd = "SELECT * FROM tbl_inventory WHERE inv_id = ".$prod_id;
            $statement = $pdo->query($searchProd);
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);

            foreach($results as $result){
                    $old_qty = $result['quantity'];
                    // reduce qty
                    $newQty = $old_qty - $prod_qty;

                    $data = ['quantity' => 1];

                    $reduce_qty = "UPDATE tbl_inventory SET quantity = :quantity WHERE inv_id = ".$prod_id;

                    $statement = $pdo->prepare($reduce_qty);

                    $statement->bindParam(':quantity', $data['quantity']);

                    // change
                    $data['quantity'] = $newQty;

                    $statement->execute();
            }

        }

        // create invoice
        $sql = 'INSERT INTO invoice(customer_name, product, total, totalQty,cash, cash_change, staff_name) 
            VALUES (:customer_name, :products, :total, :totalQty, :cash, :cash_change, :staff_name)';

        $statement = $pdo->prepare($sql);

        $newInv = [
            'customer_name' => 'text',
            'products' => 'text',
            'total' => '9',
            'totalQty' => '0',
            'cash' => 9,
            'cash_change' => 9,
            'staff_name' => 'text',
        ];

        $statement->bindParam(':customer_name', $newInv['customer_name']);
        $statement->bindParam(':products', $newInv['products']);
        $statement->bindParam(':total', $newInv['total']);
        $statement->bindParam(':totalQty', $newInv['totalQty']);
        $statement->bindParam(':cash', $newInv['cash']);
        $statement->bindParam(':cash_change', $newInv['cash_change']);
        $statement->bindParam(':staff_name', $newInv['staff_name']);

        //change
        $newInv['customer_name'] = $_POST['processCustomer'];
        $newInv['products'] = $_POST['productAll'];
        $newInv['totalQty'] = $processTotalQty;
        $newInv['total'] = $_POST['processTotal'];
        $newInv['cash'] = $_POST['processCash'];
        $newInv['cash_change'] = $_POST['processChange'];
        $newInv['staff_name'] = $_POST['staff_name'];

        //execute query
        $statement->execute();

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