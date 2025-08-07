<?php
require 'db.php';
if (!isset($_GET['type']) || !isset($_GET['id'])) {
    echo "<script>window.location.href='index.php';</script>";
}
$type = $_GET['type'];
$id = $_GET['id'];
$table = $type === 'ride' ? 'rides' : 'deliveries';
$stmt = $pdo->prepare("SELECT * FROM $table WHERE id = ?");
$stmt->execute([$id]);
$request = $stmt->fetch();
if (!$request) {
    echo "<script>window.location.href='index.php';</script>";
}
$driver_id = $request['driver_id'];
$driver = null;
if ($driver_id) {
    $stmt = $pdo->prepare("SELECT name FROM drivers WHERE id = ?");
    $stmt->execute([$driver_id]);
    $driver = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track <?php echo ucfirst($type); ?> - Yango Clone</title>
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
        .track-container {
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
        .info p {
            margin: 10px 0;
            font-size: 16px;
        }
        #map {
            height: 300px;
            background: #eee;
            border-radius: 5px;
        }
        @media (max-width: 480px) {
            .track-container {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Track <?php echo ucfirst($type); ?></h1>
    </header>
    <div class="track-container">
        <h2><?php echo ucfirst($type); ?> Details</h2>
        <div class="info">
            <p><strong>Pickup:</strong> <?php echo htmlspecialchars($request['pickup_location']); ?></p>
            <p><strong>Drop-off:</strong> <?php echo htmlspecialchars($request['dropoff_location']); ?></p>
            <?php if ($type === 'delivery'): ?>
            <p><strong>Package Details:</strong> <?php echo htmlspecialchars($request['package_details']); ?></p>
            <?php endif; ?>
            <p><strong>Fare:</strong> $<?php echo number_format($request['fare'], 2); ?></p>
            <p><strong>Status:</strong> <?php echo ucfirst($request['status']); ?></p>
            <?php if ($driver): ?>
            <p><strong>Driver:</strong> <?php echo htmlspecialchars($driver['name']); ?></p>
            <?php endif; ?>
        </div>
        <div id="map">Map Placeholder (Driver Location)</div>
    </div>
    <script>
        function updateLocation() {
            // Simulate driver location update
            fetch('get_location.php?type=<?php echo $type; ?>&id=<?php echo $id; ?>')
                .then(response => response.json())
                .then(data => {
                    const map = document.getElementById('map');
                    map.innerText = `Driver at: (${data.lat}, ${data.lng})`;
                })
                .catch(error => console.error('Error:', error));
        }
        setInterval(updateLocation, 5000);
        updateLocation();
    </script>
</body>
</html>
