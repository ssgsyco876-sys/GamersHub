<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Services | Gamers Rise</title>
  <link rel="icon" href="./images/logo.png" type="image/png" />
  <link rel="stylesheet" href="./style.css">
  <style>
    /* Reset & Base */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background-color: #0d0d0d;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: white;
    }

    /* Navigation */
    nav {
      background-color: #000000aa;
      padding: 15px 0;
      box-shadow: 0 0 20px #00ffff55;
    }

    nav ul {
      display: flex;
      justify-content: center;
      gap: 25px;
      list-style: none;
    }

    nav ul li a {
      text-decoration: none;
      padding: 10px 20px;
      display: inline-block;
      font-weight: bold;
      font-size: 20px;
      border-radius: 10px;
      background-color: #000000cc;
      color: #00ffff;
      text-shadow: 0 0 10px #00ffff, 0 0 20px #00ffff;
      transition: background-color 0.3s, transform 0.3s;
    }

    nav ul li a:hover {
      background-color: #002f3d;
      transform: scale(1.1);
      color: #ffffff;
    }

    /* Header */
    header {
      background: linear-gradient(145deg, #0d1e25, #0f2e39);
      padding: 30px 20px;
      text-align: center;
      box-shadow: 0 0 20px #00fff7;
    }

    header h1 {
      font-size: 36px;
      color: #00fff7;
      margin-bottom: 10px;
      animation: glow 3s infinite ease-in-out;
    }

    header p {
      font-size: 16px;
      color: #c2d4d9;
      margin-bottom: 20px;
    }

    .hero-buttons {
      display: flex;
      justify-content: center;
      gap: 15px;
      flex-wrap: wrap;
    }

    .btn-glow {
      padding: 10px 20px;
      font-size: 16px;
      color: #00fff7;
      border: 2px solid #00fff7;
      border-radius: 30px;
      background: transparent;
      text-decoration: none;
      transition: 0.3s;
      box-shadow: 0 0 10px #00fff7;
    }

    .btn-glow:hover {
      background: #00fff7;
      color: #000;
      box-shadow: 0 0 20px #00fff7;
    }

    @keyframes glow {
      0% { text-shadow: 0 0 5px #00ffcc, 0 0 10px #00ffcc; }
      50% { text-shadow: 0 0 15px #00ffcc, 0 0 25px #00ffcc; }
      100% { text-shadow: 0 0 5px #00ffcc, 0 0 10px #00ffcc; }
    }

    /* Services Section */
    .services-section {
      text-align: center;
      padding: 60px 20px;
      background: linear-gradient(145deg, #0d1e25, #0f2e39);
    }

    .services-section h2 {
      font-size: 42px;
      color: #00fff7;
      text-shadow: 0 0 15px #00fff7, 0 0 30px #00fff7;
      margin-bottom: 40px;
    }

    .service-boxes {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 30px;
    }

    .service-box {
      background: #050c0e;
      border: 2px solid #00fff7;
      border-radius: 20px;
      padding: 25px 30px;
      max-width: 280px;
      color: #dff;
      box-shadow: 0 0 15px #00fff7;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .service-box:hover {
      transform: translateY(-10px);
      box-shadow: 0 0 25px #00fff7, 0 0 40px #00fff7;
    }

    /* Make entire box clickable */
    .service-box a {
      display: block;
      color: inherit;
      text-decoration: none;
    }

    .service-box a:hover {
      color: inherit;
    }

    .service-box h3 {
      font-size: 22px;
      color: #00fff7;
      margin-bottom: 10px;
    }

    .service-box p {
      font-size: 15px;
      color: #c2d4d9;
    }

    /* Footer */
    footer {
      background: #050c0e;
      color: #88a;
      text-align: center;
      padding: 15px;
      font-size: 14px;
      margin-top: 40px;
      box-shadow: 0 -2px 15px #00fff7;
    }
  </style>
</head>
<body>

<header>
  <h1>Welcome to GameVerse</h1>
  <p>Your ultimate portal for skins, mods, hacks, and pro tips!</p>
  <div class="hero-buttons">
    <a href="./index.php" class="btn-glow">Home</a>
    <a href="./about.php" class="btn-glow">About</a>
    <a href="./services.php" class="btn-glow">Services</a>
    <a href="./game download.php" class="btn-glow">Game Download</a>
  </div>
</header>

<section class="services-section">
  <h2>Our Services</h2>
  <div class="service-boxes">
    <div class="service-box">
      <a href="skins.html">
        <h3>🎯 Skin Tools</h3>
        <p>Unlock exclusive skins for all your favorite games.</p>
      </a>
    </div>
    <div class="service-box">
      <a href="./passwords.php">
        <h3>🔑 SkinTool Passwords</h3>
        <p>Save, retrieve, and manage your game credentials securely.</p>
      </a>
    </div>
    <div class="service-box">
      <a href="./hints.php">
        <h3>📜 Tips & Tricks</h3>
        <p>Pro-level guidance to boost your gameplay and rank.</p>
      </a>
    </div>
    <div class="service-box">
      <a href="./mods.php">
        <h3>🚀 Mods & Hacks</h3>
        <p>Get custom mods, patches & elite hacks (safe zone).</p>
      </a>
    </div>
    <div class="service-box">
      <a href="settings.html">
        <h3>🎮 Gameplay Settings</h3>
        <p>Optimize your system for lag-free, ultra-HD gaming.</p>
      </a>
    </div>
  </div>
</section>

<footer>
  &copy; 2025 Gamers Rise. All rights reserved.
</footer>

</body>
</html>
