<?php
include '../includes/db.php';
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$_GET['id']]);
}
header('Location: ../admin/view_products.php');
exit;
