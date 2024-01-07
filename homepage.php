<?php
require("config.php");
session_start();

if (isset($_SESSION['username'])) {
    $loggedInUser = $_SESSION['username'];
} else {
    header("Location: login.php");
    exit();
}
?>

<?php include("navbar.php");?>
<div class="container mt-3">
    <form action="find_plants.php" method="POST" class="mb-3">
        <div class="form-row">
            <div class="col">
                <label for="searchPlant">Search for a Plant:</label>
                <input type="text" class="form-control" id="searchPlant" name="searchPlant" placeholder="Enter plant name">
                <div id="searchResults" class="list-group"></div>
            </div>
        </div>
    </form>

  <div id="searchResults" class="list-group"></div>

<script>
            function handleInput() {
                var searchPlantValue = document.getElementById('searchPlant').value.trim();

                if (searchPlantValue !== '') {
                    fetchMatchingPlants(searchPlantValue.toLowerCase());
                } else {
                    document.getElementById('searchResults').innerHTML = '';
                }
            }

            function fetchMatchingPlants(searchValue) {
                fetch('plant_json.json')
                    .then(response => response.json())
                    .then(data => {
                        var herbArray = Array.isArray(data.herb) ? data.herb : Object.values(data.herb);

                        var matchingPlants = herbArray.filter(function (plant) {
                            return plant.name.toLowerCase().startsWith(searchValue);
                        });

                        displayMatchingPlants(matchingPlants);
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }

            function displayMatchingPlants(plants) {
                var searchResultsContainer = document.getElementById('searchResults');
                searchResultsContainer.innerHTML = '';

                if (plants.length > 0) {
                    var resultList = document.createElement('ul');
                    resultList.classList.add('list-group');

                    plants.forEach(function (plant) {
                        var listItem = document.createElement('li');
                        listItem.classList.add('list-group-item');

                        var link = document.createElement('a');
                        link.textContent = plant.name;
                        link.href = 'view_plants_user.php?plant=' + encodeURIComponent(plant.name);

                        listItem.appendChild(link);
                        resultList.appendChild(listItem);
                    });

                    searchResultsContainer.appendChild(resultList);
                } else {
                    var noResultsItem = document.createElement('div');
                    noResultsItem.classList.add('list-group-item');
                    noResultsItem.textContent = 'No matching plants found.';
                    searchResultsContainer.appendChild(noResultsItem);
                }
            }

            document.getElementById('searchPlant').addEventListener('input', handleInput);

            document.getElementById('searchButton').addEventListener('click', function (event) {
                event.preventDefault(); 

                handleInput();
            });
        </script>
</div>
<div class="container mt-3">
        
        <?php

            $plantDataFile = 'plant_json.json';

            if (file_exists($plantDataFile)) {
                $jsonContent = file_get_contents($plantDataFile);
                $herbData = json_decode($jsonContent, true);

                require("config.php");

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT question_7, username FROM questionnaire_responses";
                $result = $conn->query($sql);

                $rows = $result->fetch_all(MYSQLI_ASSOC);

                $authorizedUser = false;

                foreach ($rows as $row) {
                    $question_7_value = $row["question_7"];
                    $user_username = $row["username"];
                    if ($user_username === $loggedInUser) {
                        $authorizedUser = true;
                        break; 
                    }
                }

                if ($question_7_value === 'Medicinal herbs') {
                    $json_file_path = "recommend.json";

                    if (file_exists($json_file_path)) {
                        $json_data = file_get_contents($json_file_path);
                    
                        $decoded_data = json_decode($json_data, true);
                    
                        if (isset($decoded_data[$question_7_value])) {
                            $medicinal_herbs_data = $decoded_data[$question_7_value];
                            echo '<div id="medicinalHerbsRecommendation" class="recommendation-section">';
                            echo '<h2>Recommendation:</h2>';
                            echo '<div class="row g-3">';
                            foreach ($medicinal_herbs_data as $herb) {
                                $name = $herb['name'];
                                $images = $herb['images'];
                    
                                echo '<div class="col-md-3">';
                                echo '<a id="medicinalHerbsRecommendation" href="view_MH.php?plant=' . urlencode($name) . '" class="card-link">';
                                echo '<div class="card" style="width: 17rem;">';
                                echo '<img src="' . $images[0] . '" class="card-img-top" alt="' . $name . '">';
                                echo '<div class="card-body">';
                                echo '<h5 class="card-title">' . $name . '</h5>';
                                echo '</div>';
                                echo '</div>';
                                echo '</a>';
                                echo '</div>';
                            }
                            echo '</div>';
                            echo '</div>';
                        } else {
                            echo "No data found for the given value of question_7.";
                        }
                    } else {
                        echo "JSON file not found.";
                    }       
                }else {
                    if ($question_7_value === 'Culinary herbs') {
                            $json_file_path = "recommend.json";
        
                            if (file_exists($json_file_path)) {
                                $json_data = file_get_contents($json_file_path);
                            
                                $decoded_data = json_decode($json_data, true);
                            
                                if (isset($decoded_data[$question_7_value])) {
                                    $medicinal_herbs_data = $decoded_data[$question_7_value];
                                    echo '<div id="medicinalHerbsRecommendation" class="recommendation-section">';
                                    echo '<h2>Recommendation:</h2>';
                                    echo '<div class="row g-3">';
                                    foreach ($medicinal_herbs_data as $herb) {
                                        $name = $herb['name'];
                                        $images = $herb['images'];
                            
                                        echo '<div class="col-md-3">';
                                        echo '<a id="medicinalHerbsRecommendation" href="view_CH.php?plant=' . urlencode($name) . '" class="card-link">';
                                        echo '<div class="card" style="width: 17rem;">';
                                        echo '<img src="' . $images[0] . '" class="card-img-top" alt="' . $name . '">';
                                        echo '<div class="card-body">';
                                        echo '<h5 class="card-title">' . $name . '</h5>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo '</a>';
                                        echo '</div>';
                                    }
                                    echo '</div>';
                                    echo '</div>';
                                } else {
                                    echo "No data found for the given value of question_7.";
                                }
                            } else {
                                echo "JSON file not found.";
                            }
                        } else { 
                            if ($question_7_value === 'Edible flowers') {
                            $json_file_path = "recommend.json";
        
                            if (file_exists($json_file_path)) {
                                $json_data = file_get_contents($json_file_path);
                            
                                $decoded_data = json_decode($json_data, true);
                            
                                if (isset($decoded_data[$question_7_value])) {
                                    $medicinal_herbs_data = $decoded_data[$question_7_value];
                                    echo '<div id="medicinalHerbsRecommendation" class="recommendation-section">';
                                    echo '<h2>Recommendation:</h2>';
                                    echo '<div class="row g-3">';
                                    foreach ($medicinal_herbs_data as $herb) {
                                        $name = $herb['name'];
                                        $images = $herb['images'];
                            
                                        echo '<div class="col-md-3">';
                                        echo '<a id="medicinalHerbsRecommendation" href="view_EF.php?plant=' . urlencode($name) . '" class="card-link">';
                                        echo '<div class="card" style="width: 17rem;">';
                                        echo '<img src="' . $images[0] . '" class="card-img-top" alt="' . $name . '">';
                                        echo '<div class="card-body">';
                                        echo '<h5 class="card-title">' . $name . '</h5>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo '</a>';
                                        echo '</div>';
                                    }
                                    echo '</div>';
                                    echo '</div>';
                                } else {
                                    echo "No data found for the given value of question_7.";
                                }
                            } else {
                                echo "JSON file not found.";
                            }
                        }
                    }
                    }
                $conn->close();

                
                if (is_array($herbData['herb'])) {
                    $plantsWithClickCount = array_filter($herbData['herb'], function ($plant) {
                        return isset($plant['clickCount']);
                    });

                    usort($plantsWithClickCount, function ($a, $b) {
                        return $b['clickCount'] - $a['clickCount'];
                    });

                    if (!empty($plantsWithClickCount)) {
                        $topClickedPlants = array_slice($plantsWithClickCount, 0, 10);

                        echo '<div id="topClickedContainer" onmousedown="startDragging(event)" onmouseup="stopDragging()" onmouseleave="stopDragging()">';
                        echo '<h2><br>Most Viewed Plants</h2>';
                        echo '<div id="topClickedPlants" class="top-clicked-plants-container">';
                        foreach ($topClickedPlants as $plant) {
                            echo '<a href="view_all.php?plant=' . urlencode($plant['name']) . '" class="top-plant-card">';
                            echo '<img src="' . $plant['images'][0] . '" alt="' . $plant['name'] . '" class="card-img-top">';
                            echo '<h5 class="card-title">' . $plant['name'] . '</h5>';
                            echo '</a>';
                        }
                        echo '</div>';
                        echo '</div>';
                    }
                }
            }
            if (!empty($herbData['herb'])) {
                $plantsWithCommentCount = array_filter($herbData['herb'], function ($plant) {
                    return isset($plant['commentCount']);
                });
        
                usort($plantsWithCommentCount, function ($a, $b) {
                    return $b['commentCount'] - $a['commentCount'];
                });
        
                if (!empty($plantsWithCommentCount)) {
                    $topCommentedPlants = array_slice($plantsWithCommentCount, 0, 5);
        
                    echo '<div id="topCommentedContainer" class="scrollable-container overflow-hidden">';
                    echo '<h2><br>Top 5 Most Commented Plants</h2>';
                    echo '<div id="topCommentedPlants" class="scrollable-content top-clicked-plants-container">';
                    foreach ($topCommentedPlants as $plant) {
                        echo '<a href="view_all.php?plant=' . urlencode($plant['name']) . '" class="top-plant-card">';
                        echo '<img src="' . $plant['images'][0] . '" alt="' . $plant['name'] . '" class="card-img-top">';
                        echo '<h5 class="card-title">' . $plant['name'] . '</h5>';
                        echo '<p>'. $plant['commentCount'] . ' comments</p>';
                        echo '</a>';
                    }
                    echo '</div>';
                    echo '</div>';
                }
            }
            
        ?>
<script>
    var isDragging = false;
    var initialMouseX, initialScrollX;
    var topClickedPlants = document.getElementById('topClickedPlants');
    var topClickedContainer = document.getElementById('topClickedContainer');

    function startDragging(event) {
        isDragging = true;
        initialMouseX = event.clientX;
        initialScrollX = topClickedPlants.scrollLeft;
        topClickedPlants.style.cursor = 'grabbing';

        topClickedPlants.style.transition = 'none';

        document.addEventListener('mousemove', handleDragging);
        document.addEventListener('mouseup', stopDragging);
    }

    function stopDragging() {
        isDragging = false;
        topClickedPlants.style.cursor = 'grab';

        topClickedPlants.style.transition = '';

        document.removeEventListener('mousemove', handleDragging);
        document.removeEventListener('mouseup', stopDragging);
    }

    topClickedContainer.addEventListener('mousedown', function (event) {
        startDragging(event);
    });

    document.addEventListener('mousemove', function (event) {
        if (isDragging) {
            handleDragging(event);
        }
    });
</script>
    </div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
<?php
require("config.php");

include("bg.php");

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

if (isset($_POST['view_user_blogs'])) {
    $_SESSION['viewing_user_blogs'] = true;
} else {
    $_SESSION['viewing_user_blogs'] = false;
}

if ($_SESSION['viewing_user_blogs']) {
    $stmt = $pdo->prepare("SELECT * FROM post WHERE userNAME = ?");
    $stmt->execute([$username]);
} else {
    $stmt = $pdo->query("SELECT * FROM post");
}

$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-image: radial-gradient(circle, #5C8374 1px, transparent 1px);
            background-size: 30px 30px;
            background-position: 0 0, 10px 10px; 
            background-color: #fff; 
            padding-bottom: 100px;        
            padding-left: 200px;
            font-family: 'Montserrat', sans-serif;
        }
        h2{
            padding-bottom: 10px;
            color: #fff;
            font-size: 20px;
            font-weight: 500;
        }
        .list-group-item {
            cursor: pointer;
        }

        button {
            margin-top: 33px;
            margin-right: 20px;
        }

        #searchPlant {
            width: 100%;
        }

        .form-row {
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        
        @media (min-width: 576px) {
            .form-row {
                max-width: 1500px; 
                margin: auto;
            }
        }
        /* New styles for displaying top 10 most clicked plants */
        #topClickedContainer {
            overflow: hidden;
            position: relative;
        }

        #topClickedPlants {
            display: flex;
            gap: 20px;
            white-space: nowrap;
            animation: scrollAnimation 20s linear infinite;
            cursor: grab;
        }

        .top-plant-card {
            flex: 0 0 calc(30% - 20px);
            max-width: calc(30% - 20px);
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 10px;
            transition: transform 0.3s ease-out;
        }

        .top-plant-card img {
            max-width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 5px;
        }

        .top-plant-card h5 {
            margin-top: 10px;
            color: #007bff;
        }

        /* Animation for the most clicked plants */
        @keyframes scrollAnimation {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(calc(-100% + (30% - 20px)));
            }
        }

        .top-plant-card:hover {
            transform: scale(1.1);
        }
        .scrollable-content {
            display: flex;
            gap: 20px;
            transition: transform 30s linear;
            animation: scrollAnimation 30s linear infinite;
            will-change: transform;
        } 
        label{
            color: #fff;
        }
    </style>
<body>
    <?php include("bg.php"); ?>
    
    <div class="container mt-5">
        <div class="row">
            <?php if (count($blogs) > 0): ?>
                <?php foreach ($blogs as $blog): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <?php if (!empty($blog['blog_pic'])): ?>
                                <img src="data:image/jpeg;base64,<?php echo base64_encode(file_get_contents($blog['blog_pic'])); ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="Blog Image">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><a href="view_blog.php?blogID=<?php echo $blog['blogID']; ?>"><?php echo $blog['blog_title']; ?></a></h5>
                                <p class="card-text"><b>Content: </b><?php echo $blog['blog_content']; ?></p>
                                <p class="card-text"><small class="text-muted"><b>Filed Under: </b><?php echo $blog['blog_cat']; ?> | Date: <?php echo $blog['dateTime_created']; ?></small></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col">
                    <p>No blogs available.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>