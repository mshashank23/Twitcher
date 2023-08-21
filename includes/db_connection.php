<?php

$db_host = "localhost";
$db_user = "root"; // Change to your MySQL username
$db_pass = "";     // Change to your MySQL password
$db_name = "twitcher"; // Change to your database name

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
