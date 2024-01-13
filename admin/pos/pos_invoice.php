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
        echo "<script>
        alert('Successfull! Create new transaction');
        window.location.href='../admin_product_sale.php';
        </script>";
        exit();
    }

?>