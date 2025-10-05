<?php
require __DIR__ . '/helpers.php';
session_start();

// ✅ Database connect
try {
    $db = new PDO("mysql:host=localhost;dbname=gamers_raise;charset=utf8mb4", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Database connection failed: " . $e->getMessage());
}

// Initialize error message
$error = '';

// ------------------ LOGIN LOGIC (POST) ------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['username']);
    $secret = (string)$_POST['secret'];
    $master_key = '1983';

    // ✅ Admin login
    if ($email === 'admin' && $secret === 'adminSecret123') {
        $_SESSION['admin'] = 'admin';
        header('Location: admin.php');
        exit;
    }

    // ✅ Gmail validation
    if (!preg_match('/^[A-Za-z0-9._%+-]+@gmail\.com$/i', $email)) {
        $error = '❌ Only Gmail addresses are supported.';
    } else {
        // ✅ Check if user exists
        $stmt = $db->prepare("SELECT secret_enc, secret_iv, username FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // ✅ User exists → verify password
            $decrypted = decrypt_secret($user['secret_enc'], $user['secret_iv'], $master_key);
            if ($secret !== $decrypted) {
                $error = '❌ Incorrect password.';
            } else {
                // ✅ Password correct → update last_login & status
                $update = $db->prepare("UPDATE users SET last_login = NOW(), status='online' WHERE email = :email");
                $update->execute([':email' => $email]);

                $_SESSION['demo_user'] = $email;

                // ✅ Check if username exists
                if (empty($user['username'])) {
                    header("Location: set_username.php"); // redirect to username setup
                    exit;
                } else {
                    $_SESSION['demo_username'] = $user['username'];
                    header("Location: dashboard.php"); // username already exists
                    exit;
                }
            }
        } else {
            // ✅ New user → insert
            $enc = encrypt_secret($secret, $master_key);
            $insert = $db->prepare("INSERT INTO users (email, secret_enc, secret_iv, last_login, status) VALUES (:email, :enc, :iv, NOW(), 'online')");
            $insert->execute([
                ':email' => $email,
                ':enc'   => $enc['enc'],
                ':iv'    => $enc['iv']
            ]);

            $_SESSION['demo_user'] = $email;

            // ✅ New user → redirect to username setup
            header("Location: set_username.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Gamers Login</title>
<style>
body {margin:0;padding:0;height:100vh;display:flex;justify-content:center;align-items:center;background:black;overflow:hidden;font-family:"Orbitron",sans-serif;}
body::before {content:"";position:absolute;top:0;left:0;width:100%;height:100%;background:url('./images.jpeg') no-repeat center center/cover;opacity:0.4;z-index:-1;}
.login-box {width:350px;padding:30px;background:rgba(20,20,20,0.85);border:2px solid #ff4500;border-radius:15px;box-shadow:0 0 20px #ff4500,0 0 40px #ff6347 inset;text-align:center;color:white;animation:glow 2s infinite alternate;}
@keyframes glow {from{box-shadow:0 0 20px #ff4500;}to{box-shadow:0 0 40px #ff6347;}}
h2 {margin-bottom:20px;font-size:26px;color:#ff4500;text-shadow:0 0 10px #ff6347;}
.login-box input {width:100%;padding:12px;margin:10px 0;border:none;border-radius:8px;outline:none;background:#111;color:#fff;font-size:15px;box-shadow:0 0 10px #ff4500 inset;}
.login-box button {width:100%;padding:12px;margin-top:15px;border:none;border-radius:8px;background:linear-gradient(45deg,#ff4500,#ff6347);color:white;font-size:16px;cursor:pointer;transition:0.3s;font-weight:bold;}
.login-box button:hover {background:linear-gradient(45deg,#ff6347,#ff4500);transform:scale(1.05);}
.error-msg {color:#ff6347;margin-bottom:10px;font-weight:bold;}
</style>
</head>
<body>
<div class="login-box">
<h2>🔥 Gamers Login 🔥</h2>
<?php if(!empty($error)) echo '<div class="error-msg">'.$error.'</div>'; ?>
<form method="post">
  <input name="username" placeholder="Enter Gmail ID" required value="<?= isset($email) ? htmlspecialchars($email) : '' ?>"><br>
  <input name="secret" type="password" placeholder="Enter Passkey" required><br>
  <button>Login</button>
</form>
</div>
</body>
</html>
