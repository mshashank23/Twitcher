<?php
include "../includes/db_connection.php"; // Include your database connection

if (isset($_GET["userID"])) {
    $userID = $_GET["userID"];

    // Retrieve the user's name from the database based on UserID
    $query = "SELECT Name FROM Users WHERE UserID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $userName = $user["Name"];
        echo json_encode(["userName" => $userName]);
    } else {
        echo json_encode(["userName" => "Unknown User"]);
    }
} else {
    echo json_encode(["userName" => "Unknown User"]);
}

$stmt->close();
$conn->close();
?>
