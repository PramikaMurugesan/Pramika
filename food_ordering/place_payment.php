<?php
session_start();
include 'db.php';

if (!isset($_SESSION['order_id']) || !isset($_POST['payment_method'])) {
    header("Location: packaging_options.php");
    exit;
}

$order_id = $_SESSION['order_id'];
$payment_method = $_POST['payment_method'];

// Update the existing order with the payment method
$conn->query("UPDATE orders SET payment_method = '$payment_method' WHERE id = $order_id");

// Redirect to tracking
header("Location: track_order.php?order_id=$order_id");
exit;
?>
