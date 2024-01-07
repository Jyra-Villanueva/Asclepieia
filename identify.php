<?php include("navbar.php");
include("bg.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Plant Identification</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .plant-card {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .plant-card img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }
        .bold-text {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card plant-card">
            <div class="card-body">
<?php
function encodeImages($images){
    $encoded_images = array();
    foreach($images['tmp_name'] as $image){
        $encoded_images[] = base64_encode(file_get_contents($image));
    }
    return $encoded_images;
}

function identifyPlants($file_names){
    $api_key = "gtl0pyQO6i27Xx7gbmf1BImPGn6cqGaWhIMCz84qiUO7aWfeba"; 

    $encoded_images = encodeImages($file_names);

    $params = array(
        "api_key" => $api_key,
        "images" => $encoded_images,
        "modifiers" => ["crops_fast", "similar_images"],
        "plant_language" => "en",
        "plant_details" => array(
            "common_names",
            "url",
            "name_authority",
            "wiki_description",
            "taxonomy",
            "synonyms"
        ),
    );

    $params = json_encode($params);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.plant.id/v2/identify");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:application/json"));

    $result = curl_exec($ch);

    if(curl_errno($ch)) {
        $error_message = curl_error($ch);
        return "Error: $error_message";
    }

    curl_close($ch);

    return $result;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['image'])) {
    $images = $_FILES['image'];
    $result = identifyPlants($images);

    $decoded_result = json_decode($result, true);

    if (isset($decoded_result['suggestions'])) {
        echo "<h1>Plant Identification Result:</h1>";

        foreach ($decoded_result['suggestions'] as $suggestion) {
            echo "<div><br>";
            echo "<h2>Plant Name: <br>" . $suggestion['plant_name'] . "</h2>";
            echo "<p>Common Names: <br>" . implode(", ", $suggestion['plant_details']['common_names']) . "</p>";
            echo "<p>Description: <br>" . $suggestion['plant_details']['wiki_description']['value'] . "</p>";
            echo "<p>More Info: <a href='" . $suggestion['plant_details']['url'] . "' target='_blank'>Plant.id</a></p>";
            
            if (isset($suggestion['images'])) {
                echo "<h3>Plant Images:</h3>";
                foreach ($suggestion['images'] as $image) {
                    echo "<img src='" . $image['url'] . "' alt='Plant Image' style='max-width: 300px;'>";
                }
            }
            
            echo "</div>";
        }
    } else {
        echo "No plant identification found.";
    }
} else {
    echo "No images uploaded.";
}
?>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>