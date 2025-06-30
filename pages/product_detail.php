<?php
include '../includes/db.php';
include '../includes/header.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  echo "<p class='text-red-600 p-6'>Invalid product ID.</p>";
  include '../includes/footer.php';
  exit;
}

$id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
  echo "<p class='text-red-600 p-6'>Product not found.</p>";
  include '../includes/footer.php';
  exit;
}

// Explode colors string into array, trim whitespace
$colors = [];
if (!empty($product['colors'])) {
  $colors = array_map('trim', explode(',', $product['colors']));
}
?>

<div class="max-w-6xl mx-auto p-6 mt-6 bg-white shadow rounded">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

    <!-- 🖼 Product Image -->
    <div class="flex justify-center items-center">
      <img src="../assets/<?= htmlspecialchars($product['image']) ?>" 
           alt="<?= htmlspecialchars($product['name']) ?>" 
           class="rounded border w-full max-w-md object-contain">
    </div>

    <!-- 📦 Product Details -->
    <div>
      <h1 class="text-3xl font-bold text-blue-900 mb-2"><?= htmlspecialchars($product['name']) ?></h1>
      <p class="text-gray-600 text-sm mb-2">Brand: <span class="font-semibold"><?= htmlspecialchars($product['brand']) ?></span></p>

      <!-- 💰 Price & Stock -->
      <div class="text-2xl text-red-600 font-bold mb-4">Rs. <?= number_format($product['price'], 2) ?></div>
      <p class="text-green-600 mb-4">In Stock: <?= (int)$product['stock'] ?> units</p>

      <!-- 📝 Description -->
      <h2 class="text-lg font-semibold mb-2">Description</h2>
      <p class="text-gray-700 leading-relaxed mb-4">
        <?= $product['description'] ? nl2br(htmlspecialchars($product['description'])) : 'No description available.' ?>
      </p>

      <!-- 📊 Specifications -->
      <h2 class="text-lg font-semibold mb-2">Specifications</h2>
      <ul class="text-gray-700 text-sm mb-4 space-y-1">
        <li><strong>RAM:</strong> <?= htmlspecialchars($product['ram']) ?></li>
        <li><strong>Storage:</strong> <?= htmlspecialchars($product['storage']) ?></li>
        <li><strong>Camera:</strong> <?= htmlspecialchars($product['camera']) ?></li>
      </ul>

      <!-- 🎨 Color Options -->
      <?php if (!empty($colors)): ?>
      <h2 class="text-lg font-semibold mb-2">Available Colors</h2>
      <div class="flex space-x-3 mb-6">
        <?php foreach ($colors as $color): 
          // Generate a lowercase id-friendly value for buttons
          $colorId = strtolower(str_replace(' ', '_', $color));
        ?>
          <button 
            type="button" 
            data-color="<?= htmlspecialchars($color) ?>" 
            class="color-btn w-8 h-8 rounded-full border-2 border-gray-300 hover:border-blue-600 focus:outline-none"
            style="background-color: <?= htmlspecialchars($color) ?>;"
            title="<?= htmlspecialchars($color) ?>"
            aria-label="<?= htmlspecialchars($color) ?>">
          </button>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>

      <!-- 🛒 Cart Form -->
      <form action="/diwakarsewa/actions/add_to_cart.php" method="POST" class="space-y-3">
        <input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>">
        <input type="hidden" name="price" value="<?= (float)$product['price'] ?>">
        <input type="hidden" name="selected_color" id="selected_color" value="<?= !empty($colors) ? htmlspecialchars($colors[0]) : '' ?>">

        <label class="text-sm font-medium">Quantity:</label>
        <input type="number" name="quantity" value="1" min="1" required class="border px-3 py-1 rounded w-20 ml-2">

        <div class="flex gap-4 mt-4">
          <button type="submit" class="bg-blue-900 text-white px-6 py-2 rounded hover:bg-blue-700">Add to Cart</button>
          <button type="button" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-500">Buy Now</button>
        </div>
      </form>

      <!-- 🚚 Delivery Info -->
      <div class="mt-6 border-t pt-4 text-sm text-gray-500">
        <p><strong>Delivery:</strong> Free Delivery in 2-4 days</p>
        <p><strong>Return Policy:</strong> 7 Days Easy Return</p>
        <p><strong>Payment:</strong> Cash on Delivery Available</p>
      </div>
    </div>

  </div>
</div>

<script>
  // Highlight selected color button & update hidden input value
  const colorButtons = document.querySelectorAll('.color-btn');
  const selectedColorInput = document.getElementById('selected_color');

  function selectColor(btn) {
    colorButtons.forEach(b => b.classList.remove('border-blue-600'));
    btn.classList.add('border-blue-600');
    selectedColorInput.value = btn.getAttribute('data-color');
  }

  colorButtons.forEach((btn, idx) => {
    // Set first color as selected by default
    if (idx === 0) btn.classList.add('border-blue-600');

    btn.addEventListener('click', () => selectColor(btn));
  });
</script>

<?php include '../includes/footer.php'; ?>
