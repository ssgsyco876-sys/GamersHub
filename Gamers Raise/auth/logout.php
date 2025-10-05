<?php
session_start();
unset($_SESSION['demo_user']); // sirf user session hataye
header("Location: login.php");
exit;
