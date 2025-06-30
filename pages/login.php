<?php
session_start();
include '../includes/db.php';  // make sure $pdo is your PDO connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Prepare statement to get user by email
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        $storedHash = $user['password'];

        if (password_verify($password, $storedHash)) {
            // Password verified with bcrypt hash
            $_SESSION['user'] = $user;
            header('Location: home.php');
            exit;
        } elseif (md5($password) === $storedHash) {
            // Password verified with old MD5 hash
            // Upgrade password hash to bcrypt now
            $newHash = password_hash($password, PASSWORD_DEFAULT);
            $updateStmt = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
            $updateStmt->execute([$newHash, $user['id']]);

            $_SESSION['user'] = $user;
            header('Location: home.php');
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="bg-gray-50">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login - DiwakarSewa</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100">

  <div class="max-w-md w-full bg-white rounded-lg shadow-md p-8 space-y-6">
    <div class="flex justify-center mb-6">
      <img src="/diwakarsewa/assets/logo2.png" alt="DiwakarSewa Logo" class="h-14 w-14 object-contain" />
    </div>

    <h2 class="text-center text-3xl font-extrabold text-blue-900">Sign in to your account</h2>

    <?php if (isset($error)): ?>
      <div class="bg-red-100 text-red-700 p-3 rounded border border-red-400 text-center"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" action="" class="space-y-5" novalidate>
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
        <input
          type="email"
          id="email"
          name="email"
          value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
          required
          autofocus
          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:ring-blue-500 focus:border-blue-500"
          placeholder="you@example.com"
        />
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input
          type="password"
          id="password"
          name="password"
          required
          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:ring-blue-500 focus:border-blue-500"
          placeholder="Enter your password"
        />
      </div>

      <div class="flex items-center justify-between">
        <label class="flex items-center text-sm text-gray-600">
          <input type="checkbox" name="remember" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" />
          <span class="ml-2">Remember me</span>
        </label>
        <a href="/diwakarsewa/pages/forgot_password.php" class="text-sm text-blue-600 hover:text-blue-800">Forgot password?</a>
      </div>

      <button
        type="submit"
        class="w-full bg-blue-900 hover:bg-blue-800 text-white font-semibold py-3 rounded-md shadow-sm transition duration-300"
      >
        Sign In
      </button>
    </form>

    <p class="text-center text-sm text-gray-600">
      Don't have an account?
      <a href="/diwakarsewa/pages/register.php" class="text-blue-600 hover:text-blue-800 font-medium">Register here</a>
    </p>
  </div>

</body>
</html>
