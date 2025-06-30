<?php
session_start();
include '../includes/db.php';  // your PDO connection

// Fetch counts and sums from orders table
$totalServices = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$totalCustomers = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'user'")->fetchColumn();
$totalOrders = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$totalRevenue = $pdo->query("SELECT SUM(total_amount) FROM orders WHERE status = 'approved'")->fetchColumn() ?: 0;

// Fetch monthly revenue data for approved orders
$monthlyStmt = $pdo->query("
  SELECT DATE_FORMAT(created_at, '%b') AS month, SUM(total_amount) AS total
  FROM orders
  WHERE status = 'approved'
  GROUP BY MONTH(created_at)
  ORDER BY MONTH(created_at)
");

$months = [];
$monthlyRevenue = [];
while ($row = $monthlyStmt->fetch()) {
    $months[] = $row['month'];
    $monthlyRevenue[] = (float)$row['total'];
}

// Fetch status counts for pie chart
$statusData = $pdo->query("
  SELECT status, COUNT(*) AS count
  FROM orders
  GROUP BY status
")->fetchAll(PDO::FETCH_KEY_PAIR);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>DiwakarSewa Admin Dashboard</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex bg-gray-100 min-h-screen">

  <!-- Sidebar -->
  <aside class="w-64 bg-blue-900 text-white min-h-screen p-4">
    <h1 class="text-2xl font-bold mb-6">DiwakarSewa</h1>
    <nav class="space-y-4">
      <a href="dashboard.php" class="block hover:bg-blue-700 px-3 py-2 rounded">Dashboard</a>
      <a href="services.php" class="block hover:bg-blue-700 px-3 py-2 rounded">Service Management</a>
      <a href="customers.php" class="block hover:bg-blue-700 px-3 py-2 rounded">Customer Management</a>
      <a href="orders.php" class="block hover:bg-blue-700 px-3 py-2 rounded">Order Management</a>
      <a href="logout.php" class="block hover:bg-blue-700 px-3 py-2 rounded">Logout</a>
    </nav>
  </aside>

  <!-- Main content -->
  <main class="flex-1 p-6">
    <h2 class="text-3xl font-bold mb-6">Dashboard</h2>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
      <div class="bg-white p-4 rounded shadow text-center">
        <h3 class="text-gray-500">Total Services</h3>
        <p class="text-2xl font-bold text-blue-900"><?= $totalServices ?></p>
      </div>
      <div class="bg-white p-4 rounded shadow text-center">
        <h3 class="text-gray-500">Total Customers</h3>
        <p class="text-2xl font-bold text-blue-900"><?= $totalCustomers ?></p>
      </div>
      <div class="bg-white p-4 rounded shadow text-center">
        <h3 class="text-gray-500">Total Orders</h3>
        <p class="text-2xl font-bold text-blue-900"><?= $totalOrders ?></p>
      </div>
      <div class="bg-white p-4 rounded shadow text-center">
        <h3 class="text-gray-500">Revenue</h3>
        <p class="text-2xl font-bold text-green-600">Rs. <?= number_format($totalRevenue, 2) ?></p>
      </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <div class="bg-white p-4 rounded shadow">
        <h3 class="text-lg font-semibold mb-2">Monthly Revenue</h3>
        <canvas id="barChart"></canvas>
      </div>
      <div class="bg-white p-4 rounded shadow">
        <h3 class="text-lg font-semibold mb-2">Order Status</h3>
        <canvas id="pieChart"></canvas>
      </div>
    </div>
  </main>

  <script>
    const barChart = new Chart(document.getElementById('barChart'), {
      type: 'bar',
      data: {
        labels: <?= json_encode($months) ?>,
        datasets: [{
          label: 'Revenue',
          data: <?= json_encode($monthlyRevenue) ?>,
          backgroundColor: 'rgba(59, 130, 246, 0.7)'
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: false }
        }
      }
    });

    const pieChart = new Chart(document.getElementById('pieChart'), {
      type: 'pie',
      data: {
        labels: <?= json_encode(array_keys($statusData)) ?>,
        datasets: [{
          data: <?= json_encode(array_values($statusData)) ?>,
          backgroundColor: ['#facc15', '#10b981', '#ef4444']
        }]
      },
      options: {
        responsive: true
      }
    });
  </script>

</body>
</html>
