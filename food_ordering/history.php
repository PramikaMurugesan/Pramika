<?php
session_start();
include 'db.php';

//if (!isset($_SESSION['user_id'])) {
//    header("Location: login.php");
//    exit();
//}
$_SESSION['user_id'] = 1;
$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT id, total, status, payment_method, created_at FROM orders WHERE user_id = $user_id");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order History</title>
    <link rel="stylesheet" href="historystyle.css">
</head>
<body>

    <div class="history-container">
        <h2>Your Order History</h2>

        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="order">
                <p><strong>Order ID:</strong> <?= $row['id'] ?></p>
                <p><strong>Status:</strong> <?= $row['status'] ?></p>
                <p><strong>Total:</strong> ₹<?= number_format($row['total'], 2) ?></p>
                <p><strong>Payment Method:</strong> <?= $row['payment_method'] ?></p> <!-- Payment Method here -->
                <p><strong>Date:</strong> <?= $row['created_at'] ?></p>
            </div>
            <hr>
        <?php endwhile; ?>

    </div>

</body>
</html>
