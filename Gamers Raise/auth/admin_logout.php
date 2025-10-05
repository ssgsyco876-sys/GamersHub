<?php
session_start();
unset($_SESSION['admin']); // sirf admin session hataye
header("Location: admin.php");
exit;
