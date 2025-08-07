<?php
require 'db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    echo "<script>window.location.href='login.php';</script>";
}
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Yango Clone</title>
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
        .profile-container {
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
        .info {
            margin-bottom: 20px;
        }
        .info p {
            margin: 10px 0;
            font-size: 16px;
        }
        button {
            padding: 10px 20px;
            background: #ffcc00;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #ff9900;
        }
        @media (max-width: 480px) {
            .profile-container {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>User Profile</h1>
    </header>
    <div class="profile-container">
        <h2>Welcome, <?php echo htmlspecialchars($user['name']); ?></h2>
        <div class="info">
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
            <p><strong>Wallet Balance:</strong> $<?php echo number_format($user['wallet_balance'], 2); ?></p>
        </div>
        <button onclick="window.location.href='book_ride.php'">Book a Ride</button>
        <button onclick="window.location.href='book_delivery.php'">Book a Delivery</button>
        <button onclick="window.location.href='logout.php'">Logout</button>
    </div>
</body>
</html>
