<?php
require 'helpers.php';
session_start();

// ✅ Only admin access
if (!isset($_SESSION['admin'])) {
    die("Access denied.");
}

// ✅ MySQL connection
$dsn = "mysql:host=localhost;dbname=gamers_raise;charset=utf8mb4";
$dbUser = "root";
$dbPass = "";

try {
    $db = new PDO($dsn, $dbUser, $dbPass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ensure decrypt_attempts table exists
    $db->exec("CREATE TABLE IF NOT EXISTS decrypt_attempts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        admin_user VARCHAR(100) NOT NULL,
        user_id INT NOT NULL,
        attempts INT DEFAULT 0,
        last_attempt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");

} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}

// ✅ Check POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = (int)$_POST['user_id'];
    $master_key_input = $_POST['master_key'] ?? null;

    // Fetch user info
    $stmt = $db->prepare("SELECT id, name, email, secret_enc, secret_iv FROM users WHERE id=:id LIMIT 1");
    $stmt->execute([':id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("<h2 style='color:red;'>User not found.</h2><p><a href='admin.php'>Back</a></p>");
    }

    $admin = $_SESSION['admin'];
    $correct_master = '180410'; // Fixed master key

    // Fetch previous attempts
    $stmt = $db->prepare("SELECT * FROM decrypt_attempts WHERE admin_user=:admin AND user_id=:uid LIMIT 1");
    $stmt->execute([':admin'=>$admin, ':uid'=>$user_id]);
    $attempt = $stmt->fetch(PDO::FETCH_ASSOC);

    $attempts = $attempt['attempts'] ?? 0;
    $last_time = isset($attempt['last_attempt']) ? strtotime($attempt['last_attempt']) : 0;
    $can_attempt = true;

    if ($attempts >= 5 && (time() - $last_time) < 86400) {
        $can_attempt = false;
        $remaining = 86400 - (time() - $last_time);
        $hrs = floor($remaining / 3600);
        $mins = floor(($remaining % 3600)/60);
        die("<h2 style='color:red;'>❌ Max attempts reached. Try again in {$hrs}h {$mins}m.</h2><p><a href='admin.php'>Back</a></p>");
    }

    // If master key submitted
    if ($master_key_input !== null) {
        if ($master_key_input === $correct_master) {
            // Reset attempts on success
            $db->prepare("DELETE FROM decrypt_attempts WHERE admin_user=:admin AND user_id=:uid")
               ->execute([':admin'=>$admin, ':uid'=>$user_id]);

            // Decrypt
            $plaintext = decrypt_secret($user['secret_enc'], $user['secret_iv'], $correct_master);

            // ✅ Log this decrypt
            $db->prepare("INSERT INTO decrypt_logs (admin_user, target_user) VALUES (:admin, :target)")
               ->execute([':admin'=>$admin, ':target'=>$user['name']]);

            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Decrypted Secret</title>
                <style>
                body{background:#111;color:#f1f1f1;font-family:sans-serif;display:flex;justify-content:center;align-items:center;min-height:100vh;}
                .card{background:rgba(20,20,20,0.9);padding:30px;border-radius:15px;border:2px solid orange;max-width:450px;text-align:center;}
                h2{color:orange;}
                .secret{background:#222;padding:12px;border-radius:8px;color:#ffeb3b;font-weight:bold;word-break:break-all;margin:15px 0;}
                a{display:inline-block;margin-top:15px;padding:10px 20px;background:orange;color:#111;text-decoration:none;border-radius:8px;}
                a:hover{background:#ff9900;}
                </style>
            </head>
            <body>
            <div class="card">
                <h2>Decrypted Secret 🔑</h2>
                <p><strong>User:</strong> <?=htmlspecialchars($user['name'])?></p>
                <p><strong>Email:</strong> <?=htmlspecialchars($user['email'])?></p>
                <div class="secret"><?=htmlspecialchars($plaintext)?></div>
                <a href="./admin.php">Back</a>
            </div>
            </body>
            </html>
            <?php
            exit;
        } else {
            // Increment attempts
            if ($attempt) {
                $db->prepare("UPDATE decrypt_attempts SET attempts=attempts+1, last_attempt=NOW() WHERE id=:id")
                   ->execute([':id'=>$attempt['id']]);
                $attempts++;
            } else {
                $db->prepare("INSERT INTO decrypt_attempts (admin_user,user_id,attempts) VALUES (:admin,:uid,1)")
                   ->execute([':admin'=>$admin, ':uid'=>$user_id]);
                $attempts = 1;
            }
            $remaining = 5 - $attempts;
            die("<h2 style='color:red;'>❌ Wrong master key! You have {$remaining} attempts left in 24h.</h2><p><a href='admin.php'>Back</a></p>");
        }
    }

    // Show master key input form
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Enter Master Key</title>
        <style>
        body{background:#111;color:#f1f1f1;font-family:sans-serif;display:flex;justify-content:center;align-items:center;min-height:100vh;}
        .card{background:rgba(20,20,20,0.9);padding:30px;border-radius:15px;border:2px solid orange;max-width:400px;text-align:center;}
        input{padding:10px;width:80%;border-radius:6px;border:none;margin-bottom:15px;}
        button{padding:10px 20px;border:none;border-radius:6px;background:orange;color:#111;cursor:pointer;}
        button:hover{background:#ff9900;}
        </style>
    </head>
    <body>
        <div class="card">
            <h2>Enter Master Key 🔑</h2>
            <form method="post">
                <input type="hidden" name="user_id" value="<?=$user['id']?>">
                <input type="password" name="master_key" placeholder="Master Key" required>
                <br>
                <button>Decrypt</button>
            </form>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// ❌ Invalid request
die("<h2 style='color:red;'>Invalid request.</h2><p><a href='admin.php'>Back</a></p>");
