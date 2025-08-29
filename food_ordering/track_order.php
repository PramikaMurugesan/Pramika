<?php
session_start();
include 'db.php';

if (!isset($_GET['order_id'])) {
    header("Location: index.php");
    exit();
}

$order_id = $_GET['order_id'];
$result = $conn->query("SELECT * FROM orders WHERE id = $order_id");
$order = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Tracking</title>
    <link rel="stylesheet" href="trackstyle.css">
</head>
<body>

    <div class="tracking-container">
        <h2>Order #<?= $order['id'] ?> Tracking</h2>
        <p><strong>Status:</strong> <?= $order['status'] ?></p>
        <p><strong>Total:</strong> ₹<?= number_format($order['total'], 2) ?></p>
        <p><strong>Payment Method:</strong> <?= $order['payment_method'] ?></p> <!-- Payment Method added here -->
        <p><strong>Date:</strong> <?= $order['created_at'] ?></p>

        <h3>Thank you for ordering!</h3>
        <a href="index.html">Back to Home</a>
    </div>

</body>
</html>
