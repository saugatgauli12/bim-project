<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>DiwakarSewa</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script> <!-- For icons -->
</head>
<body class="bg-white text-gray-900">

<nav class="bg-blue-900 p-4 flex items-center justify-between">
  <!-- Logo -->
  <a href="/diwakarsewa/pages/home.php" class="flex items-center space-x-3 flex-shrink-0">
    <img src="/diwakarsewa/assets/logo2.png" alt="DiwakarSewa Logo" class="h-10 w-10 object-contain" />
    <span class="text-white font-extrabold text-2xl select-none">DiwakarSewa</span>
  </a>

  <!-- Search Bar -->
  <form action="/diwakarsewa/pages/products.php" method="GET" class="flex-grow mx-6 max-w-3xl">
    <div class="relative">
      <input
        type="text"
        name="search"
        placeholder="Search for products, brands and more"
        class="w-full rounded-full py-3 px-5 pl-12 text-gray-900 focus:outline-none focus:ring-4 focus:ring-yellow-400"
        value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
      />
      <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
        <!-- Search icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
        </svg>
      </div>
    </div>
  </form>

  <!-- Right side navigation -->
  <div class="flex items-center space-x-6 text-white text-sm font-semibold">

    <a href="/diwakarsewa/pages/products.php" class="hover:text-yellow-400">Categories</a>

    <?php if (isset($_SESSION['user'])): ?>
      <a href="/diwakarsewa/pages/cart.php" class="flex items-center hover:text-yellow-400">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4" />
          <circle cx="7" cy="21" r="1" />
          <circle cx="17" cy="21" r="1" />
        </svg>
        Cart
      </a>

      <?php if ($_SESSION['user']['role'] === 'admin'): ?>
        <a href="/diwakarsewa/admin/dashboard.php" class="hover:text-yellow-400">Admin</a>
      <?php endif; ?>

      <a href="/diwakarsewa/pages/logout.php" class="hover:text-yellow-400">Logout</a>
    <?php else: ?>
      <a href="/diwakarsewa/pages/login.php" class="hover:text-yellow-400">Login</a>
      <a href="/diwakarsewa/pages/register.php" class="hover:text-yellow-400">Register</a>
    <?php endif; ?>
  </div>
</nav>

<main class="p-6">
  <!-- Your page content here -->
</main>

<script>
  // Optional: initialize feather icons if you use feather icon library
  // feather.replace();
</script>
</body>
</html>
