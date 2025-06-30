<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>DiwakarSewa - Home</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-900 text-white">

<!-- 🔵 NAVBAR -->
<nav class="bg-gray-800 p-4 flex items-center justify-between">
  <a href="/diwakarsewa/pages/home.php" class="flex items-center space-x-3">
    <img src="/diwakarsewa/assets/logo2.png" alt="DiwakarSewa Logo" class="h-12 w-12 object-contain" />
    <span class="text-white font-extrabold text-2xl">DiwakarSewa</span>
  </a>

  <form action="/diwakarsewa/pages/products.php" method="GET" class="flex-grow mx-6 max-w-2xl">
    <div class="relative">
      <input
        type="text"
        name="search"
        placeholder="Search for products, brands and more"
        class="w-full rounded-full py-3 px-5 pl-12 text-gray-100 bg-gray-700 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-yellow-500"
        value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
      />
      <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
        </svg>
      </div>
    </div>
  </form>

  <div class="flex items-center space-x-6 text-sm font-semibold">
    <a href="/diwakarsewa/pages/products.php" class="hover:text-yellow-400">Categories</a>
    <a href="/diwakarsewa/pages/about.php" class="hover:text-yellow-400">About Us</a>
    <a href="/diwakarsewa/pages/contact.php" class="hover:text-yellow-400">Contact Us</a>

    <?php if (isset($_SESSION['user'])): ?>
      <a href="/diwakarsewa/pages/cart.php" class="hover:text-yellow-400">Cart</a>
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

<!-- 💡 HERO -->
<main class="px-4 md:px-12 py-12 text-center">
  <h1 class="text-4xl md:text-5xl font-extrabold text-yellow-400 mb-4">Welcome to DiwakarSewa</h1>
  <p class="text-gray-300 text-lg md:text-xl max-w-2xl mx-auto">Where Technology Meets Elegance</p>
</main>

<!-- 🔄 Swipeable Phone Ad Section -->
<section class="overflow-x-auto scrollbar-hide py-6">
  <div class="flex justify-center">
    <div class="flex space-x-6 w-max px-4">

      <!-- Phone 1 -->
      <div class="bg-gray-800 border border-gray-700 rounded-xl w-72 flex-shrink-0 p-4 hover:shadow-xl transform hover:scale-105 transition">
        <img src="/diwakarsewa/assets/iphone15.jpg" class="w-full h-72 object-cover rounded mb-3" alt="Phone 1" />
        <p class="text-yellow-400 text-xl font-bold">Revolutionize Your Pocket</p>
        <p class="text-sm text-gray-400 mt-1">Blazing-fast, all-new feel.</p>
      </div>

      <!-- Phone 2 -->
      <div class="bg-gray-800 border border-gray-700 rounded-xl w-72 flex-shrink-0 p-4 hover:shadow-xl transform hover:scale-105 transition">
        <img src="/diwakarsewa/assets/s24ultra.jpg" class="w-full h-72 object-cover rounded mb-3" alt="Phone 2" />
        <p class="text-yellow-400 text-xl font-bold">Power Meets Elegance</p>
        <p class="text-sm text-gray-400 mt-1">Built for creators and dreamers.</p>
      </div>

      <!-- Phone 3 -->
      <div class="bg-gray-800 border border-gray-700 rounded-xl w-72 flex-shrink-0 p-4 hover:shadow-xl transform hover:scale-105 transition">
        <img src="/diwakarsewa/assets/oneplus12r.jpg" class="w-full h-72 object-cover rounded mb-3" alt="Phone 3" />
        <p class="text-yellow-400 text-xl font-bold">Speed. Style. Simplicity.</p>
        <p class="text-sm text-gray-400 mt-1">Crafted for the next-gen user.</p>
      </div>

    </div>
  </div>
</section>

<!-- 🧼 Style to hide scrollbar -->
<style>
  .scrollbar-hide::-webkit-scrollbar { display: none; }
  .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>

</body>
</html>
