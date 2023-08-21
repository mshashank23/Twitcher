<?php
if (isset($_POST["password"])) {
    $password = $_POST["password"];

    if (!isPasswordValid($password)) {
        echo "Password must have an uppercase letter, be at least 8 characters long, and include a number.";
    }
}

function isPasswordValid($password) {
    $regex = "/^(?=.*[A-Z])(?=.*\d).{8,}$/";
    return preg_match($regex, $password);
}
?>
