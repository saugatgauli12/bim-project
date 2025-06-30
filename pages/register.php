<?php
include '../includes/db.php';
include '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    $password = md5($_POST['password']);

    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $error = "Email already registered.";
    } else {
        $stmt = $pdo->prepare('INSERT INTO users (full_name, email, phone, address, city, province, password) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$full_name, $email, $phone, $address, $city, $province, $password]);
        header('Location: login.php');
        exit;
    }
}
?>

<div class="max-w-md mx-auto mt-10">
  <h2 class="text-2xl font-bold mb-4">Register</h2>
  <?php if(isset($error)): ?>
    <p class="text-red-600 mb-4"><?= $error ?></p>
  <?php endif; ?>
  <form method="post" action="">
    <input type="text" name="full_name" placeholder="Full Name" required class="w-full p-2 border rounded mb-4" />
    <input type="email" name="email" placeholder="Email" required class="w-full p-2 border rounded mb-4" />
    <input type="text" name="phone" placeholder="Phone Number" required class="w-full p-2 border rounded mb-4" />
    <input type="text" name="address" placeholder="Address" required class="w-full p-2 border rounded mb-4" />
    <input type="text" name="city" placeholder="City" required class="w-full p-2 border rounded mb-4" />
    <input type="text" name="province" placeholder="Province" required class="w-full p-2 border rounded mb-4" />
    <input type="password" name="password" placeholder="Password" required class="w-full p-2 border rounded mb-4" />
    <button type="submit" class="bg-blue-900 text-white px-4 py-2 rounded w-full">Register</button>
  </form>
</div>

<?php include '../includes/footer.php'; ?>
