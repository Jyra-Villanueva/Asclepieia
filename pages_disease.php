<?php include("navbar.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            background-image: url('logo/bg.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed; 
            margin: 0; 
            padding: 0; 
            margin: 20px;
            margin: auto;
            padding-left: 100px;
            background-color: #f5f5f5;
            margin-top: 100px;
            margin-bottom: 100px;
        }

        .card {
            max-width: 700px;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        h1 {
            color: #008000;
            text-align: center;
            padding: 20px 0;
        }

        img {
            display: block;
            max-width: 100%;
            height: auto;
            margin: 0 auto 10px;
        }

        p {
            padding: 0 20px;
            margin-bottom: 20px;
        }

        #disease_index {
            display: block;
            color: #0000FF;
            text-decoration: none;
            margin: 20px auto;
            text-align: center;
        }

        #disease_index:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="card">
        <?php
            $name = urldecode($_GET['name']);
            $jsonData = file_get_contents('disease.json');
            $diseases = json_decode($jsonData, true);

            $selectedDisease = null;

            foreach ($diseases as $disease) {
                if ($disease['name'] === $name) {
                    $selectedDisease = $disease;
                    break;
                }
            }

            if (!$selectedDisease) {
                header("Location: disease_index.php");
                exit();
            }
        ?>
        
        <h1><?php echo $selectedDisease['name']; ?></h1>
        
        <img src="assets/images/<?php echo $selectedDisease['image']; ?>" alt="<?php echo $selectedDisease['name']; ?>" onerror="console.error('Image not found: <?php echo $selectedDisease['image']; ?>')">

        <p><strong>Description:</strong> <?php echo $selectedDisease['description']; ?></p>

        <p><strong>Remedies:</strong><br>
            <?php
            foreach ($selectedDisease['remedies'] as $remedies) {
                echo $remedies . '<br>';
            }
            ?>
        </p>

        <a id='disease_index' href="disease_index.php">Go back</a>
    </div>
</body>
</html>
