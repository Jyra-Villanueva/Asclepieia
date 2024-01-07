<?php include("manage_plants_action.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant Dictionary Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <style>
        body {
            background-image: radial-gradient(circle, #5C8374 1px, transparent 1px);
            background-size: 30px 30px;
            background-position: 0 0, 10px 10px;
            background-color: #fff; 
            padding-top: 50px;
            padding-bottom: 100px;
        }

        .letter-heading {
            font-size: 1.5rem;
            margin-top: 20px;
        }

        .plant-list {
            list-style: none;
            padding: 0;
        }

        .plant-item {
            margin-bottom: 10px;
        }

        .container {
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
            padding: 50px;
        }

        .btn-group {
            margin-bottom: 20px;
        }
        .alphabet-gallery {
            display: flex;
            justify-content: space-around;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .alphabet-letter {
            font-size: 1.2rem;
            cursor: pointer;
            transition: color 0.3s;
        }

        .alphabet-letter:hover {
            color: blue;
            font-weight: 700;
        }

        .plant-list {
            list-style: none;
            padding: 0;
        }

        .plant-item {
            margin-bottom: 10px;
        }

        .letter-heading {
            font-size: 1.5rem;
            margin-top: 20px;
        }

        body {
            padding-top: 70px;
        }
    </style>
<body>
<?php include("sidebar.php"); ?>


<div class="container mt-3">
    <?php
    $action = isset($_GET['action']) ? $_GET['action'] : '';

    if ($action === 'update') {
        echo "<div class='alert alert-success' role='alert'>Note updated successfully!</div>";
    } elseif ($action === 'delete') {
        echo "<div class='alert alert-danger' role='alert'>Plant deleted successfully!</div>";
    }
    ?>

<div class="mb-3 d-flex justify-content-end">
    <button class="btn btn-success mr-2" data-toggle="modal" data-target="#addPlantModal">Add Plant</button>
    <button class="btn btn-danger" data-toggle="modal" data-target="#deletePlantModal">Delete Plant</button>
</div>


<?php
$action = isset($_GET['action']) ? $_GET['action'] : '';

$plantDataFile = 'plant_json.json';

if (file_exists($plantDataFile)) {
    $jsonContent = file_get_contents($plantDataFile);

    $herbData = json_decode($jsonContent, true);

    if (is_array($herbData) && isset($herbData['herb'])) {
        usort($herbData['herb'], function ($a, $b) {
            return strcasecmp($a['name'], $b['name']);
        });
        echo "<div class='alphabet-gallery'>";
        foreach (range('A', 'Z') as $letter) {
            echo "<span class='alphabet-letter' data-letter='$letter'>$letter</span>";
        }
        echo "</div>";
        $currentLetter = '';
        foreach ($herbData['herb'] as $plant) {
            $firstLetter = strtoupper(substr($plant['name'], 0, 1));
            if ($firstLetter !== $currentLetter) {
                echo "<h2 class='letter-heading'>$firstLetter</h2>";
                $currentLetter = $firstLetter;
            }

            echo "<div class='plant-item'>";
            echo "<h3><a href='manage_plants.php?plant=" . urlencode($plant['name']) . "'>{$plant['name']}</a></h3>";
            echo "</div>";
        }
    } else {
        echo "Error decoding plant data.";
    }
} else {
    echo "Plant data file not found.";
}

?>
</div>

    <div class="modal fade" id="addPlantModal" tabindex="-1" role="dialog" aria-labelledby="addPlantModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPlantModalLabel">Add New Plant</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                <form action="manage_plants_action.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="plantName">Plant Name:</label>
                        <input type="text" class="form-control" id="plantName" name="plantName" required>
                    </div>
                    <div class="form-group">
                        <label for="plantDescription">Plant Description:</label>
                        <textarea class="form-control" id="plantDescription" name="plantDescription" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="plantBenefits">Benefits:</label>
                        <input type="text" class="form-control" id="plantBenefits" name="plantBenefits">
                    </div>
                    <div class="form-group">
                        <label for="plantSideEffects">Side Effects:</label>
                        <input type="text" class="form-control" id="plantSideEffects" name="plantSideEffects">
                    </div>
                    <div class="form-group">
                                <label for="plantImage">Plant Images:</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="plantImage" name="plantImage[]" accept="image/*" required>
                                    <label class="custom-file-label" for="plantImage">Choose files</label>
                                </div>
                                <small class="form-text text-muted" id="imageSelectedMessage">Select images for the plant.</small>
                            </div>

                            <button type="submit" class="btn btn-primary" name="addPlant">Add Plant</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

<div class="modal fade" id="deletePlantModal" tabindex="-1" role="dialog" aria-labelledby="deletePlantModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletePlantModalLabel">Delete Plant</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="manage_plants_action.php" method="POST">
                    <div class="form-group">
                        <label for="deletePlantSelect">Select Plant to Delete:</label>
                        <select class="form-control" id="deletePlantSelect" name="plant">
                            <?php
                            foreach ($herbData['herb'] as $plant) {
                                echo "<option value='{$plant['name']}'>{$plant['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-danger" name="deletePlant">Delete Plant</button>
                </form>
            </div>
        </div>
    </div>
</div>

        <script>
            document.getElementById('plantImage').addEventListener('change', function () {
                var files = this.files;
                var fileList = '';
                for (var i = 0; i < files.length; i++) {
                    fileList += files[i].name + ', ';
                }
                if (fileList.length > 0) {
                    fileList = fileList.slice(0, -2); 
                    document.getElementById('imageSelectedMessage').innerText = 'Images selected: ' + fileList;
                } else {
                    document.getElementById('imageSelectedMessage').innerText = 'Select images for the plant.';
                }
            });
            document.querySelectorAll('.alphabet-letter').forEach(letter => {
            letter.addEventListener('click', function () {
                const selectedLetter = this.dataset.letter;
                const plantItem = document.querySelector(`.plant-item h3 a[href^='manage_plants.php?plant=${selectedLetter.toLowerCase()}'], .plant-item h3 a[href^='manage_plants.php?plant=${selectedLetter.toUpperCase()}']`);
                if (plantItem) {
                    const yOffset = -200; 
                    const y = plantItem.getBoundingClientRect().top + window.pageYOffset + yOffset;

                    window.scrollTo({ top: y, behavior: 'smooth' });
                }
            });
        });


        </script>

</body>
</html>
