<?php
session_start();

// ✅ Ensure user is logged in
if (!isset($_SESSION['demo_user'])) {
    header("Location: login.php");
    exit;
}

// ✅ Get display name: username if set, else email
$display_name = isset($_SESSION['demo_username']) && !empty($_SESSION['demo_username'])
                ? $_SESSION['demo_username']
                : $_SESSION['demo_user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", sans-serif;
            background: linear-gradient(135deg, #1a1a1a, #222, #111);
            color: #f1f1f1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        header {
            width: 100%;
            background: rgba(255, 165, 0, 0.1);
            backdrop-filter: blur(10px);
            padding: 15px;
            text-align: center;
            border-bottom: 2px solid orange;
        }

        header h1 {
            margin: 0;
            font-size: 28px;
            color: orange;
            text-shadow: 0 0 10px #ff9900;
        }

        nav {
            margin: 20px auto;
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        nav a {
            text-decoration: none;
            color: #fff;
            padding: 12px 18px;
            border-radius: 30px;
            background: rgba(255, 165, 0, 0.15);
            border: 1px solid orange;
            transition: all 0.3s ease;
            font-weight: bold;
        }

        nav a:hover {
            background: orange;
            color: #111;
            transform: scale(1.1);
            box-shadow: 0 0 15px orange;
        }

        .container {
            margin-top: 40px;
            background: rgba(255, 255, 255, 0.05);
            padding: 25px;
            border-radius: 20px;
            width: 70%;
            text-align: center;
            box-shadow: 0 0 20px rgba(255,165,0,0.2);
        }

        .container p {
            font-size: 18px;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <header>
        <h1>🔥 Welcome, <?= htmlspecialchars($display_name); ?> 🔥</h1>
    </header>

    <nav>
        <a href="./Frst Folders/index.php">🏠 Home</a>
        <a href="./Frst Folders/about.php">ℹ️ About</a>
        <a href="./Frst Folders/services.php">🛠️ Services</a>
        <a href="./Frst Folders/game download.php">🎮 Game Download</a>
        <a href="./logout.php">🚪 Logout</a>
    </nav>

    <div class="container">
        <p>
            Welcome to your dashboard! Here you can access all the sections of the website easily. <br>
            Enjoy your stay, <?= htmlspecialchars($display_name); ?> 😎
        </p>
    </div>
</body>
</html>
