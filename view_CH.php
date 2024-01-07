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
            background-image: url('logo/bg.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed; 
            background-color: #fff; 
            padding-top: 50px;
            margin-bottom: 60px; 
        }

        .container {
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
            color: #435d56;
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

        #btn-back{
            margin-left: 45px;
            position: fixed;
            top: 30px;
            left: 200px;
            z-index: 9999;
            color: #435d56;
            border-radius: 50%;
            padding: 15px;
            padding-left: 20px;
            padding-right: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.10);
            background-color: #fff;
            transition: background-color 0.3s;
        }
        #btn-back:hover{
            background-color: #435d56;
            color: #fff;
        }
    </style>
</head>

<body>
<?php include("navbar.php");?>

    <a id= 'btn-back' href="homepage.php" class="btn fixed-top-btn">
    <i class="fas fa-arrow-left"></i>
    </a>
    <div class="container">
        <?php
        if (isset($_GET['plant'])) {
            $plantDataFile = 'recommend.json';

            if (file_exists($plantDataFile)) {
                $jsonContent = file_get_contents($plantDataFile);

                $herbData = json_decode($jsonContent, true);

                if (is_array($herbData) && isset($herbData['Culinary herbs'])) {
                    $selectedPlant = null;

                    foreach ($herbData['Culinary herbs'] as &$plant) {
                        if ($plant['name'] === $_GET['plant']) {
                            $selectedPlant = $plant;
                            $plant['clickCount'] = isset($plant['clickCount']) ? $plant['clickCount'] + 1 : 1;
                            break;
                        }
                    }

                    usort($herbData['Culinary herbs'], function ($a, $b) {
                        $clickCountA = isset($a['clickCount']) ? $a['clickCount'] : 0;
                        $clickCountB = isset($b['clickCount']) ? $b['clickCount'] : 0;
                        
                        return $clickCountB - $clickCountA;
                    });
                    

                    file_put_contents($plantDataFile, json_encode($herbData, JSON_PRETTY_PRINT));

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
