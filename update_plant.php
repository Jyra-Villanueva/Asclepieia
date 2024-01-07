<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $plantDataFile = 'plant_json.json';

    if (file_exists($plantDataFile)) {
        $jsonContent = file_get_contents($plantDataFile);

        $herbData = json_decode($jsonContent, true);

        if (is_array($herbData) && isset($herbData['herb'])) {
            $selectedPlantIndex = null;
            foreach ($herbData['herb'] as $index => $plant) {
                if ($plant['name'] === $_POST['old_name']) {
                    $selectedPlantIndex = $index;
                    break;
                }
            }

            if ($selectedPlantIndex !== null) {
                $herbData['herb'][$selectedPlantIndex]['descrip'] = $_POST['description'];
                $herbData['herb'][$selectedPlantIndex]['benefits'] = explode(', ', $_POST['benefits']);
                $herbData['herb'][$selectedPlantIndex]['side'] = explode(', ', $_POST['side_effects']);

                $updatedJsonContent = json_encode($herbData, JSON_PRETTY_PRINT);

                file_put_contents($plantDataFile, $updatedJsonContent);

            header('Location: plants.php');
            exit; 
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
    echo "Invalid request.";
}
?>
