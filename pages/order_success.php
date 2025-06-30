<?php
session_start();

// Get order ID and payment method from URL query parameters, sanitize them
$order_id = isset($_GET['order_id']) ? htmlspecialchars($_GET['order_id']) : 'N/A';
$payment_method = isset($_GET['payment_method']) ? htmlspecialchars($_GET['payment_method']) : 'COD';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Order Success - DiwakarSewa</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-white text-gray-900 flex items-center justify-center min-h-screen">
  <div class="max-w-lg p-6 border rounded shadow text-center">
    <h1 class="text-3xl font-bold mb-4 text-green-600">Thank you for your order!</h1>
    <p class="mb-2">Your order <span class="font-semibold">#<?= $order_id ?></span> has been successfully placed.</p>
    <p class="mb-4">Payment method: <span class="font-semibold"><?= $payment_method ?></span></p>
    <p>We will process and deliver your items soon.</p>
    <a href="/diwakarsewa/pages/home.php" class="mt-6 inline-block bg-blue-900 text-white px-4 py-2 rounded hover:bg-blue-700">Back to Home</a>
  </div>
</body>
</html>
