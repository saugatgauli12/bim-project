<?php
require 'includes/db.php';

$email = 'admin@example.com';
$password = 'admin123';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Check if already exists
$check = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$check->execute([$email]);

if ($check->rowCount() > 0) {
    echo "Admin already exists.";
} else {
    $stmt = $pdo->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
    $stmt->execute([$email, $hashedPassword, 'admin']);
    echo "✅ Admin created successfully. Email: $email | Password: $password";
}
?>
