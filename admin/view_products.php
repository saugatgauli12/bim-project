<?php
include '../includes/db.php';
include '../includes/header.php';

$products = $pdo->query("SELECT * FROM products")->fetchAll();
?>

<h2 class="text-2xl font-bold mb-6">View Products</h2>
<table class="w-full border text-left text-sm">
  <thead class="bg-gray-200">
    <tr>
      <th class="p-2">Image</th>
      <th class="p-2">Name</th>
      <th class="p-2">Brand</th>
      <th class="p-2">Price</th>
      <th class="p-2">RAM</th>
      <th class="p-2">Storage</th>
      <th class="p-2">Stock</th>
      <th class="p-2">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($products as $p): ?>
    <tr class="border-t hover:bg-gray-100">
      <td class="p-2"><img src="../assets/images/<?= $p['image'] ?>" class="w-16 h-16 object-cover" /></td>
      <td class="p-2"><?= htmlspecialchars($p['name']) ?></td>
      <td class="p-2"><?= htmlspecialchars($p['brand']) ?></td>
      <td class="p-2">Rs. <?= number_format($p['price'], 2) ?></td>
      <td class="p-2"><?= $p['ram'] ?></td>
      <td class="p-2"><?= $p['storage'] ?></td>
      <td class="p-2"><?= $p['stock'] ?></td>
      <td class="p-2">
        <a href="edit_product.php?id=<?= $p['id'] ?>" class="text-blue-700 hover:underline mr-2">Edit</a>
        <a href="../actions/delete_product.php?id=<?= $p['id'] ?>" class="text-red-700 hover:underline" onclick="return confirm('Delete this product?')">Delete</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include '../includes/footer.php'; ?>
