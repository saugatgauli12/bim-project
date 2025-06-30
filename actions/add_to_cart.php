<?php
session_start();

$product_id = $_POST['product_id'] ?? null;
$price = $_POST['price'] ?? null;
$quantity = $_POST['quantity'] ?? 1;

if (!$product_id || !$price) {
    die("Product ID and price required");
}

$quantity = max(1, (int)$quantity);
$price = (float) $price;

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item) {
    return is_array($item) && isset($item['id'], $item['price'], $item['quantity']);
});

$found = false;
foreach ($_SESSION['cart'] as &$item) {
    if ($item['id'] == $product_id) {
        $item['quantity'] += $quantity;
        $found = true;
        break;
    }
}
unset($item);

if (!$found) {
    $_SESSION['cart'][] = [
        'id' => $product_id,
        'price' => $price,
        'quantity' => $quantity
    ];
}

// ✅ FIXED REDIRECT PATH:
header("Location: /diwakarSewa/pages/cart.php");
exit;
