
<?php
require_once('config2.php');
session_start();

if (!isset($_SESSION['user_id']) && !isset($_COOKIE['user_id']) && !isset($_COOKIE['auth_token'])) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header("Location: login.php");
    exit();
}

if (isset($_COOKIE['user_id']) && isset($_COOKIE['auth_token'])) {
    $user_id = $_COOKIE['user_id'];
    $auth_token = $_COOKIE['auth_token'];

    $query = "SELECT * FROM user WHERE user_id = ? AND auth_token = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "is", $user_id, $auth_token);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($user = $result->fetch_assoc()) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $user['username'];
    } else {
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        header("Location: login.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = $_POST['comment'];
    $blogID = $_POST['blogID'];

    $comment = htmlspecialchars($comment);

    $username = $_SESSION['username'];
    $dateTime = date("Y-m-d H:i:s");
    $query = "INSERT INTO comment (blogID, userNAME, comment, datetime) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, "isss", $blogID, $username, $comment, $dateTime);

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $redirect_url = isset($_SESSION['redirect_url']) ? $_SESSION['redirect_url'] : "homepage.php";
    unset($_SESSION['redirect_url']);
    header("Location: $redirect_url");
    exit();
} else {
    header("Location: homepage.php");
    exit();
}


?>