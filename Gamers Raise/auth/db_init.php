<?php
// db_init.php — run once from browser or CLI

$host = "localhost";          // MySQL host
$dbname = "gamers_raise";     // apna database ka naam
$user = "root";               // MySQL username (agar custom user banaya ho to yahan change karo)
$pass = "";                   // MySQL password (agar set hai to likho)

try {
    // MySQL se connect
    $db = new PDO("mysql:host=localhost;dbname=gamers_raise;charset=utf8mb4", "root", "");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // users table
    $db->exec("CREATE TABLE IF NOT EXISTS users (
      id INT AUTO_INCREMENT PRIMARY KEY,
      username VARCHAR(100) UNIQUE,
      secret_enc TEXT,     -- AES encrypted secret (base64)
      secret_iv TEXT,      -- IV (base64)
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB");

    // admins table
    $db->exec("CREATE TABLE IF NOT EXISTS admins (
      id INT AUTO_INCREMENT PRIMARY KEY,
      username VARCHAR(100) UNIQUE,
      password_hash TEXT
    ) ENGINE=InnoDB");

    // decrypt logs
    $db->exec("CREATE TABLE IF NOT EXISTS decrypt_logs (
      id INT AUTO_INCREMENT PRIMARY KEY,
      admin_user VARCHAR(100),
      target_user VARCHAR(100),
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB");

    // default admin insert
    $hash = password_hash('adminSecret123', PASSWORD_DEFAULT);
    $insert = $db->prepare("INSERT IGNORE INTO admins (username, password_hash) VALUES (:u, :h)");
    $insert->execute([':u' => 'admin', ':h' => $hash]);

    echo "✅ MySQL DB initialized successfully!\n";
    echo "Default admin -> username: admin  password: adminSecret123 (change it!)\n";

} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}
