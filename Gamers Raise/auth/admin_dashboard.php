<?php
session_start();
if (!isset($_SESSION['admin'])) {
    die("Access denied!");
}

try {
    // MySQL connection (change details accordingly)
    $db = new PDO("mysql:host=localhost;dbname=gamers_raise;charset=utf8mb4", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}

// Registered users fetch
$users = $db->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);

// Time check for online/offline (5 min activity window)
$now = time();
$online = [];
$offline = [];

foreach ($users as $u) {
    $last_active = strtotime($u['last_login'] ?? '1970-01-01 00:00:00'); // use last_login
    if ($now - $last_active <= 300) { // 5 min
        $online[] = $u;
    } else {
        $offline[] = $u;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <style>
    body { font-family: Arial, sans-serif; background: #111; color: #fff; }
    h1 { text-align: center; color: orange; }
    .box { margin: 20px auto; width: 80%; padding: 20px; background: #222; border-radius: 10px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #555; padding: 10px; text-align: left; }
    th { background: orange; color: black; }
    .online { color: lime; font-weight: bold; }
    .offline { color: red; font-weight: bold; }
  </style>
</head>
<body>
  <h1>🔥 Admin Dashboard 🔥</h1>

  <div class="box">
    <h2>✅ Online Users</h2>
    <?php if (count($online)): ?>
    <table>
      <tr><th>Username</th><th>Last Active</th></tr>
      <?php foreach ($online as $u): ?>
        <tr>
          <td><?=htmlspecialchars($u['username'])?></td>
          <td><?=date('d M Y, H:i:s', strtotime($u['last_login']))?></td>
        </tr>
      <?php endforeach; ?>
    </table>
    <?php else: ?>
      <p>No one is online right now.</p>
    <?php endif; ?>
  </div>

  <div class="box">
    <h2>❌ Offline Users</h2>
    <?php if (count($offline)): ?>
    <table>
      <tr><th>Username</th><th>Last Active</th></tr>
      <?php foreach ($offline as $u): ?>
        <tr>
          <td><?=htmlspecialchars($u['username'])?></td>
          <td><?=date('d M Y, H:i:s', strtotime($u['last_login']))?></td>
        </tr>
      <?php endforeach; ?>
    </table>
    <?php else: ?>
      <p>No offline users.</p>
    <?php endif; ?>
  </div>

  <div class="box">
    <h2>📜 All Registered Users</h2>
    <table>
      <tr><th>Username</th><th>Last Active</th></tr>
      <?php foreach ($users as $u): ?>
        <tr>
          <td><?=htmlspecialchars($u['username'])?></td>
          <td><?=date('d M Y, H:i:s', strtotime($u['last_login']))?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
</body>
</html>
