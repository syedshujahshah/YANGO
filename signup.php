<?php
require 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $phone = $_POST['phone'];
        $type = $_POST['type'];
        
        if ($type === 'user') {
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, phone) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $password, $phone]);
        } else {
            $vehicle_type = $_POST['vehicle_type'];
            $license_number = $_POST['license_number'];
            $stmt = $pdo->prepare("INSERT INTO drivers (name, email, password, phone, vehicle_type, license_number) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $email, $password, $phone, $vehicle_type, $license_number]);
        }
        echo "<script>alert('Registration successful!'); window.location.href='login.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error: " . addslashes($e->getMessage()) . "'); window.location.href='signup.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Yango Clone</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .signup-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            width: 400px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        input, select {
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
            .signup-container {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h2>Sign Up</h2>
        <form method="POST">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" required>
            </div>
            <div class="form-group">
                <label>User Type</label>
                <select name="type" onchange="toggleDriverFields(this)">
                    <option value="user">User</option>
                    <option value="driver">Driver</option>
                </select>
            </div>
            <div class="form-group driver-field" style="display: none;">
                <label>Vehicle Type</label>
                <input type="text" name="vehicle_type">
            </div>
            <div class="form-group driver-field" style="display: none;">
                <label>License Number</label>
                <input type="text" name="license_number">
            </div>
            <button type="submit">Sign Up</button>
        </form>
        <p style="text-align: center; margin-top: 10px;">
            Already have an account? <a href="#" onclick="window.location.href='login.php'">Login</a>
        </p>
    </div>
    <script>
        function toggleDriverFields(select) {
            const driverFields = document.querySelectorAll('.driver-field');
            driverFields.forEach(field => {
                field.style.display = select.value === 'driver' ? 'block' : 'none';
            });
        }
    </script>
</body>
</html>
