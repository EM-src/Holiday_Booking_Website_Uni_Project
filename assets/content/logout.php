<?php
ini_set("session.save_path", "/Applications/XAMPP/xamppfiles/sessionData");
session_start();
session_unset();
unset($_SESSION['logged-in']);
unset($_SESSION['user']);
$_SESSION['logged-in'] = "false";
$_SESSION['user'] = "";
session_destroy();
header("Location: signInForm.php");
exit;
?>