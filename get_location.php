<?php
require 'db.php';
$type = $_GET['type'];
$id = $_GET['id'];
$table = $type === 'ride' ? 'rides' : 'deliveries';
$stmt = $pdo->prepare("SELECT driver_id FROM $table WHERE id = ?");
$stmt->execute([$id]);
$request = $stmt->fetch();
if ($request && $request['driver_id']) {
    // Simulate driver location (in real app, this would come from driver's device)
    $lat = 6.5244 + (Math.random() - 0.5) * 0.01; // Simulate movement around Lagos
    $lng = 3.3792 + (Math.random() - 0.5) * 0.01;
    echo json_encode(['lat' => $lat, 'lng' => $lng]);
} else {
    echo json_encode(['lat' => 0, 'lng' => 0]);
}
?>
