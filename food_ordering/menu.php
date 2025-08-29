<?php
include 'db.php';
session_start();

// Add to cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['menu_id'])) {
    $id = $_POST['menu_id'];
    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    $_SESSION['cart'][] = $id;
}

// Get all menu items
$result = $conn->query("SELECT * FROM menu ORDER BY category, name");
$menu_items = [];
while ($row = $result->fetch_assoc()) {
    $menu_items[$row['category']][] = $row;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Explore Menu | FoodieZ</title>
  <link rel="stylesheet" href="menustyle.css">
</head>
<body>

<header>
  <h1>Our Menu</h1>
  <nav>
    <a href="index.html">Home</a>
    <a href="cart.php">Cart 🛒</a>
  </nav>
</header>

<div class="menu-container">
<?php foreach ($menu_items as $category => $items): ?>
  <h2 class="category"><?= htmlspecialchars($category) ?></h2>
  <div class="menu-grid">
    <?php foreach ($items as $item): ?>
      <div class="menu-card">
        <img src="<?= $item['image'] ?>" alt="<?= $item['name'] ?>">
        <h3><?= htmlspecialchars($item['name']) ?></h3>
        <p>₹<?= number_format($item['price'], 2) ?></p>
        <form method="POST">
          <input type="hidden" name="menu_id" value="<?= $item['id'] ?>">
          <button type="submit">Add to Cart</button>
        </form>
      </div>
    <?php endforeach; ?>
  </div>
<?php endforeach; ?>
</div>

</body>
</html>
