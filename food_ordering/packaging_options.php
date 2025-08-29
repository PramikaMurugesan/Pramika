<?php
session_start();
include 'db.php';

// This file would typically be visited after placing the order
if (!isset($_SESSION['order_id']) || !isset($_SESSION['total'])) {
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Packaging Options | FoodieZ</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      background: #f5f5f5;
      font-family: 'Poppins', sans-serif;
      padding: 40px;
    }

    .package-container {
      background: #fff;
      padding: 30px;
      max-width: 600px;
      margin: auto;
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: #333;
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-top: 15px;
      font-weight: 500;
    }

    select, input[type="number"] {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 8px;
    }

    .choice-box {
      margin-top: 20px;
    }

    .submit-btn {
      margin-top: 30px;
      background: #e23744;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      width: 100%;
      font-size: 16px;
    }

    .submit-btn:hover {
      background: #c41f2d;
    }
  </style>
</head>
<body>

<div class="package-container">
  <h2>Choose Packaging Preferences</h2>

  <form action="payment.php" method="POST">
    <!-- Bag Type -->
    <label for="bag">Select Bag Type</label>
    <select name="bag" id="bag" required>
      <option value="">-- Choose Bag --</option>
      <option value="Insulated Hot Bag">Insulated Hot Bag</option>
      <option value="Cold Bag">Cold Bag</option>
    </select>

    <!-- Package Type -->
    <label for="package">Select Package Type</label>
    <select name="package" id="package" required>
      <option value="">-- Choose Package --</option>
      <option value="Tamper Proof">Tamper Proof</option>
      <option value="Recycling Container">Recycling Container</option>
    </select>

    <!-- Temperature Check -->
    <div class="choice-box">
      <label for="temperature">Enter Food Temperature (°C)</label>
      <input type="number" name="temperature" id="temperature" step="0.1" required>

      <label for="food_type">Food Type</label>
      <select name="food_type" id="food_type" required>
        <option value="">-- Choose Food Type --</option>
        <option value="Hot">Hot Food</option>
        <option value="Cold">Cold Food</option>
      </select>
    </div>

    <div class="choice-box">
      <label>Acceptability:</label>
      <p id="acceptability-status" style="font-weight: bold;">-- Waiting for input --</p>
    </div>

    <button type="submit" class="submit-btn">Continue to Payment</button>
  </form>
</div>

<script>
  const tempInput = document.getElementById("temperature");
  const foodType = document.getElementById("food_type");
  const statusText = document.getElementById("acceptability-status");

  function checkAcceptability() {
    const temp = parseFloat(tempInput.value);
    const type = foodType.value;

    if (!isNaN(temp) && type) {
      if (type === "Hot") {
        statusText.textContent = temp >= 63 ? "✅ Acceptable" : "❌ Not Acceptable";
        statusText.style.color = temp >= 63 ? "green" : "red";
      } else if (type === "Cold") {
        statusText.textContent = temp <= 7.7 ? "✅ Acceptable" : "❌ Not Acceptable"; // 46°F = ~7.7°C
        statusText.style.color = temp <= 7.7 ? "green" : "red";
      }
    } else {
      statusText.textContent = "-- Waiting for input --";
      statusText.style.color = "black";
    }
  }

  tempInput.addEventListener("input", checkAcceptability);
  foodType.addEventListener("change", checkAcceptability);
</script>

</body>
</html>
