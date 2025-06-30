<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';

$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    echo "<p>Your cart is empty. <a href='products.php' class='text-blue-600 underline'>Shop now</a></p>";
    include '../includes/footer.php';
    exit;
}
?>

<h1 class="text-2xl font-bold mb-6">Checkout</h1>

<form action="../actions/place_order.php" method="POST" class="max-w-lg space-y-4">
  <div>
    <label class="block font-medium" for="name">Full Name:</label>
    <input type="text" id="name" name="name" required class="w-full border p-2 rounded">
  </div>

  <div>
    <label class="block font-medium" for="address">Address:</label>
    <textarea id="address" name="address" required class="w-full border p-2 rounded"></textarea>
  </div>

  <div>
    <label class="block font-medium" for="province">Province:</label>
    <input type="text" id="province" name="province" class="w-full border p-2 rounded" placeholder="Optional">
  </div>

  <div>
    <label class="block font-medium" for="city">City:</label>
    <input type="text" id="city" name="city" class="w-full border p-2 rounded" placeholder="Optional">
  </div>

  <div>
    <label class="block font-medium" for="phone">Phone:</label>
    <input type="tel" id="phone" name="phone" required class="w-full border p-2 rounded">
  </div>

  <div>
    <label class="block font-medium" for="payment_method">Payment Method:</label>
    <select id="payment_method" name="payment_method" class="w-full border p-2 rounded">
      <option value="cod" selected>Cash on Delivery</option>
      <option value="card">Credit/Debit Card</option>
      <option value="online">Online Payment</option>
    </select>
  </div>

  <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
    ✅ Place Order
  </button>
</form>

<?php include '../includes/footer.php'; ?>
