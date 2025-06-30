<?php
include '../includes/db.php';
include '../includes/header.php';

$users = $pdo->query("SELECT * FROM users WHERE role = 'user'")->fetchAll();
?>

<h2 class="text-2xl font-bold mb-6">Customers</h2>
<table class="w-full border text-left">
  <tr class="bg-gray-200">
    <th class="p-2">Name</th><th>Email</th><th>Phone</th><th>City</th>
  </tr>
  <?php foreach ($users as $u): ?>
  <tr class="border-t">
    <td class="p-2"><?= $u['full_name'] ?></td>
    <td><?= $u['email'] ?></td>
    <td><?= $u['phone'] ?></td>
    <td><?= $u['city'] ?></td>
  </tr>
  <?php endforeach; ?>
</table>

<?php include '../includes/footer.php'; ?>
