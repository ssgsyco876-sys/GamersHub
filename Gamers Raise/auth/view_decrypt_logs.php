<?php
session_start();
if (!isset($_SESSION['admin'])) { 
    header('Location: admin.php'); 
    exit; 
}

// ✅ MySQL connection
$host = "localhost";      
$dbname = "gamers_raise"; 
$user = "root";           
$pass = "";               

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ensure decrypt_logs table exists
    $db->exec("CREATE TABLE IF NOT EXISTS decrypt_logs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        admin_user VARCHAR(100) NOT NULL,
        target_user VARCHAR(100) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // ✅ Insert log if coming from decrypt.php
    if (isset($_GET['target_user'])) {
        $stmt = $db->prepare("INSERT INTO decrypt_logs (admin_user, target_user) VALUES (:admin, :target)");
        $stmt->execute([
            ':admin' => $_SESSION['admin'],
            ':target'=> $_GET['target_user']
        ]);
    }

    // Fetch last 200 logs
    $stmt = $db->query("SELECT * FROM decrypt_logs ORDER BY created_at DESC LIMIT 200");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Decrypt Audit Logs</title>
<style>
body {
    background: #111;
    color: #f1f1f1;
    font-family: "Segoe UI", sans-serif;
    padding: 30px;
}
h1 {
    color: orange;
    text-shadow: 0 0 10px #ff9900;
    text-align: center;
    margin-bottom: 25px;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin: auto;
    background: rgba(20,20,20,0.9);
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 0 20px rgba(255,165,0,0.3);
}
th, td {
    padding: 12px 15px;
    text-align: center;
}
th {
    background: orange;
    color: #111;
    font-weight: bold;
}
tr:nth-child(even) {
    background: rgba(255,165,0,0.1);
}
tr:hover {
    background: rgba(255,165,0,0.3);
    transform: scale(1.01);
    transition: 0.2s;
}
a {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    background: orange;
    color: #111;
    text-decoration: none;
    border-radius: 8px;
    transition: 0.3s;
}
a:hover {
    background: #ff9900;
    transform: scale(1.05);
}
</style>
</head>
<body>

<h1>🔒 Decrypt Audit Logs (Last 200)</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Admin</th>
        <th>Target User</th>
        <th>When</th>
    </tr>
    <?php foreach ($rows as $r): ?>
    <tr>
        <td><?= $r['id'] ?></td>
        <td><?= htmlspecialchars($r['admin_user']) ?></td>
        <td><?= htmlspecialchars($r['target_user']) ?></td>
        <td><?= date('d M Y, H:i:s', strtotime($r['created_at'])) ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<p style="text-align:center;"><a href="admin.php">⬅ Back to Admin Panel</a></p>

</body>
</html>
