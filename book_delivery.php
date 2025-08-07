<?php
require 'db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    echo "<script>window.location.href='login.php';</script>";
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pickup = $_POST['pickup'];
    $dropoff = $_POST['dropoff'];
    $package_details = $_POST['package_details'];
    $distance = floatval($_POST['distance']);
    $fare = $distance * 3.0; // Different rate for deliveries
    $stmt = $pdo->prepare("INSERT INTO deliveries (user_id, pickup_location, dropoff_location, package_details, fare) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $pickup, $dropoff, $package_details, $fare]);
    $delivery_id = $pdo->lastInsertId();
    echo "<script>alert('Delivery booked! Fare: $$fare'); window.location.href='track.php?type=delivery&id=$delivery_id';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Delivery - Yango Clone</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f4f4f4;
        }
        header {
            background: linear-gradient(90deg, #ffcc00, #ff9900);
            color: white;
            padding: 20px;
            text-align: center;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        h2 {
            color: #333;
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #ffcc00;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #ff9900;
        }
        @media (max-width: 480px) {
            .form-container {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Book a Delivery</h1>
    </header>
    <div class="form-container">
        <h2>Delivery Booking</h2>
        <form method="POST">
            <div class="form-group">
                <label>Pickup Location</label>
                <input type="text" name="pickup" required>
            </div>
            <div class="form-group">
                <label>Drop-off Location</label>
                <input type="text" name="dropoff" required>
            </div>
            <div class="form-group">
                <label>Package Details</label>
                <textarea name="package_details" required></textarea>
            </div>
            <div class="form-group">
                <label>Distance (km)</label>
                <input type="number" name="distance" step="0.1" required>
            </div>
            <button type="submit">Book Delivery</button>
        </form>
    </div>
</body>
</html>
