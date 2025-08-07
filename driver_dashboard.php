<?php
require 'db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'driver') {
    echo "<script>window.location.href='login.php';</script>";
}
$stmt = $pdo->prepare("SELECT r.*, u.name AS user_name FROM rides r JOIN users u ON r.user_id = u.id WHERE r.status = 'pending'");
$stmt->execute();
$rides = $stmt->fetchAll();
$stmt = $pdo->prepare("SELECT d.*, u.name AS user_name FROM deliveries d JOIN users u ON d.user_id = u.id WHERE d.status = 'pending'");
$stmt->execute();
$deliveries = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $type = $_POST['type'];
    $action = $_POST['action'];
    $table = $type === 'ride' ? 'rides' : 'deliveries';
    $status = $action === 'accept' ? 'accepted' : 'cancelled';
    $stmt = $pdo->prepare("UPDATE $table SET driver_id = ?, status = ? WHERE id = ?");
    $stmt->execute([$_SESSION['user_id'], $status, $id]);
    echo "<script>alert('Request $action!'); window.location.href='driver_dashboard.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Dashboard - Yango Clone</title>
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
        .dashboard {
            max-width: 800px;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background: #ffcc00;
            color: white;
        }
        button {
            padding: 5px 10px;
            background: #ffcc00;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            margin-right: 5px;
            transition: background 0.3s;
        }
        button:hover {
            background: #ff9900;
        }
        @media (max-width: 768px) {
            .dashboard {
                width: 90%;
            }
            table {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Driver Dashboard</h1>
    </header>
    <div class="dashboard">
        <h2>Pending Requests</h2>
        <h3>Rides</h3>
        <table>
            <tr><th>User</th><th>Pickup</th><th>Drop-off</th><th>Fare</th><th>Actions</th></tr>
            <?php foreach ($rides as $ride): ?>
            <tr>
                <td><?php echo htmlspecialchars($ride['user_name']); ?></td>
                <td><?php echo htmlspecialchars($ride['pickup_location']); ?></td>
                <td><?php echo htmlspecialchars($ride['dropoff_location']); ?></td>
                <td>$<?php echo number_format($ride['fare'], 2); ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $ride['id']; ?>">
                        <input type="hidden" name="type" value="ride">
                        <button type="submit" name="action" value="accept">Accept</button>
                        <button type="submit" name="action" value="cancel">Cancel</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <h3>Deliveries</h3>
        <table>
            <tr><th>User</th><th>Pickup</th><th>Drop-off</th><th>Details</th><th>Fare</th><th>Actions</th></tr>
            <?php foreach ($deliveries as $delivery): ?>
            <tr>
                <td><?php echo htmlspecialchars($delivery['user_name']); ?></td>
                <td><?php echo htmlspecialchars($delivery['pickup_location']); ?></td>
                <td><?php echo htmlspecialchars($delivery['dropoff_location']); ?></td>
                <td><?php echo htmlspecialchars($delivery['package_details']); ?></td>
                <td>$<?php echo number_format($delivery['fare'], 2); ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $delivery['id']; ?>">
                        <input type="hidden" name="type" value="delivery">
                        <button type="submit" name="action" value="accept">Accept</button>
                        <button type="submit" name="action" value="cancel">Cancel</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <button onclick="window.location.href='logout.php'" style="margin-top: 20px;">Logout</button>
    </div>
</body>
</html>
