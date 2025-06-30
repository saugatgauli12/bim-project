<?php
session_start();
include '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['quantities'])) {
        foreach ($_POST['quantities'] as $id => $qty) {
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['id'] == $id) {
                    $item['quantity'] = max(1, (int)$qty);
                }
            }
        }
        unset($item);
    }

    if (isset($_POST['remove_id'])) {
        $_SESSION['cart'] = array_filter($_SESSION['cart'], fn($item) => $item['id'] != $_POST['remove_id']);
    }

    header("Location: cart.php");
    exit;
}

$cart = $_SESSION['cart'] ?? [];
?>

<div class="max-w-5xl mx-auto p-6">
  <h1 class="text-3xl font-bold mb-6 text-center">Your Shopping Cart</h1>

  <?php if (empty($cart)): ?>
    <p class="text-center text-gray-500 text-lg">Your cart is empty.</p>
  <?php else: ?>
    <form method="POST">
      <div class="overflow-x-auto">
        <table class="w-full border border-gray-300 text-sm text-left">
          <thead class="bg-gray-100">
            <tr>
              <th class="border px-4 py-2">Product ID</th>
              <th class="border px-4 py-2">Price</th>
              <th class="border px-4 py-2">Quantity</th>
              <th class="border px-4 py-2">Subtotal</th>
              <th class="border px-4 py-2">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $total = 0; ?>
            <?php foreach ($cart as $item): ?>
              <?php
                $id = htmlspecialchars($item['id']);
                $price = (float)$item['price'];
                $quantity = (int)$item['quantity'];
                $subtotal = $price * $quantity;
                $total += $subtotal;
              ?>
              <tr class="hover:bg-gray-50">
                <td class="border px-4 py-2"><?= $id ?></td>
                <td class="border px-4 py-2">Rs. <?= number_format($price, 2) ?></td>
                <td class="border px-4 py-2">
                  <input type="number" name="quantities[<?= $id ?>]" value="<?= $quantity ?>" min="1"
                         class="w-16 border rounded px-2 py-1" />
                </td>
                <td class="border px-4 py-2">Rs. <?= number_format($subtotal, 2) ?></td>
                <td class="border px-4 py-2">
                  <button type="submit" name="remove_id" value="<?= $id ?>"
                          class="text-red-600 hover:text-red-800 font-semibold"
                          onclick="return confirm('Remove this item?')">Remove</button>
                </td>
              </tr>
            <?php endforeach; ?>

            <tr class="bg-gray-100 font-bold">
              <td colspan="3" class="border px-4 py-2 text-right">Total</td>
              <td class="border px-4 py-2">Rs. <?= number_format($total, 2) ?></td>
              <td class="border px-4 py-2"></td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="mt-6 flex justify-between">
        <button type="submit"
                class="bg-blue-900 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
          Update Cart
        </button>
        <a href="/diwakarSewa/pages/checkout.php"
           class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
          Proceed to Checkout
        </a>
      </div>
    </form>
  <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
