<?php 
    session_start();

    unset($_SESSION["shopping_cart"]);

    echo "<script>
    alert('Orders Cleared!');
    window.location.href='../admin_product_sale.php';
    </script>";
?>