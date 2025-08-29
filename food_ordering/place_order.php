<?php
session_start();
include 'db.php';

$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    header("Location: cart.php");
    exit;
}

$quantities = array_count_values($cart);
$menu_ids = implode(',', array_keys($quantities));
$result = $conn->query("SELECT * FROM menu WHERE id IN ($menu_ids)");

$total = 0;
$items = [];
while ($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $qty = $quantities[$id];
    $price = $row['price'];
    $total += $price * $qty;
    $items[] = ['id' => $id, 'qty' => $qty];
}

// Save order
$conn->query("INSERT INTO orders (total) VALUES ($total)");
$order_id = $conn->insert_id;

// Save items
foreach ($items as $item) {
    $menu_id = $item['id'];
    $qty = $item['qty'];
    $conn->query("INSERT INTO order_items (order_id, menu_id, quantity) VALUES ($order_id, $menu_id, $qty)");
}

// Clear cart
unset($_SESSION['cart']);

// Set order in session
$_SESSION['order_id'] = $order_id;
$_SESSION['total'] = $total;

header("Location: packaging_options.php");
exit;

// Redirect to payment page
header("Location: payment.php");
exit;

// Redirect to tracking
header("Location: track_order.php?order_id=$order_id");
exit;
?>
