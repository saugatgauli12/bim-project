<?php
include '../includes/db.php';
include '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $price = $_POST['price'];
    $ram = $_POST['ram'];
    $storage = $_POST['storage'];
    $camera = $_POST['camera'];
    $stock = $_POST['stock'];
    $image = basename($_FILES['image']['name']);
    $target = '../assets/images/' . $image;
    move_uploaded_file($_FILES['image']['tmp_name'], $target);

    $stmt = $pdo->prepare("INSERT INTO products (name, brand, price, ram, storage, camera, stock, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $brand, $price, $ram, $storage, $camera, $stock, $image]);
    echo "<p class='text-green-600'>Product added successfully!</p>";
}
?>

<h2 class="text-2xl font-bold mb-6">Add Product</h2>
<form method="post" enctype="multipart/form-data" class="grid gap-4 max-w-xl">
  <input name="name" placeholder="Name" class="border p-2 rounded" required>
  <input name="brand" placeholder="Brand" class="border p-2 rounded" required>
  <input name="price" placeholder="Price" type="number" step="0.01" class="border p-2 rounded" required>
  <input name="ram" placeholder="RAM" class="border p-2 rounded" required>
  <input name="storage" placeholder="Storage" class="border p-2 rounded" required>
  <input name="camera" placeholder="Camera" class="border p-2 rounded" required>
  <input name="stock" placeholder="Stock" type="number" class="border p-2 rounded" required>
  <input type="file" name="image" accept="image/*" class="border p-2 rounded" required>
  <button class="bg-blue-900 text-white p-2 rounded">Add Product</button>
</form>

<?php include '../includes/footer.php'; ?>
