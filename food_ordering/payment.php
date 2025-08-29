<?php
session_start();
include 'db.php';

if (!isset($_SESSION['order_id'])) {
    //header("Location: cart.php");
    header("Location: packaging_options.php");
    exit();
}

$order_id = $_SESSION['order_id'];
$total = $_SESSION['total'];
?>

<!DOCTYPE html>
<html>
<head>
  <title>Payment</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      background: #fff8f7;
      font-family: Arial;
      text-align: center;
      padding: 50px;
    }
    .payment-container {
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 12px rgba(0,0,0,0.1);
      max-width: 400px;
      margin: 0 auto;
    }
    .pay-option {
      margin: 20px 0;
    }
    button {
      background: #e23744;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
  </style>
</head>
<body>

<div class="payment-container">
  <h2>Choose Your Payment Method</h2>
  <p><strong>Total: ₹<?= number_format($total, 2) ?></strong></p>

  <form method="POST" action="place_payment.php">
    <div class="pay-option">
      <input type="radio" name="payment_method" value="Cash on Delivery" required> Cash on Delivery
    </div>
    <div class="pay-option">
      <input type="radio" name="payment_method" value="GPay"> GPay (simulate)
    </div>
    <div class="pay-option">
      <input type="radio" name="payment_method" value="PhonePe"> PhonePe (simulate)
    </div>
    <br>
    <button type="submit">Confirm Payment</button>
  </form>
</div>

</body>
</html>
