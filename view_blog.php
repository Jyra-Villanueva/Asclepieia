<?php
require_once('config2.php');

if (isset($_GET['blogID'])) {
    $blogID = $_GET['blogID'];

    $stmt = $conn->prepare("SELECT * FROM post WHERE blogID = ?");
    $stmt->bind_param('i', $blogID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $blogEntry = $result->fetch_assoc();
    } else {
        echo "Blog entry not found.";
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM comment WHERE blogID = ?");
    $stmt->bind_param('i', $blogID);
    $stmt->execute();
    $commentsResult = $stmt->get_result();

    if ($commentsResult->num_rows > 0) {
        $comments = $commentsResult->fetch_all(MYSQLI_ASSOC);
    } else {
        $comments = [];
    }
} else {
    echo "Invalid request.";
    exit();
}

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

if (isset($_GET['blogID'])) {
    $blogID = $_GET['blogID'];

    $stmt = $pdo->prepare("SELECT * FROM post WHERE blogID = ?");
    $stmt->execute([$blogID]);
    $blog = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT * FROM comment WHERE blogID = ?");
    $stmt->execute([$blogID]);
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT username FROM post WHERE blogID = ?");
    $stmt->execute([$blog['blogID']]);
    $author = $stmt->fetch(PDO::FETCH_ASSOC);
    $authorName = $author['username'];
} else {
    header("Location: homepage.php");
    exit();
}

foreach ($comments as &$comment) {
    $stmt = $pdo->prepare("SELECT username FROM comment WHERE userNAME = ?");
    $stmt->execute([$comment['userNAME']]);
    
    if ($stmt) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && array_key_exists('username', $user)) {
            $comment['username'] = $user['username'];
        } else {
            error_log("Debug: User not found for comment with ID {$comment['commentID']}");

            $comment['username'] = 'Unknown User';
        }
    } else {
        error_log("Debug: Query failed for comment with ID {$comment['commentID']}");
        
        $comment['username'] = 'Unknown User';
    }
}
unset($comment); 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Blog Entry</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        h2 {
            color: #405de6;
            font-size: 15px;
        }

        img {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
            margin-bottom: 20px;
            border-radius: 10px;
            
        }

        p {
            margin-top: 20px;
            color: #333;
        }

        h3 {
            color: #405de6;
            margin-top: 20px;
        }
        .blog-card {
            margin-top: 20px;
        }

        .blog-content {
            margin: 20px 0;
        }

        .comment-card {
            margin-top: 10px;
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .comment-card-body {
            padding: 15px;
        }

        .card {
            margin-top: 10px;
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 15px;
        }

        .card-text {
            color: #333;
        }

        .form-group {
            margin-top: 20px;
        }

        label {
            color: #333;
        }

        textarea {
            border: 2px solid #ddd;
            border-radius: 5px;
            width: 100%;
        }

        textarea:focus {
            border-color: #405de6;
            box-shadow: 0 0 5px rgba(64, 93, 230, 0.5);
        }

        .btn-primary {
            background-color: #405de6;
            border: none;
            width: 100%;
            margin-top: 10px;
        }

        .btn-primary:hover {
            background-color: #34495e;
        }
        body {
            margin-bottom: 200px;
        }
        .btn-primary {
            margin-bottom: 60px;
        }
        img {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
            border-radius: 10px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        footer{
            padding-bottom: 60px;
        }
    </style>
</head>

<body>
    <?php include('navbar.php');
    include("bg.php");
    ?>
<div class="container mt-5">
    <div class="card blog-card">
        <div class="card-body">
            <div class="blog-details">
                <h2>"<?php echo $blog['blog_title']; ?>"</h2>
                <p><b>Creator: </b><?php echo $authorName; ?></p>
                <?php if (!empty($blog['blog_pic'])): ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode(file_get_contents($blog['blog_pic'])); ?>" alt="Blog Image" class="img-fluid rounded">
                <?php endif; ?>
                <br>
                <p><b>Filed Under: </b> <?php echo $blog['blog_cat']; ?> <b>Date: </b> <?php echo $blog['dateTime_created']; ?></p>
                <p><b>Content: </b><?php echo $blog['blog_content']; ?></p>
                <?php if ($blogEntry['rating'] > 0): ?>
                    <div class="rating">

                                <h3>Rating:</h3>
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <?php if ($i <= $blog['rating']): ?>
                                        <span class="star" style="color: orange;">&#9733;</span>
                                    <?php else: ?>
                                        <span class="star" style="color: gray;">&#9733;</span>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    </div>
        </div>
        <div class="card">
            <div class="card-body">
        <h3>Comments</h3>
        <?php foreach ($comments as $comment) : ?>
            <div class="card comment-card">
        <div class="card-body comment-card-body">
            <p class="card-text"><?= htmlspecialchars($comment['username']) ?>
            <br><br>
             says:<br><?= htmlspecialchars($comment['comment']); ?></p>
        
        </div>
    </div>
        <?php endforeach; ?>


                <form action="post_comment.php" method="post">
                    <input type="hidden" name="blogID" value="<?= $blogID; ?>">
                    <div class="form-group">
                        <label for="comment">Your Comment:</label>
                        <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Post a Comment</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
