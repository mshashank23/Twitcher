<?php
include "../includes/db_connection.php"; // Include your database connection

if (isset($_GET["imageID"])) {
    $imageID = $_GET["imageID"];

    $query = "SELECT URL FROM Images WHERE ImageID = $imageID";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $imageURL = $row["URL"];
        
        $response = array("ImageURL" => $imageURL);
        header("Content-Type: application/json");
        echo json_encode($response);
    } else {
        header("HTTP/1.1 500 Internal Server Error");
    }
} else {
    header("HTTP/1.1 400 Bad Request");
}
?>
