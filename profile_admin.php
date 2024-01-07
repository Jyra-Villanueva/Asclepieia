<?php
require("config.php");
require("sidebar.php");

session_start();
if (!isset($_SESSION["username"]) && !isset($_SESSION['password'])) {
    header("Location: login.php");
    exit();
}

include("bg.php");

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

$username = $_SESSION["username"];

if ($_SESSION['user_type'] !== 'admin') {
    header("Location: unauthorized.php"); 
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_blog'])) {
    $blogTitle = $_POST['blog_title'];
    $blogContent = $_POST['blog_content'];
    $blogCategory = $_POST['blog_category'];


    $insertStmt = $pdo->prepare("INSERT INTO post (userName, blog_title, blog_content, blog_cat) VALUES (?, ?, ?, ?)");
    $insertStmt->execute([$username, $blogTitle, $blogContent, $blogCategory]);
}

$stmt = $pdo->prepare("SELECT * FROM post WHERE userName = ?");
$stmt->execute([$username]);
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
</head>
<body>

    <div class="card">
        <div class="card-body" style="color: black;">
            <h2>Admin Profile:</h2>
            <div class="btn-container">
                <a href="logout.php" class="btn btn-primary">Logout</a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body" style="color: black;">
            <h2>Add New Blog Post:</h2>
            <form method="post" action="">
                <label for="blog_title">Title:</label>
                <input type="text" name="blog_title" required>

                <label for="blog_content">Content:</label>
                <textarea name="blog_content" required></textarea>

                <label for="blog_category">Category:</label>
                <input type="text" name="blog_category" required>

                <button type="submit" name="add_blog" class="btn btn-primary">Add Blog</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body" style="color: black;">
            <h2>Existing Blog Posts:</h2>
            <?php if (count($blogs) > 0): ?>
                <div class="row justify-content-center">
                    <?php foreach ($blogs as $blog): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h3><a href="view_blog.php?blogID=<?php echo $blog['blogID']; ?>"><?php echo $blog['blog_title']; ?></a></h3>
                                    <p><b>Content: </b><?php echo $blog['blog_content']; ?></p>
                                    <p><b>Filed Under: </b><?php echo $blog['blog_cat']; ?> Date: <?php echo $blog['dateTime_created']; ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No blogs available.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
