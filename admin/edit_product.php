<?php
include '../includes/db.php';
include '../includes/header.php';

if (!isset($_GET['id'])) { echo "<p>Product ID missing.</p>"; exit; }
$id = $_GET['id'];
$product = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$product->execute([$id]);
$product = $product->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $image = $product['image'];
    if (!empty($_FILES['image']['name'])) {
        $image = time() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../assets/images/" . $image);
    }
    $stmt = $pdo->prepare("UPDATE products SET name=?, brand=?, price=?, ram=?, storage=?, camera=?, stock=?, image=? WHERE id=?");
    $stmt->execute([
        $_POST['name'], $_POST['brand'], $_POST['price'], $_POST['ram'], $_POST['storage'], $_POST['camera'], $_POST['stock'], $image, $id
    ]);
    echo "<p class='text-green-600'>Product updated!</p>";
}
?>
<form method="post" enctype="multipart/form-data">
<input name="name" value="<?= $product['name'] ?>" required>
<input name="brand" value="<?= $product['brand'] ?>" required>
<input name="price" value="<?= $product['price'] ?>" required>
<input name="ram" value="<?= $product['ram'] ?>" required>
<input name="storage" value="<?= $product['storage'] ?>" required>
<input name="camera" value="<?= $product['camera'] ?>" required>
<input name="stock" value="<?= $product['stock'] ?>" required>
<input type="file" name="image" accept="image/*">
<button>Update</button>
</form>
