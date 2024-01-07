<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Plant Identification</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-color: #f8f9fa;
            background-image: url('your-bg-image.jpg'); 
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            color: black; 
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            margin-top: 50px;
        }

        .card {
            margin-top: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 20px;
        }

        h1 {
            margin-bottom: 30px;
            color: black;
        }

        input[type="file"],
        input[type="submit"] {
            color: black;
        }
    </style>
</head>
<body>
    <?php include("navbar.php"); ?>
    <?php include("bg.php"); ?>

    <div class="container"> 

        <h1>Plant Identification</h1>
        
        <form action="identify.php" method="post" enctype="multipart/form-data">
            <input type="file" name="image[]" multiple accept="image/*" />
            <input type="submit" value="Identify Plants" />
        </form>

        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </div>
</body>
</html>
