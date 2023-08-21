<?php
session_start();
include "../includes/db_connection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_SESSION["user_id"])) {
        $userId = $_SESSION["user_id"];
        $postId = $_POST["postId"];

        // Check if the post belongs to the current user
        $checkSql = "SELECT * FROM Posts WHERE PostID = ? AND UserID = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("ii", $postId, $userId);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows === 1) {
            // Delete the post
            $deleteSql = "DELETE FROM Posts WHERE PostID = ?";
            $deleteStmt = $conn->prepare($deleteSql);
            $deleteStmt->bind_param("i", $postId);
            if ($deleteStmt->execute()) {
                // Delete was successful
                echo "Post deleted successfully.";
            } else {
                // Delete failed
                echo "Error deleting post.";
            }
        } else {
            // The post doesn't belong to the current user
            echo "You don't have permission to delete this post.";
        }
    } else {
        // User is not logged in
        echo "Please log in to perform this action.";
    }
} else {
    // Invalid request method
    echo "Invalid request.";
}
?>
