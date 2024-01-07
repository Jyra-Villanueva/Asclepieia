<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $currentPassword = $_POST["currentPassword"];
    $newPassword = $_POST["newPassword"];
    $confirmPassword = $_POST["confirmPassword"];

    echo "Password changed successfully!";
}
?>
