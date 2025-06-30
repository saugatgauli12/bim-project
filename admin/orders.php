<?php
include '../includes/db.php';
include '../includes/header.php';

$orders = $pdo->query("SELECT o.*, u.full_name FROM orders o JOIN users u ON o.user_id = u.id")->fetchAll();
?>

<h2 class="text-2xl font-bold mb-6">Manage Orders</h2>
<table class="w-full border text-left">
  <tr class="bg-gray-200">
    <th class="p-2">Order ID</th><th>Customer</th><th>Status</th><th>Total</th><th>Date</th>
  </tr>
  <?php foreach ($orders as $o): ?>
  <tr class="border-t">
    <td class="p-2"><?= $o['id'] ?></td>
    <td><?= $o['full_name'] ?></td>
    <td><?= $o['status'] ?></td>
    <td>Rs. <?= $o['total_amount'] ?></td>
    <td><?= $o['created_at'] ?></td>
  </tr>
  <?php endforeach; ?>
</table>

<?php include '../includes/footer.php'; ?>
