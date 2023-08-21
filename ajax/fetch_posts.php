<?php
include "../includes/db_connection.php"; // Include your database connection file

$query = "SELECT * FROM Posts ORDER BY PostDate DESC";
$result = mysqli_query($conn, $query);

$posts = array();
while ($row = mysqli_fetch_assoc($result)) {
    $posts[] = $row;
}

header("Content-Type: application/json");
echo json_encode($posts);
?>
