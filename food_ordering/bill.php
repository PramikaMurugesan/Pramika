<?php
session_start();
include 'db.php';

if (!isset($_SESSION['order_id'])) {
    header("Location: cart.php");
    exit();
}

$order_id = $_SESSION['order_id'];
$result = $conn->query("SELECT * FROM orders WHERE id = $order_id");
$order = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Bill</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="bill-container">
        <h2>Order Bill</h2>
        <p><strong>Order ID:</strong> <?= $order['id'] ?></p>
        <p><strong>Status:</strong> <?= $order['status'] ?></p>
        <p><strong>Total:</strong> ₹<?= number_format($order['total'], 2) ?></p>
        <p><strong>Payment Method:</strong> <?= $order['payment_method'] ?></p> <!-- Payment Method added here -->
        <p><strong>Date:</strong> <?= $order['created_at'] ?></p>

        <h3>Thank you for ordering!</h3>
        <a href="index.php">Back to Home</a>
    </div>

</body>
</html>
