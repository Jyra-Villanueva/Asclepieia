<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require("config.php");  

    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }

    $blogID = $_POST['blogID'];
    $username = $_SESSION['username'];

    $stmt = $pdo->prepare("DELETE FROM post WHERE blogID = ? AND userName = ?");
    $stmt->execute([$blogID, $username]);


    header("Location: profile.php");
    exit();
} else {
    echo "Invalid request method.";
    exit();
}
?>
