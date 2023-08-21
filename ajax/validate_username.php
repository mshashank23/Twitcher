<?php
include "../includes/db_connection.php"; // Include your database connection

if (isset($_POST["username"])) {
    $username = $_POST["username"];

    // Prepare and execute the SQL query
    $query = "SELECT * FROM Users WHERE Username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Username is already taken.";
    } else {
        echo "Username is available.";
    }

    $stmt->close();
    $conn->close();
}
?>
