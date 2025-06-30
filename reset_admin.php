<?php
require 'includes/db.php';

$email = 'admin@example.com';  // Replace with your actual admin email
$newPassword = 'admin123';     // New password you want

$hashed = password_hash($newPassword, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
$stmt->execute([$hashed, $email]);

echo "✅ Admin password reset successfully.";
