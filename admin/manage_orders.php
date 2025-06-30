<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';

// Fetch orders joined with users (if user_id is not NULL)
$stmt = $pdo->query("
    SELECT o.*, u.email AS customer_email
    FROM orders o
    LEFT JOIN users u ON o.user_id = u.id
    ORDER BY o.created_at DESC
");
$orders = $stmt->fetchAll();
?>

<h1 class="text-2xl font-bold mb-6">Manage Orders</h1>

<?php if (count($orders) === 0): ?>
    <p>No orders found.</p>
<?php else: ?>
    <table class="w-full border text-left">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2">Order ID</th>
                <th class="p-2">Customer</th>
                <th class="p-2">Status</th>
                <th class="p-2">Total</th>
                <th class="p-2">Payment</th>
                <th class="p-2">Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr class="border-b">
                    <td class="p-2"><?= $order['id'] ?></td>
                    <td class="p-2"><?= $order['customer_email'] ?? 'Guest' ?></td>
                    <td class="p-2"><?= htmlspecialchars($order['status']) ?></td>
                    <td class="p-2">Rs. <?= number_format($order['total_amount'], 2) ?></td>
                    <td class="p-2"><?= htmlspecialchars($order['payment_method']) ?></td>
                    <td class="p-2"><?= $order['created_at'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
