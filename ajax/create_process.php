<?php
session_start();
include "../includes/db_connection.php"; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $currentDateTime = date("Y-m-d H:i:s");
    $title = $_POST["title"];
    $text = $_POST["text"];
    $imageURL = $_POST["imageURL"];
    $userID = $_SESSION["user_id"];
    $location = isset($_POST["location"]) ? $_POST["location"] : null;

    // Insert the image URL into the Images table
    $insertImageQuery = "INSERT INTO Images (URL) VALUES (?)";
    $stmtImage = $conn->prepare($insertImageQuery);
    $stmtImage->bind_param("s", $imageURL);
    $stmtImage->execute();
    $imageID = $stmtImage->insert_id;

    // Insert the post into the Posts table
    $insertPostQuery = "INSERT INTO Posts (UserID, ImageID, Title, Text, PostDate, Location) VALUES (?, ?, ?, ?, ?, ?)";
    $stmtPost = $conn->prepare($insertPostQuery);
    $stmtPost->bind_param("iissss", $userID, $imageID, $title, $text, $currentDateTime, $location);
    
    if ($stmtPost->execute()) {
        // Redirect to a success page or show a success message
        header("Location: ../index.php");
        exit();
    } else {
        // Redirect to an error page or show an error message
        header("Location: ../create.php");
        exit();
    }

    $stmtImage->close();
    $stmtPost->close();
    $conn->close();
}
?>
