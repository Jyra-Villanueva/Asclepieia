<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['addPlant'])) {
    $plantDataFile = 'plant_json.json';

    if (file_exists($plantDataFile)) {
        $jsonContent = file_get_contents($plantDataFile);

        $herbData = json_decode($jsonContent, true);

        if (is_array($herbData) && isset($herbData['herb'])) {
            $newPlant = [
                'name' => htmlspecialchars($_POST['plantName']),
                'descrip' => htmlspecialchars($_POST['plantDescription']),
                'benefits' => htmlspecialchars($_POST['plantBenefits']),
                'side' => htmlspecialchars($_POST['plantSideEffects']),
                'images' => [], 
            ];

            if (isset($_FILES['plantImage']) && $_FILES['plantImage']['error'][0] === UPLOAD_ERR_OK) {
                $uploadDir = 'images/';
                $uploadedImagePaths = [];

                foreach ($_FILES['plantImage']['tmp_name'] as $key => $tmp_name) {
                    $uploadFile = $uploadDir . basename($_FILES['plantImage']['name'][$key]);

                    if (move_uploaded_file($tmp_name, $uploadFile)) {
                        $uploadedImagePaths[] = $uploadFile;
                    } else {
                        echo "Error uploading image.";
                    }
                }

                $newPlant['images'] = $uploadedImagePaths;
            }

            $herbData['herb'][] = $newPlant;

            $updatedJsonContent = json_encode($herbData, JSON_PRETTY_PRINT);

            file_put_contents($plantDataFile, $updatedJsonContent);

            header("Location: plants.php");
            exit;
        } else {
            echo "Error decoding plant data.";
        }
    } else {
        echo "Plant data file not found.";
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['deletePlant'])) {
    if (isset($_POST['plant'])) {
        $plantDataFile = 'plant_json.json';

        if (file_exists($plantDataFile)) {
            $jsonContent = file_get_contents($plantDataFile);

            $herbData = json_decode($jsonContent, true);

            if (is_array($herbData) && isset($herbData['herb'])) {
                foreach ($herbData['herb'] as $key => $plant) {
                    if ($plant['name'] === $_POST['plant']) {
                        unset($herbData['herb'][$key]);

                        $updatedJsonContent = json_encode($herbData, JSON_PRETTY_PRINT);

                        file_put_contents($plantDataFile, $updatedJsonContent);

                        header("Location: plants.php?action=delete");
                        exit;
                    }
                }

                echo "Plant not found.";
            } else {
                echo "Error decoding plant data.";
            }
        } else {
            echo "Plant data file not found.";
        }
    } else {
        echo "Plant not specified.";
    }
}
?>
