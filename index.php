<?php require 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yango Clone - Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background: linear-gradient(90deg, #ffcc00, #ff9900);
            color: white;
            padding: 20px;
            text-align: center;
        }
        nav {
            display: flex;
            justify-content: center;
            background: #333;
            padding: 10px;
        }
        nav a {
            color: white;
            margin: 0 20px;
            text-decoration: none;
            font-weight: bold;
        }
        nav a:hover {
            color: #ffcc00;
        }
        .hero {
            text-align: center;
            padding: 50px;
            background: url('https://source.unsplash.com/random/1600x900/?city') no-repeat center;
            background-size: cover;
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
        }
        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }
        .hero button {
            padding: 15px 30px;
            background: #ffcc00;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .hero button:hover {
            background: #ff9900;
        }
        .features {
            display: flex;
            justify-content: space-around;
            padding: 50px;
        }
        .feature {
            text-align: center;
            width: 30%;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        @media (max-width: 768px) {
            .features {
                flex-direction: column;
                align-items: center;
            }
            .feature {
                width: 80%;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Yango Clone</h1>
    </header>
    <nav>
        <a href="#" onclick="window.location.href='signup.php'">Sign Up</a>
        <a href="#" onclick="window.location.href='login.php'">Login</a>
        <a href="#" onclick="window.location.href='book_ride.php'">Book Ride</a>
        <a href="#" onclick="window.location.href='book_delivery.php'">Book Delivery</a>
    </nav>
    <div class="hero">
        <h1>Ride or Send with Ease</h1>
        <p>Book rides or deliver parcels with our seamless platform!</p>
        <button onclick="window.location.href='book_ride.php'">Get Started</button>
    </div>
    <div class="features">
        <div class="feature">
            <h2>Ride-Hailing</h2>
            <p>Book a ride in seconds and track your driver in real-time.</p>
        </div>
        <div class="feature">
            <h2>Parcel Delivery</h2>
            <p>Send packages with reliable tracking and fast delivery.</p>
        </div>
        <div class="feature">
            <h2>Driver Support</h2>
            <p>Join as a driver and manage ride or delivery requests.</p>
        </div>
    </div>
</body>
</html>
