<?php
session_start();
include "../includes/db_connection.php"; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $postID = $_POST["post_id"];
    $commentText = $_POST["comment_text"];
    $userID = $_SESSION["user_id"]; // Get the current user's ID
    $commentDate = date("Y-m-d H:i:s"); // Get the current date and time

    // Insert the comment into the database
    $query = "INSERT INTO Comments (PostID, UserID, Text, CommentDate) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiss", $postID, $userID, $commentText, $commentDate);
    $success = $stmt->execute();
    
    if ($success) {
        echo json_encode(["message" => "Comment submitted successfully"]);
    } else {
        echo json_encode(["message" => "Error submitting comment"]);
    }

    $stmt->close();
    $conn->close();
}
?>
