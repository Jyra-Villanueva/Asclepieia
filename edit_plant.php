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
            padding-top: 50px;
        }

        .container {
            background-color: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }

        h2 {
            color: #007bff;
        }

        textarea,
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .fixed-top-btn {
            margin-left: 45px;
            position: fixed;
            top: 30px;
            left: 200px;
            z-index: 999;
            background-color: #fff;
            color: #435d56;
            border-radius: 50%;
            padding: 15px;
            padding-left: 20px;
            padding-right: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.10);
            transition: background-color 0.3s;
        }
            .fixed-top-btn:hover {
            background-color: #435d56;
            color: #fff;
        }
    </style>
</head>
<body>
    <?php 
    ob_start();
    include("sidebar.php");?>

    <a href="plants.php" class="btn fixed-top-btn">
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
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        if (isset($_POST['old_name'], $_POST['title'], $_POST['description'], $_POST['benefits'], $_POST['side_effects'])) {
                            $oldName = $_POST['old_name'];
                            $newTitle = $_POST['title'];
                            $newDescription = $_POST['description'];
                            $newBenefits = explode(', ', $_POST['benefits']);
                            $newSideEffects = explode(', ', $_POST['side_effects']);

                            foreach ($herbData['herb'] as &$plant) {
                                if ($plant['name'] === $oldName) {
                                    $plant['name'] = $newTitle;
                                    $plant['descrip'] = $newDescription;
                                    $plant['benefits'] = $newBenefits;
                                    $plant['side'] = $newSideEffects;

                                    file_put_contents($plantDataFile, json_encode($herbData, JSON_PRETTY_PRINT));

                                    header("Location: manage_plants.php?plant=" . urlencode($plant['name']));
                                    exit;
                                }
                            }
                        } else {
                            echo "Missing parameters in the request.";
                        }
                    }

                    echo "<h2>Edit {$selectedPlant['name']}</h2>";
                    echo "<form action='edit_plant.php?plant={$selectedPlant['name']}' method='post'>";
                    echo "<input type='hidden' name='old_name' value='{$selectedPlant['name']}'>";

                    echo "<label>Title:</label><br>";
                    echo "<input type='text' name='title' value='{$selectedPlant['name']}'><br>";

                    echo "<label>Description:</label><br>";
                    echo "<textarea name='description'>{$selectedPlant['descrip']}</textarea><br>";

                    echo "<label>Benefits (comma-separated):</label><br>";
                    echo "<input type='text' name='benefits' value='" . implode(', ', (array)$selectedPlant['benefits']) . "'><br>";

                    echo "<label>Side Effects (comma-separated):</label><br>";
                    echo "<input type='text' name='side_effects' value='" . implode(', ', (array)$selectedPlant['side']) . "'><br>";

                   

                    echo "<input type='submit' value='Save Changes'>";
                    echo "</form>";
                } else {
                    echo "Plant not found.";
                }
            } else {
                echo "Error decoding plant data.";
            }
        } else {
            echo "Plant data file not found.";
        }
    } else {
        echo "Plant not specified.";
    }
    ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
