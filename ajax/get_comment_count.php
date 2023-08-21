<?php
include "../includes/db_connection.php"; // Include your database connection

if (isset($_GET["post_id"])) {
    $postID = $_GET["post_id"];

    // Query to count comments for the specified post
    $query = "SELECT COUNT(*) AS commentCount FROM Comments WHERE PostID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $postID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $commentCount = $row["commentCount"];
    echo json_encode(["commentCount" => $commentCount]);
    
    $stmt->close();
    $conn->close();
}
?>
