<?php
session_start();
include '../includes/db.php';

$pid = $_POST['pid'] ?? '';
$refId = $_POST['refId'] ?? '';
$tAmt = $_POST['tAmt'] ?? '';

if (!$pid || !$refId || !$tAmt) {
    die("Invalid payment verification data.");
}

// eSewa merchant info
$merchant_id = "YOUR_ES_EWA_MERCHANT_ID"; // Replace accordingly

// Verify payment with eSewa API
$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://esewa.com.np/epay/transrec",
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POSTFIELDS => http_build_query([
        'amt' => $tAmt,
        'scd' => $merchant_id,
        'pid' => $pid,
        'rid' => $refId,
    ]),
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/x-www-form-urlencoded'
    ],
]);

$response = curl_exec($curl);
curl_close($curl);

if (strpos($response, "Success") !== false) {
    // Payment successful - update order status
    $stmt = $pdo->prepare("UPDATE orders SET status = 'delivered' WHERE id = ?");
    $stmt->execute([$pid]);

    echo "<h2>Payment successful! Your order is confirmed.</h2>";
    echo "<a href='products.php'>Continue Shopping</a>";
} else {
    echo "<h2>Payment verification failed. Please contact support.</h2>";
}
?>
