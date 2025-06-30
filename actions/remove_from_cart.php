<?php
session_start();

if (isset($_POST['product_id'])) {
    $id = $_POST['product_id'];

    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);  // Remove item from cart
    }
}

header("Location: ../pages/cart.php");
exit;
