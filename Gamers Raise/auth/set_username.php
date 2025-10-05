<?php
require __DIR__ . '/helpers.php';
session_start();

// ✅ Ensure user is logged in
if(!isset($_SESSION['demo_user'])){
    header("Location: login.php");
    exit;
}

$email = $_SESSION['demo_user'];
$error = '';

try {
    $db = new PDO("mysql:host=localhost;dbname=gamers_raise;charset=utf8mb4", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("❌ DB error: ".$e->getMessage());
}

// ✅ Form submission
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = trim($_POST['username']);

    if(strlen($username) === 0 || strlen($username) > 20){
        $error = "❌ Username must be 1-20 characters.";
    } else {
        // ✅ Update username in DB
        $stmt = $db->prepare("UPDATE users SET username=:username WHERE email=:email");
        $stmt->execute([
            ':username' => $username,
            ':email' => $email
        ]);

        $_SESSION['demo_username'] = $username;

        // ✅ Redirect to dashboard
        header("Location: dashboard.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Set Your Username</title>
<style>
body{margin:0;padding:0;height:100vh;display:flex;justify-content:center;align-items:center;background:black;color:white;font-family:"Orbitron",sans-serif;}
.box{width:400px;padding:30px;background:rgba(20,20,20,0.85);border:2px solid #ff4500;border-radius:15px;text-align:center;}
input{width:100%;padding:12px;margin:10px 0;border:none;border-radius:8px;outline:none;background:#111;color:#fff;font-size:15px;}
button{width:100%;padding:12px;margin-top:15px;border:none;border-radius:8px;background:linear-gradient(45deg,#ff4500,#ff6347);color:white;font-size:16px;cursor:pointer;font-weight:bold;}
.error{color:#ff6347;margin-bottom:10px;font-weight:bold;}
</style>
</head>
<body>
<div class="box">
<h2>Choose Your Username</h2>
<?php if($error) echo "<div class='error'>$error</div>"; ?>
<form method="post">
<input name="username" placeholder="Enter your username (max 20 chars)" required>
<button>Save Username</button>
</form>
</div>
</body>
</html>
