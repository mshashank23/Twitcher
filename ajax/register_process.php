<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "../includes/db_connection.php"; 


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $address = $_POST["address"];
    $biography = $_POST["biography"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $username = $_POST["username"]; 

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute the SQL query
    $query = "INSERT INTO Users (Name, Address, Email, Password, Username, Biography) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssss", $name, $address, $email, $hashedPassword, $username, $biography);

    if ($stmt->execute()) {
        echo "Registration successful!";
        header("Location: ../login.php");
        exit; 
    } else {
        echo "Error during registration.";
        header("Location: ../register.php");
    }

    $stmt->close();
    $conn->close();
}


?>
