<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request method.");
}

$user_id = $_SESSION['user']['id'] ?? null;
if (!$user_id) die("User not logged in");

$address = $_POST['address'] ?? '';
$province = $_POST['province'] ?? '';
$city = $_POST['city'] ?? '';
$phone = $_POST['phone'] ?? '';
$payment_method = $_POST['payment_method'] ?? 'cod';

$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) die("Cart is empty");

$total_amount = 0;
foreach ($cart as $item) {
    if (!isset($item['id'], $item['price'], $item['quantity'])) {
        die("Invalid cart item format.");
    }
    $total_amount += $item['price'] * $item['quantity'];
}

$pdo->beginTransaction();

try {
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_amount, address, province, city, phone, payment_method, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending', NOW())");
    $stmt->execute([$user_id, $total_amount, $address, $province, $city, $phone, $payment_method]);
    $order_id = $pdo->lastInsertId();

    $item_stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    foreach ($cart as $item) {
        $item_stmt->execute([$order_id, $item['id'], $item['quantity'], $item['price']]);
    }

    unset($_SESSION['cart']);
    $pdo->commit();

    header("Location: ../pages/order_success.php?order_id=$order_id");
    exit;
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Order failed: " . $e->getMessage();
}
