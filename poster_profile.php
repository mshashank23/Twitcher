<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "includes/db_connection.php";
if (isset($_GET["user_id"])) {
    $userId = $_GET["user_id"];
    $sql = "SELECT * FROM Users WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    if ($stmt->errno) {
        echo "Error: " . $stmt->error;
    } else {
    $result = $stmt->get_result();
    $posterInfo = $result->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/b09ca5238b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Profile - <?php echo $posterInfo["Name"]; ?></title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark" id='mainNavDiv'>
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-5 text-white min-vh-100" id='mainNav'>
                <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-5 d-none d-sm-inline">Twitcher</span>
                </a>
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link align-middle px-0">
                            <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Home</span>
                        </a>
                    </li>
                    
                    <?php if (isset($_SESSION["user_id"])) { ?>
                        <li class="nav-item">
                            <a href="profile.php" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-person"></i> <span class="ms-1 d-none d-sm-inline">Profile</span>
                            </a>
                        </li>
                        <li>
                        <a href="create.php" class="nav-link px-0 align-middle ">
                        <i class="fs-4 bi-plus"></i> <span class="ms-1 d-none d-sm-inline">Create Post</span></a>
                    </ul>
                    </li>
                    <?php } ?>
                 
                   
                  
                </ul>
                
                <div class="dropdown pb-4">
                    <?php if (isset($_SESSION["user_id"])) { ?>
                        <span class="d-none d-sm-inline mx-1">Hello, <?php echo $_SESSION["user_name"]; ?></span><br>
                        <a href="logout.php">
                            <span class="d-none d-sm-inline mx-1">Logout</span>
                        </a>
                    <?php } else { ?>
                        <a href="login.php">
                            <span class="d-none d-sm-inline mx-1">Login</span>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
        
        <div class="col py-3" id="poster">               
               
            <div class="container" id="posterContainer">
                <h2><?php echo $posterInfo["Name"]; ?>'s Profile</h2>
                <p><strong>Username:<br> </strong><?php echo $posterInfo["Username"]; ?></p>
                <p><strong>Biography:<br> </strong><?php echo $posterInfo["Biography"]; ?></p>
                <p><strong>Address: <br></strong><?php echo $posterInfo["Address"]; ?></p>
            </div>


            </div>
        </div>
</body>
</html>

