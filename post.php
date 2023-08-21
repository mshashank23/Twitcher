<?php
session_start();
include "includes/db_connection.php"; // Include your database connection

if (isset($_GET["post_id"])) {
    $postID = $_GET["post_id"];

    // Retrieve the post content and associated image URL from the database
    $query = "SELECT Posts.*, Images.URL, Users.Name AS UserName FROM Posts 
    LEFT JOIN Images ON Posts.ImageID = Images.ImageID
    LEFT JOIN Users ON Posts.UserID = Users.UserID 
    WHERE PostID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $postID);
    $stmt->execute();
    $postResult = $stmt->get_result();
    $post = $postResult->fetch_assoc();

    // Retrieve comments for the post from the database
    $query = "SELECT * FROM Comments WHERE PostID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $postID);
    $stmt->execute();
    $commentsResult = $stmt->get_result();
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    
    <title>Post - <?php echo $post["Title"]; ?></title>
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
                            <i class="fs-4 bi-plus"></i>  <span class="ms-1 d-none d-sm-inline">Create Post</span></a>
                        </ul>
                    </li>
                    <?php } ?>
                 
                  
                  
                </ul>
                
                <div class="dropdown pb-4">
                    <?php if (isset($_SESSION["user_id"])) { ?>
                        <span class="d-none d-sm-inline mx-1">Hello, <?php echo $_SESSION["user_name"]; ?></span><br>
                        <a href="logout.php">
                            <span>Logout</span>
                        </a>
                    <?php } else { ?>
                        <a href="login.php">
                            <span>Login</span>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
        
        <div class="col py-3" id="postPage">
                    <div class="container" id="postPageContainer">
                    <div class="postpage">
                        <h1><?php echo $post["Title"]; ?></h1>
                        <?php if ($post["UserName"]) { ?>
                            <p class="posted-by">Posted by:<a href="poster_profile.php?user_id=<?php echo $post["UserID"]; ?>"> <?php echo $post["UserName"]; ?></a></p>
                        <?php } ?>
                        <?php if ($post["URL"]) { ?>
                            <div class="post-image">
                                <img src="<?php echo $post["URL"]; ?>" alt="Post Image">
                            </div>
                        <?php } ?>
                        
                        <p class="post-content"><?php echo $post["Text"]; ?></p>
                    </div>


                    <div class="comments-section">
                  
                    <?php if (isset($_SESSION["user_id"])) { ?>
                            <form id="comment-form">
                                <textarea name="commentText" rows="4" placeholder="Add your comment here"></textarea>
                                <button type="submit">Submit Comment</button>
                            </form>
                        <?php } else { ?>
                            <p>Please <a href="login.php">login</a> to leave a comment.</p>
                        <?php } ?>
                    </div>

                    <h2>Comments</h2>
                    <?php while ($comment = $commentsResult->fetch_assoc()) {
                    
                        $userQuery = "SELECT Name FROM Users WHERE UserID = ?";
                        $userStmt = $conn->prepare($userQuery);
                        $userStmt->bind_param("i", $comment["UserID"]);
                        $userStmt->execute();
                        $userResult = $userStmt->get_result();
                       
                        if ($userResult && $userResult->num_rows > 0) {
                            $user = $userResult->fetch_assoc();
                            $userName = $user["Name"];
                        } else {
                            $userName = "Unknown User"; 
                        }

                        
                    ?>
                        <div class="comment">
                            <p><strong><?php echo $userName; ?>:</strong><br> <?php echo $comment["Text"]; ?></p>
                        </div>
                    <?php 
                
                        $userStmt->close();
                        $userResult->close();
                    } ?>
                    </div>
                </div>
                </div>
            </div>
        </div>
      

  

    <script>
        document.addEventListener("DOMContentLoaded", () => {
        const commentForm = document.getElementById("comment-form");
        
        commentForm.addEventListener("submit", (event) => {
            event.preventDefault();

            const commentText = commentForm.commentText.value;
            const postID = <?php 
            echo $postID; 
            ?>; // Get the post ID from PHP variable

            // Use AJAX to submit the comment to the server
            fetch("ajax/submit_comment.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `post_id=${postID}&comment_text=${commentText}`
            })
            .then(response => response.json())
            .then(data => {
                // Handle the response (e.g., display the new comment)
                console.log(data);
                location.reload();
                });
            });
        });

    </script> <!-- Add a JavaScript file to handle comment submission -->
</body>
</html>
