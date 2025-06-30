<?php
session_start();
include '../includes/db.php';

// Get order ID from URL query
$order_id = $_GET['order_id'] ?? null;
if (!$order_id) {
    die("Order ID missing.");
}

// Fetch order info from DB
$stmt = $pdo->prepare("SELECT total_amount FROM orders WHERE id = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch();

if (!$order) {
    die("Order not found.");
}

// eSewa merchant info
$merchant_id = "YOUR_ES_EWA_MERCHANT_ID";  // Replace with your eSewa Merchant ID

// Payment details
$amount = $order['total_amount'];

// URLs for eSewa callbacks
$success_url = "http://yourdomain.com/pages/esewa_success.php";  // Change to your domain
$failure_url = "http://yourdomain.com/pages/esewa_failure.php";  // Change to your domain
?>

<h1>Redirecting to eSewa Payment Gateway...</h1>

<form id="esewaForm" action="https://esewa.com.np/epay/main" method="POST">
    <input value="<?= htmlspecialchars($amount) ?>" name="tAmt" type="hidden">
    <input value="<?= htmlspecialchars($amount) ?>" name="amt" type="hidden">
    <input value="0" name="txAmt" type="hidden">
    <input value="0" name="psc" type="hidden">
    <input value="0" name="pdc" type="hidden">
    <input value="<?= htmlspecialchars($merchant_id) ?>" name="scd" type="hidden">
    <input value="<?= htmlspecialchars($order_id) ?>" name="pid" type="hidden">
    <input value="<?= htmlspecialchars($success_url) ?>" type="hidden" name="su">
    <input value="<?= htmlspecialchars($failure_url) ?>" type="hidden" name="fu">
</form>

<script>
    document.getElementById('esewaForm').submit();
</script>
