<?php
require("config.php");
require("navbar.php");

session_start();
if (!isset($_SESSION["username"]) && !isset($_SESSION['password'])) {
    header("Location: login.php");
    exit();
}
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

$username = $_SESSION["username"];

$userStmt = $pdo->prepare("SELECT firstname, lastname, email, image, gender FROM user WHERE username = ?");
$userStmt->execute([$username]);
$userInfo = $userStmt->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['view_user_blogs'])) {
    $_SESSION['viewing_user_blogs'] = true;
} else {
    $_SESSION['viewing_user_blogs'] = false;
}

if ($_SESSION['viewing_user_blogs']) {
    $stmt = $pdo->prepare("SELECT * FROM post WHERE userName = ?");
    $stmt->execute([$username]);
} else {
    $stmt = $pdo->prepare("SELECT * FROM post WHERE userName = ? AND userName = ?");
    $stmt->execute([$username, $_SESSION['username']]);
}

$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Profile and Blogs</title>
    <style>
        body{
            padding: 100px;
        }
        .card {
            opacity: 0.9; 
            padding: 15px;
            margin-bottom: 20px;
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php include("bg.php"); ?>

<div class="card">
    <div class="card-body" style="color: black;">
        <h2>User Profile:</h2>
        <?php if ($userInfo): ?>
            <p><b>First Name: </b><?php echo $userInfo['firstname']; ?></p>
            <p><b>Last Name: </b><?php echo $userInfo['lastname']; ?></p>
            <p><b>Email: </b><?php echo $userInfo['email']; ?></p>
            <p><b>Gender: </b><?php echo isset($userInfo['gender']) ? $userInfo['gender'] : 'Not specified'; ?></p>
            <?php if (!empty($userInfo['image'])): ?>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($userInfo['image']); ?>" alt="Profile Picture" class="img-fluid mb-2">
            <?php endif; ?>
        <?php else: ?>
            <p>User profile not found.</p>
        <?php endif; ?>
        <div class="btn-container">
            <a href="profile_edit.php" class="btn btn-secondary">Edit</a>
            <a href="logout.php" class="btn btn-primary">Logout</a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body" style="color: black;">
        <h2>Posts:</h2>
        <?php if (count($blogs) > 0): ?>
            <div class="row justify-content-center"><
                <?php foreach ($blogs as $blog): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h3><a href="view_blog.php?blogID=<?php echo $blog['blogID']; ?>"><?php echo $blog['blog_title']; ?></a></h3>
                                <?php if (!empty($blog['blog_pic'])): ?>
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode(file_get_contents($blog['blog_pic'])); ?>" alt="Blog Image" class="img-fluid mb-2">
                                <?php endif; ?>
                                <p><b>Content: </b><?php echo $blog['blog_content']; ?></p>
                                <p><b>Filed Under: </b><?php echo $blog['blog_cat']; ?> Date: <?php echo $blog['dateTime_created']; ?></p>
                                
                                <form action="delete_blog.php" method="post" onsubmit="return confirm('Are you sure you want to delete this blog?');">
                                    <input type="hidden" name="blogID" value="<?php echo $blog['blogID']; ?>">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
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
