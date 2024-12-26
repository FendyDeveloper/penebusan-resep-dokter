<?php
include 'session_manager.php';

// Lakukan logout
logoutUser();

// Redirect ke halaman login setelah logout
header("Location: login.php");
exit();
?>
