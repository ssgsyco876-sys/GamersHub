<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>SkinTool Passwords</title>
  <link rel="icon" href="./images/logo.png" type="image/png" />
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
      color: #fff;
    }

    .top-bar {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 20px;
    }

    .back-btn {
      background: none;
      border: none;
      cursor: pointer;
    }

    .back-btn img {
      width: 30px;
      height: 30px;
      filter: drop-shadow(0 0 5px #00ffff);
    }

    h1 {
      font-size: 2rem;
      color: #00ffff;
      text-shadow: 0 0 10px #00ffff;
      margin: 0;
    }

    .vault-container {
      max-width: 600px;
      margin: 40px auto;
      padding: 30px;
      background-color: rgba(0, 0, 0, 0.4);
      border-radius: 16px;
      box-shadow: 0 0 30px rgba(0, 255, 255, 0.2);
      text-align: center;
    }

    .vault-container h2 {
      color: #00ffff;
      margin-bottom: 20px;
    }

    .password-box {
      background-color: #111;
      border: 1px solid #00ffff70;
      border-radius: 10px;
      padding: 12px 20px;
      margin-bottom: 15px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      color: #fff;
      font-size: 1.2rem;
    }

    .copy-btn {
      background-color: #00ffff;
      color: #000;
      border: none;
      padding: 5px 12px;
      border-radius: 6px;
      cursor: pointer;
      font-weight: bold;
    }

    .copy-btn:hover {
      background-color: #00cccc;
    }

    footer {
      text-align: center;
      color: #888;
      margin-top: 60px;
      padding: 20px;
    }
  </style>
</head>
<body>

  <div class="top-bar">
    <button class="back-btn" onclick="goBack()">
      <img src="./images/back-icon.png" alt="Back">
    </button>
    <h1>SkinTool Passwords</h1>
  </div>

  <div class="vault-container">
    <h2>Latest Passwords</h2>

    <div class="password-box">
      <span id="pass1">SKIN2025Free</span>
      <button class="copy-btn" onclick="copyText('pass1')">Copy</button>
    </div>

    <div class="password-box">
      <span id="pass2">ZULFI@HACKED</span>
      <button class="copy-btn" onclick="copyText('pass2')">Copy</button>
    </div>

    <div class="password-box">
      <span id="pass3">MODSKIN++</span>
      <button class="copy-btn" onclick="copyText('pass3')">Copy</button>
    </div>

    <!-- Add more password boxes as needed -->

  </div>

  <footer>
    &copy; 2025 SkinTool Services. All rights reserved.
  </footer>

  <script>
    function copyText(id) {
      const text = document.getElementById(id).textContent;
      navigator.clipboard.writeText(text).then(() => {
        alert("Copied: " + text);
      });
    }

    function goBack() {
      window.location.href = "services.php";
    }
  </script>

</body>
</html>
