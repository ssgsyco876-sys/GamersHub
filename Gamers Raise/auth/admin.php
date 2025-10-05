<?php
session_start();

// ✅ MySQL connection
$dsn = "mysql:host=localhost;dbname=gamers_raise;charset=utf8mb4";
$dbUser = "root";   
$dbPass = "";       

try {
    $db = new PDO($dsn, $dbUser, $dbPass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}

// ✅ Admin login check
if (!isset($_SESSION['admin'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_user'], $_POST['admin_pass'])) {
        $u = $_POST['admin_user']; 
        $p = $_POST['admin_pass'];

        // Simple check (hardcoded admin login)
        if ($u === 'admin' && $p === 'adminSecret123') {
            $_SESSION['admin'] = $u;
            header("Location: admin.php");
            exit;
        } else {
            $err = "❌ Wrong admin credentials.";
        }
    } else {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Admin Login</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                body, html {
                    height: 100%;
                    margin: 0;
                    font-family: 'Segoe UI', sans-serif;
                }
                .bg-image {
                    background: url('././../img.png') no-repeat center center;
                    background-size: cover;
                    height: 100%;
                    position: relative;
                }
                .overlay {
                    position: absolute;
                    top:0;
                    left:0;
                    width:100%;
                    height:100%;
                    background: rgba(0,0,0,0.6);
                }
                .login-card {
                    min-width: 350px;
                    background: rgba(20,20,35,0.9);
                    padding: 30px;
                    border-radius: 10px;
                    box-shadow: 0 0 20px rgba(0,0,0,0.5);
                    color: #fff;
                }
                .login-card input {
                    background: rgba(255,255,255,0.1);
                    border: none;
                    color: #fff;
                }
                .login-card input::placeholder {
                    color: rgba(255,255,255,0.7);
                }
                .login-card button {
                    background-color: #0d6efd;
                    border: none;
                }
                .login-card button:hover {
                    background-color: #0056b3;
                }
            </style>
        </head>
        <body>
            <div class="bg-image">
                <div class="overlay"></div>
                <div class="d-flex align-items-center justify-content-center vh-100 position-relative">
                    <div class="login-card text-center">
                        <h2 class="mb-4">🔑 Admin Login</h2>
                        <?php if (!empty($err)) echo "<div class='alert alert-danger'>$err</div>"; ?>
                        <form method="post">
                            <div class="mb-3">
                                <input name="admin_user" class="form-control" placeholder="Admin Username" required>
                            </div>
                            <div class="mb-3">
                                <input name="admin_pass" type="password" class="form-control" placeholder="Admin Password" required>
                            </div>
                            <button class="btn btn-primary w-100">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
        exit;
    }
}

// ✅ Get users from MySQL
$rows = $db->query("SELECT id, name, email, last_login, status FROM users ORDER BY last_login DESC")
           ->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; }
        .sidebar {
            width: 220px;
            height: 100vh;
            position: fixed;
            top:0; left:0;
            background: #212529;
            padding-top: 60px;
        }
        .sidebar a {
            display: block;
            color: #adb5bd;
            padding: 12px 20px;
            text-decoration: none;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background: #0d6efd;
            color: white;
        }
        .content {
            margin-left: 220px;
            padding: 20px;
        }
        .table-hover tbody tr:hover {
            background: #f1f1f1;
        }
        .topbar {
            height: 60px;
            background: #fff;
            border-bottom: 1px solid #ddd;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed;
            top:0; left:220px; right:0;
            z-index: 10;
        }
        .logout-btn {
            color: #fff;
            background: #dc3545;
            border: none;
            padding: 6px 15px;
            border-radius: 5px;
            text-decoration: none;
        }
        .logout-btn:hover {
            background: #bb2d3b;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="./admin_dashboard.php">🏠 Dashboard</a>
        <a href="./view_decrypt_logs.php">📜 Decrypt Logs</a>
        <a href="./clear_users.php">🗑 Clear Users</a>
        <a href="./admin_logout.php" class="text-danger">🚪 Logout</a>
    </div>

    <div class="topbar">
        <h5 class="mb-0">Admin Panel</h5>
        <div>
            Logged in as <b><?php echo htmlspecialchars($_SESSION['admin']); ?></b>
        </div>
    </div>

    <div class="content" style="margin-top:70px;">
        <div class="card shadow p-3">
            <h3 class="mb-3">👥 Registered Users</h3>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Last Login</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($rows as $r): ?>
                        <tr>
                            <td><?= $r['id'] ?></td>
                            <td><?= htmlspecialchars($r['name']) ?></td>
                            <td><?= htmlspecialchars($r['email']) ?></td>
                            <td><?= $r['last_login'] ?? '-' ?></td>
                            <td><?= $r['status'] ?></td>
                            <td>
                                <form method="post" action="decrypt.php" class="d-flex gap-2">
                                    <input type="hidden" name="user_id" value="<?= $r['id'] ?>">
                                    <button class="btn btn-sm btn-success">Decrypt</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
