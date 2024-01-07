<?php include("navbar.php");?>
<div class="container mt-3">
    <form action="find_plants.php" method="GET" class="mb-3">
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
                event.preventDefault(); // Prevent form submission

                handleInput();
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
</head>
<style>
    body {
        font-family: 'Montserrat', sans-serif;
    }
    .card {
        height: 100%;
    }

    .card-body {
        height: 300px;
        overflow: hidden;
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