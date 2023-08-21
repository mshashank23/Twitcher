<?php
session_start();
session_destroy(); // Destroy the session
header("Location: login.php"); // Redirect to homepage or login page
exit();
?>
