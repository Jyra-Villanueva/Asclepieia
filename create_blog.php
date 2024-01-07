<?php
require_once('config2.php');
include("bg.php");

session_start();
if(!isset($_SESSION["username"]) && !isset($_SESSION['password'])) {
    header("Location: login.php");
    exit();
}

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}  

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION["username"];
    $blog_title = isset($_POST["blogEntry"]) ? $_POST["blogEntry"] : "";
    $blog_content = isset($_POST["content"]) ? $_POST["content"] : "";
    $blog_category = isset($_POST["category"]) ? $_POST["category"] : "";
    $image_path = ''; 
    echo $username;

    if(empty($blog_title) || empty($blog_content) || empty($blog_category)) {
        echo "Error: Please fill all required fields.";
        exit();
    }

    if (isset($_FILES["picture"])) {
        $image_name = $_FILES["picture"]["name"];
        $image_tmp_name = $_FILES["picture"]["tmp_name"];
        $image_path = "C:\\xampp\\htdocs\\users\\uploads\\" . $image_name; 
        move_uploaded_file($image_tmp_name, $image_path);
    }

    $stmt = $pdo->prepare("INSERT INTO post (blog_title, blog_content, dateTime_created, blog_cat, blog_pic, username, rating) VALUES (?, ?, NOW(), ?, ?, ?, ?)");
    $stmt->execute([$blog_title, $blog_content, $blog_category, $image_path, $username, $_POST['ratingValue']]);

    header("Location: homepage.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Blog Entry</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 50px;
            background-color: #fafafa;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: linear-gradient(rgba(0, 0, 0, 0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(0, 0, 0, 0.1) 1px, transparent 1px);
            background-size: 20px 20px;
            z-index: -1;
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

        .container {
            margin-top: 20px;
        }

        h2 {
            text-align: center;
            color: #405de6;
        }

        label {
            color: #333;
        }

        .form-control {
            border: 2px solid #ddd;
            border-radius: 5px;
        }

        .form-control:focus {
            border-color: #405de6;
            box-shadow: 0 0 5px rgba(64, 93, 230, 0.5);
        }

        .form-group select {
            border: 2px solid #ddd;
            border-radius: 5px;
        }

        .form-group select:focus {
            border-color: #405de6;
            box-shadow: 0 0 5px rgba(64, 93, 230, 0.5);
        }

        .form-control-file {
            border: 2px solid #ddd;
            border-radius: 5px;
        }

        .form-control-file:focus {
            border-color: #405de6;
            box-shadow: 0 0 5px rgba(64, 93, 230, 0.5);
        }

        .btn-primary {
            background-color: #405de6;
            border: none;
        }

        .btn-primary:hover {
            background-color: #34495e;
        }
        .rating {
        font-size: 24px; 
        }

        .rating .star {
            cursor: pointer;
            color: gray;
        }

        .rating .star:hover,
        .rating .star.active {
            color: orange;
        }
    </style>
</head>

<body>
    <?php include('navbar.php'); ?>
    <div class="container mt-5">
    <div class="card blog-card">
            <div class="card-body">
        <h2>Post a Feedback</h2>
        <form action="create_blog.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="blogEntry">Title:</label>
                <input type="text" class="form-control" id="blogEntry" name="blogEntry" required>
            </div>
            <div class="form-group">
                <label for="content">Content:</label>
                <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
            </div>
            <div class="form-group">
            <label for="category">Types of Plants:</label>
                <select class="form-control" id="category" name="category" required>
                    <option value="flowering">Flowering Plants</option>
                    <option value="succulents">Succulents</option>
                    <option value="ferns">Ferns</option>
                    <option value="trees">Trees</option>
                    <option value="shrubs">Shrubs</option>
                    <option value="vegetables">Vegetables</option>
                    <option value="herbs">Herbs</option>
                    <option value="cacti">Cacti</option>
                    <option value="orchids">Orchids</option>
                </select>
            </div>
            <div class="form-group">
                <label for="picture">Insert Picture:</label>
                <input type="file" class="form-control-file" id="picture" name="picture">
            </div>
            <label>How Effective?</label>
        <div class="rating">
            <span class="star" data-star="1">&#9733;</span>
            <span class="star" data-star="2">&#9733;</span>
            <span class="star" data-star="3">&#9733;</span>
            <span class="star" data-star="4">&#9733;</span>
            <span class="star" data-star="5">&#9733;</span>
        </div>
        <input type="hidden" id="ratingValue" name="ratingValue" value="0">

            <button type="submit" class="btn btn-primary" href="homepage.php">ADD ENTRY</button>
        </form>
    </div>
    </div>
    </div>
    <script>
        const stars = document.querySelectorAll('.star');
        const ratingValue = document.getElementById('ratingValue');

        stars.forEach((star) => {
            star.addEventListener('click', () => {
                const starValue = parseInt(star.getAttribute('data-star'));
                ratingValue.value = starValue;

                stars.forEach((s, index) => {
                    if (index < starValue) {
                        s.classList.add('active');
                    } else {
                        s.classList.remove('active');
                    }
                });
            });
        });

    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
