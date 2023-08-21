<?php
session_start();
include "includes/db_connection.php";
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
    <script src="assets/js/app.js" defer></script>
    <title>Twitcher</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function () {
            // Listen for input changes in the search bar
            $("#search-bar").on("input", function () {
                const searchText = $(this).val().toLowerCase();

                // Filter and display posts that match the search text
                $(".post").each(function () {
                    const postText = $(this).text().toLowerCase();
                    if (postText.includes(searchText)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>
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
        
        <div class="col py-3">
                    <div class="input-group rounded" id="search">
                        <div class="searchbardiv">
                            <input type="search" class="form-control rounded" id="search-bar" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                            <span class="input-group-text border-0" id="search-addon">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                    </div>
                    <section class="posts" id="posts-container">
                            
                    </section>
                </div>
            </div>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>
</html>
