<?php
include '../includes/db.php';
include '../includes/header.php';

// Initialize filters
$search = $_GET['search'] ?? '';
$brand = $_GET['brand'] ?? '';
$ram = $_GET['ram'] ?? '';
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';

$conditions = [];
$params = [];

// Search condition
if (!empty($search)) {
  $conditions[] = "(name LIKE :search OR brand LIKE :search)";
  $params['search'] = "%$search%";
}

// Brand filter
if (!empty($brand)) {
  $conditions[] = "brand = :brand";
  $params['brand'] = $brand;
}

// RAM filter
if (!empty($ram)) {
  $conditions[] = "ram = :ram";
  $params['ram'] = $ram;
}

// Price filters
if (!empty($min_price)) {
  $conditions[] = "price >= :min_price";
  $params['min_price'] = $min_price;
}
if (!empty($max_price)) {
  $conditions[] = "price <= :max_price";
  $params['max_price'] = $max_price;
}

$where = $conditions ? "WHERE " . implode(" AND ", $conditions) : "";
$sql = "SELECT * FROM products $where";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();

// For filter options
$brands = $pdo->query("SELECT DISTINCT brand FROM products")->fetchAll(PDO::FETCH_COLUMN);
$rams = $pdo->query("SELECT DISTINCT ram FROM products")->fetchAll(PDO::FETCH_COLUMN);
?>

<!-- 🔍 Search + Filter Bar -->
<div class="grid md:grid-cols-4 gap-6 p-4">
  <!-- Filter Sidebar -->
  <form method="GET" class="bg-white p-4 rounded shadow space-y-4 md:col-span-1">
    <h2 class="text-xl font-bold mb-2 text-blue-900">Filter</h2>

    <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search..." class="w-full border rounded px-3 py-2">

    <div>
      <label class="font-semibold">Brand:</label>
      <select name="brand" class="w-full border px-2 py-1 rounded">
        <option value="">All</option>
        <?php foreach ($brands as $b): ?>
          <option value="<?= $b ?>" <?= $b == $brand ? 'selected' : '' ?>><?= $b ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div>
      <label class="font-semibold">RAM:</label>
      <select name="ram" class="w-full border px-2 py-1 rounded">
        <option value="">All</option>
        <?php foreach ($rams as $r): ?>
          <option value="<?= $r ?>" <?= $r == $ram ? 'selected' : '' ?>><?= $r ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div>
      <label class="font-semibold">Price Range:</label>
      <div class="flex gap-2">
        <input type="number" name="min_price" placeholder="Min" value="<?= htmlspecialchars($min_price) ?>" class="w-1/2 border px-2 py-1 rounded">
        <input type="number" name="max_price" placeholder="Max" value="<?= htmlspecialchars($max_price) ?>" class="w-1/2 border px-2 py-1 rounded">
      </div>
    </div>

    <button type="submit" class="w-full bg-blue-900 text-white px-4 py-2 rounded hover:bg-blue-700">Apply</button>
    <a href="products.php" class="block text-center text-sm text-blue-700 underline">Reset</a>
  </form>

  <!-- 🛍 Product Grid -->
  <div class="md:col-span-3">
    <h1 class="text-2xl font-bold mb-4 text-center">Smartphones For You</h1>

    <?php if (count($products) === 0): ?>
      <p class="text-center text-red-600 font-semibold">No results found.</p>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php foreach ($products as $row): ?>
        <div class="border p-4 rounded shadow hover:shadow-lg transition duration-300 bg-white">
          <a href="/diwakarsewa/pages/product_detail.php?id=<?= (int)$row['id'] ?>">
            <img src="../assets/<?= htmlspecialchars($row['image']) ?>"
                 alt="<?= htmlspecialchars($row['name']) ?>"
                 class="w-full h-48 object-cover mb-3 rounded hover:scale-105 transform transition duration-300">
          </a>
          <a href="/diwakarsewa/pages/product_detail.php?id=<?= (int)$row['id'] ?>">
            <h2 class="text-xl font-semibold hover:underline text-blue-900"><?= htmlspecialchars($row['name']) ?></h2>
          </a>
          <p class="text-sm text-gray-500 mb-1">Brand: <?= htmlspecialchars($row['brand']) ?></p>
          <p class="text-sm text-gray-500 mb-1">RAM: <?= htmlspecialchars($row['ram']) ?> | Storage: <?= htmlspecialchars($row['storage']) ?></p>
          <p class="text-sm text-gray-500 mb-1">Camera: <?= htmlspecialchars($row['camera']) ?></p>
          <p class="font-bold text-lg text-blue-900 mb-2">Rs. <?= number_format($row['price'], 2) ?></p>

          <form action="/diwakarsewa/actions/add_to_cart.php" method="POST">
            <input type="hidden" name="product_id" value="<?= (int)$row['id'] ?>">
            <input type="hidden" name="price" value="<?= (float)$row['price'] ?>">
            <label class="text-sm">Quantity:</label>
            <input type="number" name="quantity" value="1" min="1" required class="border px-2 py-1 w-16 ml-2 rounded">
            <button type="submit" class="mt-2 bg-blue-900 text-white px-4 py-2 rounded hover:bg-blue-700">Add to Cart</button>
          </form>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
