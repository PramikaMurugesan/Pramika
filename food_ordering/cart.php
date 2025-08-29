<?php
session_start();
include 'db.php';

// Remove item
if (isset($_GET['remove'])) {
    $id = $_GET['remove'];
    if (($key = array_search($id, $_SESSION['cart'])) !== false) {
        unset($_SESSION['cart'][$key]);
    }
}

// Clear cart
if (isset($_GET['clear'])) {
    unset($_SESSION['cart']);
}

// Count items
$cart_items = $_SESSION['cart'] ?? [];
$quantities = array_count_values($cart_items);

// Fetch details from DB
$items = [];
$total = 0;

if (!empty($quantities)) {
    $ids = implode(',', array_map('intval', array_keys($quantities)));
    $result = $conn->query("SELECT * FROM menu WHERE id IN ($ids)");
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $row['qty'] = $quantities[$id];
        $row['total'] = $row['qty'] * $row['price'];
        $total += $row['total'];
        $items[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Your Cart | FoodieZ</title>
  <link rel="stylesheet" href="cartstyle.css">
</head>
<body>

<header>
  <h1>Your Cart 🛒</h1>
  <nav>
    <a href="menu.php">← Back to Menu</a>
    <a href="index.html">Home</a>
  </nav>
</header>

<div class="cart-container">
<?php if (empty($items)): ?>
  <p class="empty">Your cart is empty 😕</p>
<?php else: ?>
  <table class="cart-table">
    <tr>
      <th>Image</th>
      <th>Item</th>
      <th>Qty</th>
      <th>Price</th>
      <th>Total</th>
      <th>Action</th>
    </tr>
    <?php foreach ($items as $item): ?>
    <tr>
      <td><img src="<?= $item['image'] ?>" height="60"></td>
      <td><?= $item['name'] ?></td>
      <td><?= $item['qty'] ?></td>
      <td>₹<?= number_format($item['price'], 2) ?></td>
      <td>₹<?= number_format($item['total'], 2) ?></td>
      <td><a href="?remove=<?= $item['id'] ?>" class="remove-btn">Remove</a></td>
    </tr>
    <?php endforeach; ?>
  </table>

  <div class="cart-summary">
    <h3>Subtotal: ₹<?= number_format($total, 2) ?></h3>
    <a href="place_order.php" class="btn">Place Order 🧾</a>
    <a href="?clear=1" class="btn cancel">Clear Cart ❌</a>
  </div>
<?php endif; ?>
</div>

</body>
</html>
