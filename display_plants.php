//display_plats.php

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Display Plants</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 20px;
        }

        .plant-card {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #d6d8db;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            cursor: pointer;
            height: 350px; /* Set your desired height */
            overflow: hidden;
            touch-action: pan-y; /* Allow vertical scrolling on touch devices */
        }

        .plant-card-inner {
            overflow-y: auto;
            height: 100%;
            margin-right: -17px; /* Adjust for the scrollbar width */
        }

        .plant-card img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        .bold-text {
            font-weight: bold;
        }

        h5 {
            color: #007bff;
        }
        h2 {
            color: #ffffff;
        }
        p {
            color: #212529;
        }

        #text {
            color: #fff;
        }
    </style>
</head>

<body>
    <?php include("navbar.php"); ?>
    <?php include("bg.php"); ?>

    <div class="container mt-3">
        <h2>Plants Information</h2>

        <div class="grid-container">
            <?php
            // Load JSON data from the file
            $jsonData = file_get_contents('plant_json.json');
            $data = json_decode($jsonData, true);

            // Check if the 'herb' key exists in the JSON data
            if (isset($data['herb'])) {
                $plants = is_array($data['herb']) ? $data['herb'] : array_values($data['herb']);

                // Loop through each plant
                foreach ($plants as $index => $plant) {
                    // Check if essential keys exist in the plant data
                    if (isset($plant['name'], $plant['descrip'])) {
                        // Display plant details
                        echo '<a href="plant_details.php?id=' . $index . '" style="text-decoration: none; color: inherit;">';
                        echo '<div class="card plant-card">';
                        
                        // Display plant image if available
                        if (isset($plant['images']) && is_array($plant['images']) && !empty($plant['images'][0])) {
                            echo '<img src="' . $plant['images'][0] . '" class="card-img-top" alt="' . $plant['name'] . '">';
                        }

                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . $plant['name'] . '</h5>';
                        echo '<p class="card-text"><strong>Description:</strong> ' . $plant['descrip'] . '</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</a>';
                    } else {
                        // Handle missing keys
                        echo '<div class="alert alert-danger mt-3" role="alert">';
                        echo 'Invalid plant data. Essential keys are missing.';
                        echo '</div>';
                    }
                }
            } else {
                echo '<div class="alert alert-danger mt-3" role="alert">';
                echo 'Invalid JSON data. The "herb" key is missing.';
                echo '</div>';
            }
            ?>

            
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
