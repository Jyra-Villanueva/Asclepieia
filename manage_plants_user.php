<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant Dictionary Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-image: radial-gradient(circle, #5C8374 1px, transparent 1px);
            background-size: 30px 30px; 
            background-position: 0 0, 10px 10px; 
            background-color: #fff; 
            padding-top: 200px;
            margin-bottom: 60px; 
        }

        .container {
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            color: #435d56;
            margin-top: 100px;
        }

        h2 {
            color: #007bff;
        }

        .image-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .image-container img {
            max-width: 50%; 
            max-height: 200px; 
            height: auto;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        h3 {
            color: #28a745;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            color: #435d56;
        }

        li {
            margin-bottom: 8px;
        }

        #edit {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        #edit:hover {
            text-decoration: underline;
        }

        .btn {
            margin-top: 100px;
            position: fixed;
            top: 30px;
            left: 200px;
            z-index: 999;
            background-color: #fff;
            color: #fff;
            border-radius: 50%;
            padding: 30px;
            padding-left: 20px;
            padding-right: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.10);
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #ffff;
            color: #fff;
        }
        .div{
            margin-top: 300px;
            color: #ffff;
    
        }
        .container{
            margin-top: 100px;
        }
    </style>
</head>
<body>
    <?php include("navbar.php");
    include("bg.php"); 
    ?>
    <a href="homepage.php" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i>
    </a>

    <div class="container">
        <?php
        if (isset($_GET['plant'])) {
            $plantDataFile = 'plant_json.json';

            if (file_exists($plantDataFile)) {
                $jsonContent = file_get_contents($plantDataFile);

                $herbData = json_decode($jsonContent, true);

                if (is_array($herbData) && isset($herbData['herb'])) {
                    $selectedPlant = null;
                    foreach ($herbData['herb'] as $plant) {
                        if ($plant['name'] === $_GET['plant']) {
                            $selectedPlant = $plant;
                            break;
                        }
                    }

                    if ($selectedPlant) {
                        echo "<h2>{$selectedPlant['name']}</h2>";
                    
                        if (isset($selectedPlant['images']) && is_array($selectedPlant['images']) && !empty($selectedPlant['images'])) {
                            echo "<h3>Image:</h3>";
                            echo "<div class='image-container'>";
                            foreach ($selectedPlant['images'] as $image) {
                                echo "<img src='$image' alt='{$selectedPlant['name']}'>";
                            }
                            echo "</div>";
                        } else {
                            echo "<p>No image available.</p>";
                        }
                        echo "<p>{$selectedPlant['descrip']}</p>";

                        echo "<h3>Benefits:</h3>";
                        echo "<ul>";
                        if (is_array($selectedPlant['benefits'])) {
                            foreach ($selectedPlant['benefits'] as $benefit) {
                                echo "<li>$benefit</li>";
                            }
                        } else {
                            echo "<li>{$selectedPlant['benefits']}</li>";
                        }
                        echo "</ul>";
                        
                        echo "<h3>Side Effects:</h3>";
                        echo "<ul>";
                        if (is_array($selectedPlant['side'])) {
                            foreach ($selectedPlant['side'] as $sideEffect) {
                                echo "<li>$sideEffect</li>";
                            }
                        } else {
                            echo "<li>{$selectedPlant['side']}</li>";
                        }
                        echo "</ul>";                

                    } else {
                        echo "<p>Plant not found.</p>";
                    }
                } else {
                    echo "<p>Error decoding plant data.</p>";
                }
            } else {
                echo "<p>Plant data file not found.</p>";
            }
        } else {
            echo "<p>Plant not specified.</p>";
        }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
