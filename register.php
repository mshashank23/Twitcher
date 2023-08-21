<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js"></script>
    <script>
            $(document).ready(function () {
                $("#registration-form").validate({
                    rules: {
                        password: {
                            required: true,
                            minlength: 8
                        },
                        username: {
                            required: true,
                            minlength: 4,
                            remote: {
                                url: "ajax/check_username_availability.php",
                                type: "post",
                                data: {
                                    username: function() {
                                        return $("#username").val();
                                    }
                                }
                            }
                        }
                    },
                    messages: {
                        password: {
                            required: "Please provide a password",
                            minlength: "Your password must be at least 8 characters long"
                        },
                        username: {
                            required: "Please provide a username.",
                            remote: "Username is already taken."
                        }
                    },
                    errorPlacement: function (error, element) {
                        if (element.attr("password") === "password") {
                            error.appendTo("#password-feedback");
                        } else if (element.attr("name") === "username") {
                            error.appendTo("#username-feedback");
                        } else {
                            error.insertAfter(element);
                        }
                    }
                });

                $("#password").on("input", function () {
                    $("#password-feedback").html(""); // Clear previous message
                    const password = $(this).val();
                    const result = zxcvbn(password);
                    $("#password-feedback").html(`Password strength: ${result.score}/4`);
                });

                $("#username").on("input", function() {
                    $("#username-availability").html(""); // Clear previous message
                    if ($(this).valid()) {
                        const username = $(this).val();
                        $.post("ajax/check_username_availability.php", { username: username }, function(data) {
                            $("#username-availability").html(data);
                        });
                    }
                });


            });
    </script>
</head>
<body>
    <div class="registerContainer">
    <div class="container d-flex justify-content-center align-items-center vh-100" id="registerMain">
        <div class="card p-4 shadow">
            <h1 class="text-center mb-4">Sign Up</h1>
            <form action="ajax/register_process.php" method="post">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                    <div id="username-availability"></div>
                </div>
                <div class="form-group">
                    <label for="biography">Biography:</label>
                    <input type="text" class="form-control" id="biography" name="biography" required>
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" class="form-control" id="address" name="address" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <small class="form-text text-muted">Password must have an uppercase letter, be at least 8 characters long, and include a number.</small>
                    <div class="invalid-feedback" id="password-feedback"></div>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">Register</button>
            </form>
            <small class="form-text text-muted">Already have an account? <a href="login.php">Login Here</a></small> 
        </div>
    </div>
    </div>
</body>
</html>
