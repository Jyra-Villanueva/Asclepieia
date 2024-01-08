<?php
// Assuming you've included necessary configurations and database connections

session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION['username'])) {
    $commentID = $_POST['commentID'];
    $loggedInUsername = $_SESSION['username'];

    // Fetch comment details from the database
    $stmt = $pdo->prepare("SELECT username FROM comment WHERE commentID = ?");
    $stmt->execute([$commentID]);
    $comment = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($comment && $comment['username'] === $loggedInUsername) {
        // User is the owner of the comment, proceed with deletion
        $deleteStmt = $pdo->prepare("DELETE FROM comment WHERE commentID = ?");
        $deleteStmt->execute([$commentID]);
        // Redirect to the blog view page after deletion
        header("Location: view_blog.php?blogID=" . $blogID);
        exit();
    } else {
        // If user is not the owner, handle unauthorized access
        // Redirect to a page indicating permission denied
        header("Location: permission_denied.php");
        exit();
    }
} else {
    // Handle if the request method is not POST or user is not logged in
    // Redirect to an error page or homepage
    header("Location: error.php");
    exit();
}
?>
