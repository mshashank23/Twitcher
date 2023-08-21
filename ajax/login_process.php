<?php
session_start(); 
include "../includes/db_connection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $query = "SELECT * FROM Users WHERE Username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["Password"])) {
            $_SESSION["user_id"] = $row["UserID"];
            $nameParts = explode(" ", $row["Name"]);
            $firstName = $nameParts[0];
            $_SESSION['user_name'] = $firstName;
            header("Location: ../index.php"); // Redirect to dashboard or user's profile
        } else {
            echo "Invalid password";
        }
    } else {
        echo "User not found";
    }

    $stmt->close();
    $conn->close();
}
?>
