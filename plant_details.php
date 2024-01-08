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
            padding-bottom: 100px;
            padding-top: 100px;
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

    <a id= 'btn-back' href="display_plants.php" class="btn fixed-top-btn">
    <i class="fas fa-arrow-left"></i>
    </a>
    <div class="container mt-3">
        
        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $jsonData = file_get_contents('plant_json.json');
            $data = json_decode($jsonData, true);

            if (isset($data['herb'])) {
                $plants = is_array($data['herb']) ? $data['herb'] : array_values($data['herb']);

                if ($id >= 0 && $id < 70) { 
                    $plant = $plants[$id];

                    echo '<div class="plant-details">';
                    echo '<h2>' . $plant['name'] . '</h2>';
                    
                    if (isset($plant['images']) && is_array($plant['images'])) {
                        foreach ($plant['images'] as $image) {
                            echo '<img src="' . $image . '" class="img-fluid" alt="' . $plant['name'] . '">';
                        }
                    }

                    echo '<h4 class="bold-text"><br><strong>Description:</strong></h4>';
                    echo '<p>' . $plant['descrip'] . '</p>';

                    if (isset($plant['benefits']) && is_array($plant['benefits'])) {
                        echo '<h4 class="bold-text"><br><strong>Benefits:</strong></h4>';
                        echo '<p>' . implode(', ', $plant['benefits']) . '</p>';
                    } else {
                        echo '<h4 class="bold-text"><br><strong>Benefits:</strong></h4>';
                        echo '<p>' . $plant['benefits'] . '</p>';
                    }

                    if (isset($plant['side']) && is_array($plant['side'])) {
                        echo '<h4 class="bold-text"><br><strong>Side Effects</strong></h4>';
                        echo '<p>' . implode(', ', $plant['side']) . '</p>';
                    } else {
                        echo '<h4 class="bold-text"><br><strong>Side Effects</strong></h4>';
                        echo '<p>' . $plant['side'] . '</p>';
                    }

                    echo '</div>';
                } else {
                    echo '<div class="alert alert-danger mt-3" role="alert">';
                    echo 'Invalid plant ID.';
                    echo '</div>';
                }
            } else {
                echo '<div class="alert alert-danger mt-3" role="alert">';
                echo 'Invalid JSON data. The "herb" key is missing.';
                echo '</div>';
            }
        } else {
            echo '<div class="alert alert-danger mt-3" role="alert">';
            echo 'Missing plant ID.';
            echo '</div>';
        }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>