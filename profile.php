<?php
session_start();
function isUserLoggedIn() {
    return isset($_SESSION["user_id"]);
}

if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit(); 
}
include "includes/db_connection.php";
        if (isset($_SESSION["user_id"])) {
            $userId = $_SESSION["user_id"];
            $sql = "SELECT Posts.*, Images.URL FROM Posts
                    LEFT JOIN Images ON Posts.ImageID = Images.ImageID
                    WHERE Posts.UserID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
        }

        if (isset($_SESSION["user_id"])) {
            $userId = $_SESSION["user_id"];
            $sql = "SELECT * FROM Users WHERE UserID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result1 = $stmt->get_result();
            $userRow = $result1->fetch_assoc();
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
                            <a href="#" class="nav-link align-middle px-0">
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
        
        <div class="col py-3" id="profileContainer">               
                <div class="container mt-4"  id='mainContainer'>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h3>User Information</h3>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $userRow["Name"]; ?></h5>
                                    <p class="card-text"><strong>Email: </strong><br><?php echo $userRow["Email"]; ?></p>
                                    <p class="card-text"><strong>Location: </strong><br><?php echo $userRow["Address"]; ?></p>
                                    <p class="card-text"><strong>Biography: </strong><br><?php echo $userRow["Biography"]; ?></p>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#postsTab">Posts</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="postsTab">
                                    <h3>My Posts</h3>
                                    <ul class="list-group">
                                        <?php
                                        while ($row = $result->fetch_assoc()) {
                                            $postId = $row["PostID"];
                                            $postTitle = $row["Title"];
                                            $postImageURL = $row["URL"];
                                            $postContent = $row["Text"];
                                        ?>
                                        <li class="list-group-item" id="postTab">
                                            <div class="d-flex justify-content-between">
                                                <h2><?php echo $postTitle; ?></h2>
                                                <button id='postDeleteButton' class="btn btn-danger btn-sm delete-button" data-post-id="<?php echo $postId; ?>">Delete</button>
                                            </div>
                                            <?php if ($postImageURL) { ?>
                                                <img src="<?php echo $postImageURL; ?>" alt="Post Image" class="img-fluid">
                                            <?php } ?>
                                            <p><?php echo $postContent; ?></p>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    <script>
        $(document).ready(function () {
            $(".delete-button").click(function () {
                    var postId = $(this).data("post-id");

                    $.post("../ajax/delete_post.php", { postId: postId }, function(data) {
                        console.log(data);
                        location.reload();
                    });
                });
            });
    </script>
</body>
</html>
