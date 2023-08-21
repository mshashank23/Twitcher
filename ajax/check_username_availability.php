<?php
include "../includes/db_connection.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];

    $query = "SELECT COUNT(*) as count FROM Users WHERE Username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row["count"] > 0) {
        echo "Username is already taken."; 
    } else {
        echo "Username is available."; 
    }
}
?>
