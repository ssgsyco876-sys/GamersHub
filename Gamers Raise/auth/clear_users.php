<?php
session_start();

// ✅ Sirf admin hi access kar sake
if (!isset($_SESSION['admin'])) { 
    header("Location: admin.php"); 
    exit; 
}

// ✅ MySQL Database connection
$host = "localhost";   // server ka address
$dbname = "gamers_raise"; // apna database name likho
$user = "your_db_username";     // apna username
$pass = "your_db_password";     // apna password

try {
    $db = new PDO("mysql:host=localhost;dbname=gamers_raise;charset=utf8mb4", "root", "");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}

// ✅ Handle deletion request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_all'])) {
        // Delete all users
        $db->exec("DELETE FROM users");
        $msg = "All users deleted successfully!";
    } elseif (!empty($_POST['users'])) {
        // Delete selected users
        $in  = str_repeat('?,', count($_POST['users']) - 1) . '?';
        $stmt = $db->prepare("DELETE FROM users WHERE username IN ($in)");
        $stmt->execute($_POST['users']);
        $msg = "Selected users deleted successfully!";
    }
}

// ✅ Fetch all users
$users = $db->query("SELECT username FROM users ORDER BY username ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Users</title>
    <style>
        body {
            background: #0d0d0d;
            color: #fff;
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .box {
            width: 60%;
            margin: auto;
            padding: 20px;
            background: rgba(30,30,30,0.9);
            border-radius: 10px;
            margin-top: 50px;
            box-shadow: 0 0 20px red;
        }
        h1 { color: #ff4444; }
        table { width: 100%; margin-top: 15px; border-collapse: collapse; }
        th, td { padding: 10px; border-bottom: 1px solid #555; }
        th { background: #222; }
        button {
            padding: 10px 20px;
            margin: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        .delete-btn { background: red; color: white; }
        .delete-all { background: darkred; color: white; }
        .back { background: gray; color: white; }
    </style>
</head>
<body>
<div class="box">
    <h1>Delete Users</h1>

    <?php if (!empty($msg)) echo "<p style='color:lightgreen;font-weight:bold;'>$msg</p>"; ?>

    <form method="post">
        <table>
            <tr>
                <th>Select</th>
                <th>Username</th>
            </tr>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td><input type="checkbox" name="users[]" value="<?= htmlspecialchars($u['username']) ?>"></td>
                    <td><?= htmlspecialchars($u['username']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <button type="submit" class="delete-btn">Delete Selected</button>
        <button type="submit" name="delete_all" value="1" class="delete-all" onclick="return confirm('Are you sure you want to delete ALL users?')">Delete All</button>
    </form>
    <p><a href="admin.php" class="back">⬅ Back to Admin</a></p>
</div>
</body>
</html>
